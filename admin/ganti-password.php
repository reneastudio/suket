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

// Cek login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Sekarang $conn seharusnya sudah terdefinisi
if (!isset($conn)) {
    die("Koneksi database tidak tersedia");
}

if (isset($_GET['error']) && $_GET['error'] == 'username_exists') {
    echo "<p style='color: red;'>Error: Username sudah digunakan!</p>";
} elseif (isset($_GET['success']) && $_GET['success'] == 'true') {
    echo "<p style='color: green;'>Username dan password berhasil diperbarui!</p>";
}
?>
<?php include 'header.php'; ?>

<div class="admin title-page">
<div class="container">
<div class="row">
    <div class="col">
    <h1 class="frontpage-title">
        Ubah <br> Username &amp; Password
    </h1>
    </div>
</div>
</div>
</div>
  
  <div class="admin container formulir">
      <div class="grey form-bg rounded shadow">
            <div class="p-4">
            <div class="card text-bg-white border rounded">
                <div class="card-body mb-4">
            <form action="update-password.php" method="POST">
                    <div class="form-group">
                        <label for="new_username">Username baru</label>
                        <input type="text" name="new_username" id="new_username" class="form-control" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Password baru</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                    </div>
                    <button type="submit" name="update" class="formulir btn btn-success">Ubah</button>
                </form>
                </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/load-data-desa-suket.js"></script>

</body>

</html>