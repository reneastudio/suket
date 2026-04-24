<?php
// Mulai session dan cek login (jika diperlukan)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include file konfigurasi database
require_once 'config.php';

// Ambil data desa
$query = "SELECT * FROM data_desa LIMIT 1";
$result = $conn->query($query);
$data_desa = $result->num_rows > 0 ? $result->fetch_assoc() : null;

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'header.php'; 
?>

<div class="admin title-page">
<div class="container">
<div class="row">
    <div class="col">
    <h1 class="frontpage-title">
        Input Penduduk Baru
    </h1>
    </div>
</div>
</div>
</div>
  
<div class="container formulir">
    <!-- Tampilkan pesan sukses/error -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_GET['error']) && $_GET['error'] == 'nik_exists'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Error: NIK sudah ada dalam database!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="import-form grey form-bg rounded shadow mb-4">
            <div class="grey form-bg rounded shadow">
            <div class="p-4 auto-fill">
            <div class="auto-fill-form card text-bg-white border rounded">
            <div class="card-body">
            <h3 style="font-weight: 700;">Import Data dari File</h3>
            <p>Gunakan template berikut untuk memastikan format data yang benar. <a href="template-import-data.csv" download>Unduh Template CSV</a></p>
            <form action="import.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="import_file">Pilih File (CSV)</label>
                    <input type="file" name="import_file" id="import_file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                </div>
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-success">Import Data</button>
                </div>
            </form>
        </div>
        </div>
        </div>
        </div>
    </div>

    <form action="submit.php" method="POST" class="needs-validation" novalidate>
            <div class="grey form-bg rounded shadow">
            <div class="p-4 auto-fill">
            <div class="auto-fill-form card text-bg-white border rounded">
            <div class="card-body">
                <h3 style="font-weight: 700;">Atau Isi Formulir Manual</h3>
                    <div class="form-group">
                        <label for="nik">NIK / Nomor KTP</label>
                        <input type="number" name="nik" id="nik" class="form-control"
                            placeholder="Contoh: 3508071234567890" value="" required>
                    </div>
                    <?php if (isset($_GET['error']) && $_GET['error'] == 'nik_exists') {
                        echo "<p style='color: red;'>Error: NIK sudah ada dalam database!</p>";
                    }
                    ?>
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                            placeholder="Nama lengkap" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                            placeholder="Tempat lahir" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                            placeholder="Tanggal lahir" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat" value=""
                            required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Dusun</label>
                        <input type="text" name="dusun" id="dusun" class="form-control" placeholder="Dusun" value="" required>
                    </div>
                    <div class="row rt-rw">
                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="rt">RT</label>
                                <input type="text" name="rt" id="rt" class="form-control" placeholder="000" value="" required>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="rw">RW</label>
                                <input type="text" name="rw" id="rw" class="form-control" placeholder="000" value="" required
                                   >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desa">Desa</label>
                        <input type="text" name="desa" id="desa" class="form-control" placeholder="Desa" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="kecamatan">Kecamatan</label>
                        <input type="text" name="kecamatan" id="kecamatan" class="form-control" placeholder="Kecamatan"
                            value="" required>
                    </div>
                    <div class="form-group">
                        <label for="kabupaten">Kabupaten</label>
                        <input type="text" name="kabupaten" id="kabupaten" class="form-control" placeholder="Kabupaten"
                            value="" required>
                    </div>
                    <div class="form-group">
                        <label for="propinsi">Propinsi</label>
                        <input type="text" name="propinsi" id="propinsi" class="form-control" placeholder="Propinsi"
                            value="" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="formulir btn btn-success">Masukkan</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    </form>

<!-- Modal untuk menampilkan pesan sukses -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Input Berhasil</h5>
            </div>
            <div class="modal-body">
                Data berhasil disimpan!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="../assets/js/app.js"></script>
<script src="../assets/js/load-data-desa-suket.js"></script>

<script>
// Auto close alert setelah 5 detik
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>

</body>
</html>