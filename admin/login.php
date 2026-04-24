<?php
// Mulai sesi
session_start();

// Include file konfigurasi database
include 'config.php';

if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Gunakan BINARY di query SQL untuk case-sensitive username comparison
    $query = "SELECT * FROM suket_admin WHERE BINARY username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password menggunakan SHA2 (case-sensitive)
        if (hash('sha256', $password) == $row['password']) {
            // Set session jika login berhasil
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true; // Menandakan bahwa user sudah login
            header("Location: dashboard.php"); // Redirect ke halaman dashboard.php
            exit;
        } else {
            // Password salah
            header("Location: index.php?error=password");
            exit;
        }
    } else {
        // Username tidak ditemukan
        header("Location: index.php?error=username");
        exit;
    }
}

$conn->close();
?>
