<?php
// Mulai sesi jika belum ada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include konfigurasi database
include 'config.php';

// Ambil data desa
$query = "SELECT * FROM data_desa LIMIT 1";
$result = $conn->query($query);
$data_desa = $result->num_rows > 0 ? $result->fetch_assoc() : null;


// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// AMBIL DATA DESA UNTUK LOGO
$logo_query = "SELECT logo_desa FROM data_desa LIMIT 1";
$logo_result = $conn->query($logo_query);
$data_desa = $logo_result->num_rows > 0 ? $logo_result->fetch_assoc() : null;
$logo_result->free();

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nik'])) {
    $nik = $_POST['nik'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $rt = $_POST['rt'];
    $rw = $_POST['rw'];
    $dusun = $_POST['dusun'];
    $desa = $_POST['desa'];
    $kecamatan = $_POST['kecamatan'];
    $kabupaten = $_POST['kabupaten'];
    $propinsi = $_POST['propinsi'];

    // Update data di database
    $update_query = "UPDATE userdata SET 
        nama_lengkap = ?, 
        tempat_lahir = ?, 
        tanggal_lahir = ?, 
        jenis_kelamin = ?, 
        alamat = ?,
        rt = ?, 
        rw = ?, 
        dusun = ?, 
        desa = ?, 
        kecamatan = ?, 
        kabupaten = ?, 
        propinsi = ? 
        WHERE nik = ?";
    
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssssssssss", 
        $nama_lengkap, 
        $tempat_lahir, 
        $tanggal_lahir, 
        $jenis_kelamin,
        $alamat, 
        $rt, 
        $rw, 
        $dusun, 
        $desa, 
        $kecamatan, 
        $kabupaten, 
        $propinsi, 
        $nik);
    
    if ($stmt->execute()) {
        $success_message = "Data dengan NIK $nik berhasil diperbarui!";
    } else {
        $error_message = "Gagal memperbarui data: " . $conn->error;
    }
}

// Konfigurasi paginasi
$records_per_page = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Ambil parameter pencarian jika ada
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Hitung total records untuk paginasi
$count_query = "SELECT COUNT(*) AS total FROM userdata";
if (!empty($search)) {
    $count_query .= " WHERE NIK LIKE ? OR nama_lengkap LIKE ?";
}

$count_stmt = $conn->prepare($count_query);
if (!empty($search)) {
    $search_param = "%$search%";
    $count_stmt->bind_param("ss", $search_param, $search_param);
}
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_records = $count_result->fetch_assoc()['total'];
$count_stmt->close();

$total_pages = ceil($total_records / $records_per_page);
if ($page > $total_pages && $total_pages > 0) $page = $total_pages;

$offset = ($page - 1) * $records_per_page;

// Query data dengan filter pencarian dan paginasi
$query = "SELECT nama_lengkap, NIK, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, rt, rw, dusun, desa, kecamatan, kabupaten, propinsi 
          FROM userdata";
          
if (!empty($search)) {
    $query .= " WHERE NIK LIKE ? OR nama_lengkap LIKE ?";
}

$query .= " LIMIT ?, ?";

$stmt = $conn->prepare($query);

if (!empty($search)) {
    $search_param = "%$search%";
    $stmt->bind_param("ssii", $search_param, $search_param, $offset, $records_per_page);
} else {
    $stmt->bind_param("ii", $offset, $records_per_page);
}

$stmt->execute();
$result = $stmt->get_result();

include 'header.php';
?>

<div class="admin title-page">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="frontpage-title">
                    Daftar Penduduk
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="container formulir">
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    
    <div class="grey form-bg rounded shadow">
            <div class="p-4 auto-fill">
            <div class="auto-fill-form card text-bg-white border rounded">
        <div class="card-body">
            <!-- Form Pencarian -->
            <div class="mb-4">
                <form method="GET" action="" class="row g-3">
                    <input type="hidden" name="page" value="1">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan NIK atau Nama Lengkap..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-2 d-grid gap-2 d-md-flex justify-content-md-end">

                        <button type="submit" class="btn btn-success">Cari</button>
                        <a href="?" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
            
            <!-- Info Paginasi -->
            <div class="mb-3">
                Menampilkan <?php echo ($result->num_rows > 0) ? ($offset + 1) : 0; ?> - <?php echo min($offset + $result->num_rows, $total_records); ?> dari <?php echo $total_records; ?> data
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Tempat/Tgl Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['NIK']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($row['tempat_lahir']); ?>, 
                                        <?php echo date('d-m-Y', strtotime($row['tanggal_lahir'])); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($row['alamat']); ?>, 
                                        <?php echo htmlspecialchars($row['dusun']); ?> RT <?php echo htmlspecialchars($row['rt']); ?>/RW <?php echo htmlspecialchars($row['rw']); ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['NIK']; ?>">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Modal Edit untuk setiap data -->
                                <div class="modal fade" id="editModal<?php echo $row['NIK']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['NIK']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel<?php echo $row['NIK']; ?>">Edit Data Penduduk</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="">
                                                <div class="modal-body">
                                                    <input type="hidden" name="nik" value="<?php echo htmlspecialchars($row['NIK']); ?>">
                                                    
                                                    <div class="row">
                                                        <!-- Kolom Pertama -->
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">NIK</label>
                                                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['NIK']); ?>" readonly>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Lengkap</label>
                                                                <input type="text" class="form-control" name="nama_lengkap" value="<?php echo htmlspecialchars($row['nama_lengkap']); ?>" required>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Tempat Lahir</label>
                                                                <input type="text" class="form-control" name="tempat_lahir" value="<?php echo htmlspecialchars($row['tempat_lahir']); ?>" required>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Tanggal Lahir</label>
                                                                <input type="date" class="form-control" name="tanggal_lahir" value="<?php echo htmlspecialchars($row['tanggal_lahir']); ?>" required>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Jenis Kelamin</label>
                                                                <select class="form-select" name="jenis_kelamin" required>
                                                                    <option value="Laki-laki" <?php echo ($row['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                                                    <option value="Perempuan" <?php echo ($row['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Alamat</label>
                                                                <textarea class="form-control" name="alamat" required><?php echo htmlspecialchars($row['alamat']); ?></textarea>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Kolom Kedua -->
                                                        <div class="col-md-6">
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">RT</label>
                                                                    <input type="text" class="form-control" name="rt" value="<?php echo htmlspecialchars($row['rt']); ?>" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label">RW</label>
                                                                    <input type="text" class="form-control" name="rw" value="<?php echo htmlspecialchars($row['rw']); ?>" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Dusun</label>
                                                                <input type="text" class="form-control" name="dusun" value="<?php echo htmlspecialchars($row['dusun']); ?>" required>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Desa</label>
                                                                <input type="text" class="form-control" name="desa" value="<?php echo htmlspecialchars($row['desa']); ?>" required>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Kecamatan</label>
                                                                <input type="text" class="form-control" name="kecamatan" value="<?php echo htmlspecialchars($row['kecamatan']); ?>" required>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Kabupaten</label>
                                                                <input type="text" class="form-control" name="kabupaten" value="<?php echo htmlspecialchars($row['kabupaten']); ?>" required>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Provinsi</label>
                                                                <input type="text" class="form-control" name="propinsi" value="<?php echo htmlspecialchars($row['propinsi']); ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data ditemukan <?php echo !empty($search) ? 'untuk pencarian "' . htmlspecialchars($search) . '"' : ''; ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="container content">
            
            <!-- Navigasi Paginasi -->
            <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=1&search=<?php echo urlencode($search); ?>" aria-label="First">
                                <span aria-hidden="true">&laquo;&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo ($page - 1); ?>&search=<?php echo urlencode($search); ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php 
                    // Tampilkan maksimal 5 halaman di sekitar halaman aktif
                    $start_page = max(1, $page - 2);
                    $end_page = min($total_pages, $page + 2);
                    
                    if ($start_page > 1) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    
                    for ($i = $start_page; $i <= $end_page; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; 
                    
                    if ($end_page < $total_pages) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo ($page + 1); ?>&search=<?php echo urlencode($search); ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $total_pages; ?>&search=<?php echo urlencode($search); ?>" aria-label="Last">
                                <span aria-hidden="true">&raquo;&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php endif; ?>
</div>

<?php 
// Bebaskan memori hasil query
$result->free();
$stmt->close();

include 'footer.php'; 
?>
<script>
    // Pastikan modal diinisialisasi dengan benar
document.addEventListener('DOMContentLoaded', function() {
    var modals = document.querySelectorAll('.modal');
    
    modals.forEach(function(modal) {
        modal.addEventListener('shown.bs.modal', function() {
            // Force reflow untuk memastikan modal tampil
            modal.style.display = 'block';
            modal.classList.add('show');
        });
    });
});
</script>
<script src="../assets/js/app.js"></script>
<script src="../assets/js/load-data-desa-suket.js"></script>
</body>
</html>