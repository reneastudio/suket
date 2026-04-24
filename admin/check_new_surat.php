<?php
// Mulai session dan cek login
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include file konfigurasi database
require_once 'config.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika tidak login, kirim response error
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Query untuk menghitung jumlah surat yang belum dibaca
$query_check_surat = "SELECT COUNT(id) as unread_count FROM surat WHERE sudah_dibaca = 0 OR sudah_dibaca IS NULL";
$result_check_surat = $conn->query($query_check_surat);

$unread_count = 0;
if ($result_check_surat && $result_check_surat->num_rows > 0) {
    $row = $result_check_surat->fetch_assoc();
    $unread_count = (int)$row['unread_count'];
}

// Set header ke JSON dan kirim response
header('Content-Type: application/json');
echo json_encode(['unread_count' => $unread_count]);

// Tutup koneksi
$conn->close();
?>
