<?php
// Mulai sesi
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Include file konfigurasi database
include 'config.php';

// Mendapatkan data dari form
$new_username = trim($_POST['new_username']);
$new_password = hash('sha256', trim($_POST['new_password']));
 // Hash password untuk keamanan
$current_username = $_SESSION['username'];

// Periksa apakah username baru sudah ada
$stmt = $conn->prepare("SELECT * FROM suket_admin WHERE username = ?");
$stmt->bind_param("s", $new_username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Username sudah ada, redirect dengan pesan error
    $stmt->close();
    header("Location: ganti-password.php?error=username_exists");
    exit();
}

// Perbarui username dan password di database
$stmt = $conn->prepare("UPDATE suket_admin SET username = ?, password = ? WHERE username = ?");
$stmt->bind_param("sss", $new_username, $new_password, $current_username);

if ($stmt->execute()) {
    // Hapus session untuk logout
    session_unset(); // Hapus semua variabel session
    session_destroy(); // Hancurkan sesi

    // Redirect ke halaman index.php setelah logout
    header("Location: index.php?success=true");
    exit(); // Pastikan skrip berhenti setelah header
} else {
    // Jika ada kesalahan, tampilkan error
    echo "Error: " . $stmt->error;
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>
