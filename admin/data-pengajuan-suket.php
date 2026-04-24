<?php
// Mulai session dan cek login
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include file konfigurasi database
require_once 'config.php'; // Pastikan $conn tersedia

// Ambil data desa (jika diperlukan oleh header.php)
$query_data_desa = "SELECT * FROM data_desa LIMIT 1";
$result_data_desa = $conn->query($query_data_desa);
$data_desa = $result_data_desa->num_rows > 0 ? $result_data_desa->fetch_assoc() : null;

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// --- Logika untuk menandai surat sebagai sudah dibaca ---
// Simpan ID surat yang statusnya diubah untuk penandaan visual
$_SESSION['newly_read_ids'] = [];
// Pertama, ambil semua ID surat yang belum dibaca (termasuk yang NULL)
$query_get_unread = "SELECT id FROM surat WHERE sudah_dibaca = 0 OR sudah_dibaca IS NULL";
$result_get_unread = $conn->query($query_get_unread);
if ($result_get_unread && $result_get_unread->num_rows > 0) {
    while ($row_unread = $result_get_unread->fetch_assoc()) {
        $_SESSION['newly_read_ids'][] = $row_unread['id'];
    }
    // Kemudian, update statusnya menjadi sudah dibaca (termasuk yang NULL)
    $query_update_status = "UPDATE surat SET sudah_dibaca = 1 WHERE sudah_dibaca = 0 OR sudah_dibaca IS NULL";
    if (!$conn->query($query_update_status)) {
        // Handle error jika update gagal, misalnya log error
        // error_log("Gagal update status sudah_dibaca: " . $conn->error);
    }
}
// --- Akhir logika menandai surat ---

// --- Logika Paginasi ---
$limit = 50; // Jumlah surat per halaman
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk menghitung total surat
$query_total = "SELECT COUNT(*) as total FROM surat";
$result_total = $conn->query($query_total);
$total_surat = 0;
if ($result_total && $result_total->num_rows > 0) {
    $total_surat = $result_total->fetch_assoc()['total'];
}
$total_pages = ceil($total_surat / $limit);
// --- Akhir Logika Paginasi ---

// Ambil data pengajuan surat dengan paginasi
$query_surat = "SELECT id, nama_lengkap, nik, jenis_surat, tanggal_buat, file_path, sudah_dibaca FROM surat ORDER BY tanggal_buat DESC LIMIT ? OFFSET ?";
$stmt_surat = $conn->prepare($query_surat);
$stmt_surat->bind_param("ii", $limit, $offset);
$stmt_surat->execute();
$result_surat = $stmt_surat->get_result();

include 'header.php'; 
?>

<div class="admin title-page">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="frontpage-title">
                    Data Pengajuan Surat Keterangan
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="admin container formulir">
    <div class="grey form-bg rounded shadow mb-4">
            <div class="p-4">
            <div class="rounded">
    <div class="row rounded">
        <div class="col">
            <div class="card p-4 border rounded">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pemohon</th>
                                    <th>NIK Pemohon</th>
                                    <th>Jenis Surat</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_surat && $result_surat->num_rows > 0) {
                                    $nomor = $offset + 1;
                                    // Fungsi untuk format tanggal dengan bulan Indonesia
                                    if (!function_exists('formatTanggalIndonesia')) {
                                        function formatTanggalIndonesia($tanggal) {
                                            if (empty($tanggal)) return '-';
                                            $bulanIndonesia = [
                                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                            ];
                                            $timestamp = strtotime($tanggal);
                                            if ($timestamp === false) return '-';
                                            $hari = date('d', $timestamp);
                                            $bulan = $bulanIndonesia[(int)date('m', $timestamp)];
                                            $tahun = date('Y', $timestamp);
                                            return "$hari $bulan $tahun";
                                        }
                                    }

                                    while ($row_surat = $result_surat->fetch_assoc()) {
                                        $row_class = '';
                                        // Cek apakah surat ini baru saja dibaca pada sesi ini
                                        if (isset($_SESSION['newly_read_ids']) && in_array($row_surat['id'], $_SESSION['newly_read_ids'])) {
                                            $row_class = 'table-info'; // Class Bootstrap untuk highlight biru muda
                                        }

                                        echo "<tr class='" . $row_class . "'>";
                                        echo "<td>" . $nomor++ . "</td>";
                                        echo "<td><span class='fw-bold'>" . htmlspecialchars($row_surat['nama_lengkap'] ?: '-') . "</span></td>";
                                        echo "<td>" . htmlspecialchars($row_surat['nik'] ?: '-') . "</td>"; 
                                        echo "<td>" . htmlspecialchars($row_surat['jenis_surat'] ?: '-') . "</td>";
                                        echo "<td>" . formatTanggalIndonesia($row_surat['tanggal_buat']) . "</td>";
                                        if (!empty($row_surat['file_path'])) {
                                            $filePath = '../' . $row_surat['file_path']; 
                                            if (file_exists($filePath)) {
                                                echo "<td><a href='" . htmlspecialchars($filePath) . "' class='link-success text-decoration-none' target='_blank'>Unduh PDF</a></td>";
                                            } else {
                                                echo "<td>PDF tidak ditemukan</td>";
                                            }
                                        } else {
                                            echo "<td>Tidak ada PDF</td>";
                                        }
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>Belum ada pengajuan surat.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <div class="row">
        <div class="col">
            <small class="fw-light text-muted">* Data dan file PDF akan terhapus secara otomatis setelah 14 hari. Sedangkan file PDF di email Anda akan tetap tersimpan selama tidak dihapus.</small>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <!-- Navigasi Paginasi -->
            <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>">Sebelumnya</a>
                        </li>
                    <?php endif; ?>
    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
    
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>">Berikutnya</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php endif; ?>
            <!-- Akhir Navigasi Paginasi -->
        </div>
    </div>
</div>

<?php 
// Bersihkan session setelah digunakan untuk highlight
if (isset($_SESSION['newly_read_ids'])) {
    unset($_SESSION['newly_read_ids']);
}
include 'footer.php'; 
?>

<script src="../assets/js/app.js"></script>
<script src="../assets/js/load-data-desa-suket.js"></script>
<script>
    // Script tambahan jika diperlukan
</script>
</body>
</html>
