<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

// Set header untuk respons JSON
header('Content-Type: application/json');

// Memasukkan file konfigurasi database
require_once '../admin/config.php'; // $conn adalah variabel koneksi mysqli dari file ini

$response = ['success' => false, 'message' => ''];

try {
    // Ambil data desa (asumsi hanya ada 1 baris atau baris pertama yang relevan)
    $result = $conn->query("SELECT alamat_email FROM data_desa ORDER BY id ASC LIMIT 1");
    if (!$result) {
        throw new Exception("Error saat mengambil data desa: " . $conn->error);
    }
    $desa = $result->fetch_assoc();
    $result->free();

    if (!$desa || empty($desa['alamat_email'])) { // Pastikan alamat_email ada dan tidak kosong
        throw new Exception('Alamat email admin tidak ditemukan atau kosong di database data_desa.');
    }
    $alamatEmailAdmin = $desa['alamat_email'];

    // Ambil NIK dari POST data
    $nikPemohon = isset($_POST['nik']) ? preg_replace('/[^a-zA-Z0-9]/', '', $_POST['nik']) : null;
    $namaLengkapPemohon = 'Pemohon'; // Default jika NIK tidak ada atau tidak ditemukan
    $pdfFileName = 'Surat_Keterangan_Menikah.pdf'; // Default PDF name

    if ($nikPemohon && !empty($nikPemohon)) {
        $stmtUser = $conn->prepare("SELECT nama_lengkap FROM userdata WHERE nik = ?");
        if (!$stmtUser) {
            throw new Exception("Error saat menyiapkan statement userdata: " . $conn->error);
        }
        $stmtUser->bind_param('s', $nikPemohon);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();
        $user = $resultUser->fetch_assoc();
        $stmtUser->close();

        if ($user && isset($user['nama_lengkap'])) {
            $namaLengkapPemohon = htmlspecialchars($user['nama_lengkap']);
            // Buat nama file PDF yang lebih informatif
            $pdfFileName = 'Surat_Keterangan_Menikah_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $namaLengkapPemohon) . '_' . $nikPemohon . '_' . time() . '.pdf';
        } else {
             $pdfFileName = 'Surat_Keterangan_Menikah_NIKNotFound_' . $nikPemohon . '_' . time() . '.pdf';
        }
    } else {
        // Handle jika NIK kosong atau tidak ada
        $nikPemohon = null; // Pastikan NIK null jika kosong untuk database
        $pdfFileName = 'Surat_Keterangan_Menikah_NoNIK_' . time() . '.pdf';
    }
    
    $jenisSurat = "Surat Keterangan Menikah"; // Jenis surat untuk suketmenikah
    $tanggalBuat = date('Y-m-d H:i:s');
    $uploadPath = null; // Initialize upload path

    // Proses Upload PDF
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $pdfTmpName = $_FILES['pdf']['tmp_name'];
        $targetDir = "../arsip_surat/"; // Pastikan direktori ini ada dan writable
        
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0775, true)) {
                 error_log("Gagal membuat direktori: " . $targetDir);
                 throw new Exception('Gagal membuat direktori penyimpanan arsip.');
            }
        }
        
        $uploadPath = $targetDir . $pdfFileName;

        if (!move_uploaded_file($pdfTmpName, $uploadPath)) {
            error_log("Gagal memindahkan file PDF dari $pdfTmpName ke $uploadPath");
            throw new Exception('Gagal menyimpan file PDF di server.');
        }
    } else {
        $errCode = isset($_FILES['pdf']['error']) ? $_FILES['pdf']['error'] : 'Tidak ada file';
        error_log("Error upload PDF: " . $errCode);
        throw new Exception('File PDF tidak ditemukan atau ada masalah saat upload. Kode Error: ' . $errCode);
    }

    // Server settings untuk Email
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host       = 'mail.suketdesa.id';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'support@suketdesa.id';
    $mail->Password   = 'rkeblq50PS!';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    //Recipients
    $mail->setFrom('support@suketdesa.id', 'Sistem Informasi Desa');
    $mail->addAddress($alamatEmailAdmin); 

    //Attachments
    $mail->addAttachment($uploadPath, $pdfFileName);

    //Content
    $mail->isHTML(true);
    $mail->Subject = $jenisSurat . ' Baru dari ' . $namaLengkapPemohon;
    $mail->Body    = "Yth. Admin,<br><br>Terlampir adalah " . $jenisSurat . " atas nama <strong>" . $namaLengkapPemohon . "</strong> (NIK: " . ($nikPemohon ?: 'Tidak diketahui') . ") yang telah dibuat melalui sistem.<br>File juga telah diarsipkan di server.<br><br>Terima kasih.";
    $mail->AltBody = "Yth. Admin, Terlampir adalah " . $jenisSurat . " atas nama " . $namaLengkapPemohon . " (NIK: " . ($nikPemohon ?: 'Tidak diketahui') . ") yang telah dibuat melalui sistem. File juga telah diarsipkan di server. Terima kasih.";

    $mail->send();

    // Setelah email berhasil dikirim dan PDF disimpan, simpan data ke tabel 'surat'
    try {
        $relativePathForDb = 'arsip_surat/' . $pdfFileName;

        $stmtInsertSurat = $conn->prepare("INSERT INTO surat (nama_lengkap, nik, jenis_surat, tanggal_buat, file_path) VALUES (?, ?, ?, ?, ?)");
        if (!$stmtInsertSurat) {
            throw new Exception("Error saat menyiapkan statement insert surat: " . $conn->error);
        }
        $nikToInsert = $nikPemohon ?: null;

        $stmtInsertSurat->bind_param('sssss', $namaLengkapPemohon, $nikToInsert, $jenisSurat, $tanggalBuat, $relativePathForDb);
        
        if (!$stmtInsertSurat->execute()) {
            throw new Exception("Gagal mengeksekusi statement insert surat: " . $stmtInsertSurat->error);
        }
        $stmtInsertSurat->close();
        
        $response['success'] = true;
        $response['message'] = 'Proses berhasil: Email terkirim, PDF disimpan, dan data dicatat ke database.';

    } catch (Exception $dbExc) {
        error_log("Gagal menyimpan ke tabel surat: " . $dbExc->getMessage());
        $response['success'] = true; 
        $response['message'] = 'Email terkirim dan PDF disimpan, tetapi gagal mencatat ke database. Silakan cek log server untuk detail.';
        $response['db_error_detail'] = $dbExc->getMessage(); 
    }

    echo json_encode($response);

} catch (Exception $e) { 
    http_response_code(500); 
    $response['success'] = false; 
    $response['message'] = "Terjadi kesalahan utama: {$e->getMessage()}";
    if (method_exists($e, 'getFile') && method_exists($e, 'getLine')) {
        $response['message'] .= " (File: " . basename($e->getFile()) . ", Line: " . $e->getLine() . ")";
    }
    error_log("Error utama dalam save_and_send_email.php: " . $response['message']); 
    echo json_encode($response);
}
?>
