<?php
// cron_delete_old_surat.php
// Script untuk menghapus data surat dan file PDF yang lebih tua dari 14 hari.

// --- KONFIGURASI ---
// Sesuaikan path ke file config.php jika script ini tidak berada di root proyek
require_once 'admin/config.php'; // Menggunakan $conn dari config.php

// Sesuaikan path dasar ke direktori root aplikasi Anda jika diperlukan.
// Ini digunakan untuk membangun path absolut ke file PDF.
// Jika script ini ada di root proyek, __DIR__ biasanya sudah cukup.
$project_root_path = __DIR__; // Direktori tempat script ini berada

// Aktifkan logging ke file (opsional)
$enable_file_logging = true;
$log_file = $project_root_path . '/cron_delete_log.txt'; // Pastikan direktori ini writable oleh user cron

// --- Fungsi Logging ---
function log_message($message, $log_file_path = null, $to_console = true) {
    $timestamp = date("Y-m-d H:i:s");
    $log_entry = "[{$timestamp}] " . $message . PHP_EOL;

    if ($to_console) {
        echo $log_entry;
    }

    if ($log_file_path && file_put_contents($log_file_path, $log_entry, FILE_APPEND) === false) {
        echo "[{$timestamp}] ERROR: Tidak dapat menulis ke file log: {$log_file_path}" . PHP_EOL;
    }
}

log_message("Memulai script penghapusan surat lama...", $enable_file_logging ? $log_file : null);

// --- Validasi Tanggal Eksekusi ---
// Cek apakah hari ini adalah hari terakhir dalam bulan ini
$today = date('Y-m-d');
$last_day_of_month = date('Y-m-t', strtotime($today));

if ($today !== $last_day_of_month) {
    log_message("Hari ini bukan hari terakhir bulan ini. Script tidak akan dijalankan.", $enable_file_logging ? $log_file : null);
    exit(0); // Keluar dengan sukses tanpa melakukan apa-apa
}

log_message("Hari ini adalah hari terakhir bulan ini. Melanjutkan proses rekapitulasi dan penghapusan.", $enable_file_logging ? $log_file : null);


// --- KONEKSI DATABASE ---
// $conn sudah tersedia dari require_once 'admin/config.php';
if (!$conn) {
    log_message("ERROR: Gagal terhubung ke database.", $enable_file_logging ? $log_file : null);
    exit(1);
}

// Set zona waktu untuk konsistensi (opsional, tergantung konfigurasi server/DB Anda)
// date_default_timezone_set('Asia/Jakarta'); // Contoh

// --- PROSES PENGHAPUSAN ---
try {
    // Menentukan bulan dan tahun yang akan diproses (bulan sebelumnya)
    $first_day_of_current_month = date('Y-m-01');
    $target_date_time = strtotime($first_day_of_current_month . ' -1 month');
    $target_year = date('Y', $target_date_time);
    $target_month = date('m', $target_date_time);

    log_message("Mempersiapkan rekapitulasi dan penghapusan untuk data dari: {$target_year}-{$target_month}", $enable_file_logging ? $log_file : null);

    // 1. Ambil semua data surat dari bulan target
    $stmt_select = $conn->prepare("SELECT id, file_path, nama_lengkap, jenis_surat, tanggal_buat FROM surat WHERE YEAR(tanggal_buat) = ? AND MONTH(tanggal_buat) = ?");
    if (!$stmt_select) {
        log_message("ERROR SQL (prepare select): " . $conn->error, $enable_file_logging ? $log_file : null);
        exit(1);
    }
    $stmt_select->bind_param("ii", $target_year, $target_month);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    $deleted_count = 0;
    $file_deleted_count = 0;
    $file_missing_count = 0;
    $failed_db_delete_count = 0;
    $failed_file_delete_count = 0;
    
    $monthly_counts = []; // Array untuk menyimpan agregasi jumlah surat per bulan dan jenis

    if ($result->num_rows > 0) {
        log_message("Ditemukan " . $result->num_rows . " surat untuk diproses (penghapusan dan rekapitulasi).", $enable_file_logging ? $log_file : null);
        
        // Loop untuk mengumpulkan data untuk rekapitulasi SEBELUM menghapus
        $records_to_delete = [];
        while ($row = $result->fetch_assoc()) {
            $records_to_delete[] = $row; // Simpan record untuk diproses nanti

            // Ambil tahun dan bulan dari tanggal_buat
            $tanggal_buat_dt = new DateTime($row['tanggal_buat']);
            $year = (int)$tanggal_buat_dt->format('Y');
            $month = (int)$tanggal_buat_dt->format('m');
            $jenis_surat = $row['jenis_surat'] ? $row['jenis_surat'] : 'Tidak Diketahui';

            // Buat kunci unik untuk array agregasi
            $key = $year . "-" . $month . "-" . $jenis_surat;

            if (!isset($monthly_counts[$key])) {
                $monthly_counts[$key] = [
                    'year' => $year,
                    'month' => $month,
                    'jenis_surat' => $jenis_surat,
                    'count' => 0
                ];
            }
            $monthly_counts[$key]['count']++;
        }
        $stmt_select->close(); // Tutup statement select setelah selesai mengambil data

        // Menyimpan atau memperbarui data rekapitulasi bulanan
        if (!empty($monthly_counts)) {
            log_message("Memulai penyimpanan rekapitulasi bulanan...", $enable_file_logging ? $log_file : null);
            $stmt_summary = $conn->prepare("INSERT INTO monthly_surat_summary (year, month, jenis_surat, count) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE count = count + VALUES(count)");
            if (!$stmt_summary) {
                log_message("ERROR SQL (prepare summary insert/update): " . $conn->error, $enable_file_logging ? $log_file : null);
                // Pertimbangkan apakah akan menghentikan script atau melanjutkan penghapusan
            } else {
                foreach ($monthly_counts as $summary_data) {
                    $stmt_summary->bind_param("iisi", $summary_data['year'], $summary_data['month'], $summary_data['jenis_surat'], $summary_data['count']);
                    if ($stmt_summary->execute()) {
                        log_message("Rekapitulasi untuk {$summary_data['jenis_surat']} ({$summary_data['year']}-{$summary_data['month']}) disimpan/diperbarui: {$summary_data['count']} surat.", $enable_file_logging ? $log_file : null);
                    } else {
                        log_message("ERROR: Gagal menyimpan rekapitulasi untuk {$summary_data['jenis_surat']} ({$summary_data['year']}-{$summary_data['month']}). Error: " . $stmt_summary->error, $enable_file_logging ? $log_file : null);
                    }
                }
                $stmt_summary->close();
            }
        }

        // Sekarang lakukan proses penghapusan
        log_message("Memulai proses penghapusan data dan file lama...", $enable_file_logging ? $log_file : null);
        foreach ($records_to_delete as $row) {
            $surat_id = $row['id'];
            $file_name_db = $row['file_path']; 
            $file_deleted = false;
            // $record_deleted = false; // tidak digunakan lagi

            log_message("Memproses Surat ID: {$surat_id} - {$row['jenis_surat']} a/n {$row['nama_lengkap']} (dibuat pada {$row['tanggal_buat']}) untuk penghapusan.", $enable_file_logging ? $log_file : null);

            // 2. Hapus file PDF terkait dari direktori yang ditentukan (misal /arsip_surat/)
            // Pastikan $file_name_db adalah nama file saja, atau path relatif dari $project_root_path
            if (!empty($file_name_db)) {
                // Cek jika file_path adalah path absolut atau relatif
                // Jika file_path sudah merupakan path yang benar dari root atau direktori arsip, gunakan itu.
                // Jika file_path hanya nama file, maka perlu digabungkan dengan path ke folder arsip.
                // Contoh: $absolute_file_path = $project_root_path . '/arsip_surat/' . $file_name_db;
                // Untuk contoh ini, kita asumsikan $file_name_db adalah path relatif dari $project_root_path
                // seperti '/arsip_surat/namafile.pdf'
                
                // Memastikan $file_name_db tidak diawali dengan slash jika $project_root_path sudah diakhiri slash
                // atau sebaliknya, memastikan ada satu slash pemisah.
                $file_name_db_cleaned = ltrim($file_name_db, '/\\');
                $absolute_file_path = rtrim($project_root_path, '/\\') . '/' . $file_name_db_cleaned;
                
                // Jika file_path sudah termasuk nama folder seperti 'arsip_surat/file.pdf'
                // dan $project_root_path adalah root folder, maka path di atas sudah benar.
                // Jika $file_name_db adalah '/arsip_surat/file.pdf' (dengan leading slash)
                // dan $project_root_path adalah '/var/www/html', maka hasilnya akan '/var/www/html/arsip_surat/file.pdf'
                // Sesuaikan logika ini berdasarkan bagaimana $file_path disimpan di database.

                log_message("  Mencoba menghapus file: {$absolute_file_path}", $enable_file_logging ? $log_file : null);
                if (file_exists($absolute_file_path)) {
                // Memastikan $file_name_db tidak diawali dengan slash
                $file_name_db = ltrim($file_name_db, '/');
                // Membangun path absolut ke file di folder arsip_surat dengan aman
                $absolute_file_path = rtrim($project_root_path, '/') . $file_name_db;

                    if (unlink($absolute_file_path)) {
                        log_message("    File berhasil dihapus.", $enable_file_logging ? $log_file : null);
                        $file_deleted = true;
                        $file_deleted_count++;
                    } else {
                        log_message("    ERROR: Gagal menghapus file {$absolute_file_path}. Periksa izin file/folder.", $enable_file_logging ? $log_file : null);
                        $failed_file_delete_count++;
                    }
                } else {
                    log_message("    File tidak ditemukan di {$absolute_file_path}. Mungkin sudah dihapus atau path salah.", $enable_file_logging ? $log_file : null);
                    $file_missing_count++;
                    // Anggap "berhasil" untuk proses lanjut ke penghapusan record DB jika file memang tidak ada
                    // Namun, jika file path ada di DB tapi file fisik tidak ada, ini adalah kondisi khusus.
                    // Untuk tujuan penghitungan, file yang hilang tidak menghalangi penghapusan record DB.
                    $file_deleted = true; 
                }
            } else {
                log_message("  Tidak ada nama file (file_path) yang tersimpan untuk surat ID: {$surat_id}. Melanjutkan ke penghapusan record.", $enable_file_logging ? $log_file : null);
                $file_deleted = true; // Anggap "berhasil" karena tidak ada file untuk dihapus
            }

            // 3. Hapus record dari database jika file berhasil dihapus (atau file tidak ada/nama file kosong)
            if ($file_deleted) {
                $stmt_delete_surat = $conn->prepare("DELETE FROM surat WHERE id = ?");
                if (!$stmt_delete_surat) {
                    log_message("    ERROR SQL (prepare delete surat): " . $conn->error, $enable_file_logging ? $log_file : null);
                    $failed_db_delete_count++;
                    continue; // Lanjut ke surat berikutnya dalam loop penghapusan
                }
                $stmt_delete_surat->bind_param("i", $surat_id);
                if ($stmt_delete_surat->execute()) {
                    log_message("    Record database untuk ID: {$surat_id} berhasil dihapus.", $enable_file_logging ? $log_file : null);
                    $deleted_count++;
                } else {
                    log_message("    ERROR: Gagal menghapus record database untuk ID: {$surat_id}. Error: " . $stmt_delete_surat->error, $enable_file_logging ? $log_file : null);
                    $failed_db_delete_count++;
                }
                $stmt_delete_surat->close();
            }
        } // Akhir loop foreach ($records_to_delete as $row)

        log_message("Proses penghapusan selesai. Total record DB dihapus: {$deleted_count}. Total file fisik dihapus: {$file_deleted_count}. File tidak ditemukan (tapi path ada di DB): {$file_missing_count}. Gagal hapus DB: {$failed_db_delete_count}. Gagal hapus file fisik: {$failed_file_delete_count}.", $enable_file_logging ? $log_file : null);
    
    } else { // if ($result->num_rows > 0)
        log_message("Tidak ada surat yang ditemukan untuk bulan {$target_year}-{$target_month} untuk diproses.", $enable_file_logging ? $log_file : null);
    }
    // $stmt_select sudah ditutup sebelumnya jika ada row. Jika tidak ada, $result->num_rows == 0, dan $stmt_select masih perlu ditutup.
    if ($result->num_rows == 0) {
        $stmt_select->close();
    }
    
    $conn->close();

} catch (Exception $e) {
    log_message("EXCEPTION: " . $e->getMessage(), $enable_file_logging ? $log_file : null);
    if ($conn && $conn->ping()) { // Hanya tutup jika koneksi masih ada dan valid
        $conn->close();
    }
    exit(1);
}

log_message("Script penghapusan surat lama selesai.", $enable_file_logging ? $log_file : null);
exit(0);
?>
