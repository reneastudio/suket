<?php
// Mulai sesi
session_start();

// Include file konfigurasi database
include 'config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Gunakan BINARY di query SQL untuk case-sensitive username comparison
    $stmt = $conn->prepare("SELECT * FROM suket_admin WHERE BINARY username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password menggunakan SHA2 (case-sensitive)
        if (hash('sha256', $password) == $row['password']) {
            // Regenerasi ID sesi untuk mencegah session fixation
            session_regenerate_id(true);

            // Set session jika login berhasil
            $_SESSION['username'] = $row['username'];
            $_SESSION['loggedin'] = true; // Menandakan bahwa user sudah login
            header("Location: dashboard.php"); // Redirect ke halaman dashboard.php
            $stmt->close();
            exit;
        } else {
            // Password salah
            $stmt->close();
            header("Location: index.php?error=password");
            exit;
        }
    } else {
        $stmt->close();
        // Username tidak ditemukan
        header("Location: index.php?error=username");
        exit;
    }
}

$conn->close();
?>
