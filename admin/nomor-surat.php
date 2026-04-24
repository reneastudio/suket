<?php
// Mulai session dan cek login
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

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nomor_surat = trim($_POST['nomor_surat']);
    
    try {
        $stmt = $conn->prepare("UPDATE nomor_register SET nomor_surat = ? WHERE id = ?");
        $stmt->bind_param("si", $nomor_surat, $id);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Nomor surat berhasil diperbarui!";
        } else {
            throw new Exception("Gagal memperbarui nomor surat: " . $stmt->error);
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Ambil data nomor register
$query = "SELECT * FROM nomor_register ORDER BY nama_surat";
$result = $conn->query($query);
$nomor_register = [];
while ($row = $result->fetch_assoc()) {
    $nomor_register[] = $row;
}

include 'header.php'; 
?>

<div class="admin title-page">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="frontpage-title">
                    Nomor Register Surat
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
    
    <div class="grey form-bg rounded shadow">
            <div class="p-4 auto-fill">
            <div class="auto-fill-form card text-bg-white border rounded">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Jenis Surat</th>
                            <th>Nomor Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($nomor_register as $surat): ?>
                            <tr>
                                <td>
                                    <?php 
                                    // Format nama surat menjadi lebih readable
                                    $nama_surat = str_replace('_', ' ', $surat['nama_surat']);
                                    $nama_surat = str_replace('suket', 'Surat Keterangan', $nama_surat);
                                    echo ucwords($nama_surat); 
                                    ?>
                                </td>
                                <td><?php echo $surat['nomor_surat'] ? $surat['nomor_surat'] : '-'; ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" 
                                        data-bs-target="#editModal<?php echo $surat['id']; ?>">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Modal Edit untuk setiap jenis surat -->
                            <div class="modal fade" id="editModal<?php echo $surat['id']; ?>" tabindex="-1" 
                                aria-labelledby="editModalLabel<?php echo $surat['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?php echo $surat['id']; ?>">
                                                Edit Nomor <?php echo ucwords(str_replace('_', ' ', str_replace('suket', 'Surat Keterangan', $surat['nama_surat']))); ?>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?php echo $surat['id']; ?>">
                                                
                                                <div class="mb-3">
                                                    <label for="nomor_surat<?php echo $surat['id']; ?>" class="form-label">Nomor Surat</label>
                                                    <input type="text" class="form-control" id="nomor_surat<?php echo $surat['id']; ?>" 
                                                        name="nomor_surat" value="<?php echo $surat['nomor_surat']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

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

<script src="../assets/js/app.js"></script>
<script src="../assets/js/load-data-desa-suket.js"></script>

</body>
</html>