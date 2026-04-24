<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include file konfigurasi database
require_once 'config.php';

// Ambil data desa
$query = "SELECT * FROM data_desa LIMIT 1";
$result = $conn->query($query);
$data_desa = $result->num_rows > 0 ? $result->fetch_assoc() : null;

// Cek apakah user sudah login
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Jika sudah login, redirect ke halaman dashboard.php
    header("Location: dashboard.php");
    exit;
}

include 'header.php'; 
?>

<div class="admin title-page">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="frontpage-title">Login</h1>
            </div>
        </div>
    </div>
</div>

<div class="admin container formulir">
      <div class="grey form-bg rounded shadow">
            <div class="p-4">
            <div class="card text-bg-white border rounded">
                <div class="card-body m-4">
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="formulir btn btn-success">Login</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    <div class="admin container formulir mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-5 text-center"><a href="../index.php" class="text-secondary">Kembali ke beranda</a></div>
    </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- Modal untuk menampilkan pesan error -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login Gagal</h5>
            </div>
            <div class="modal-body">
                <p id="errorMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/app.js"></script>
<script src="../assets/js/load-data-desa-suket.js"></script>

</body>
</html>
