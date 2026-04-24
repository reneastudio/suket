<?php
// Koneksi ke database
$host = "localhost";
$username = "pvwurfmb_demo";
$password = "ZPG+Wsag+Quax.IL";
$database = "pvwurfmb_demo";

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
