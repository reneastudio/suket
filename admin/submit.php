<?php
// Aktifkan error reporting di awal script
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

try {
    // Include file konfigurasi database
    if (!file_exists('config.php')) {
        throw new Exception("File config.php tidak ditemukan");
    }
    
    include 'config.php';
    
    // Verifikasi koneksi database
    if (!$conn) {
        throw new Exception("Koneksi database gagal");
    }
    
    if ($conn->connect_error) {
        throw new Exception("Koneksi database error: " . $conn->connect_error);
    }

    // Field yang wajib diisi
    $required_fields = [
        'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 
        'jenis_kelamin', 'alamat', 'rt', 'rw', 'dusun', 
        'desa', 'kecamatan', 'kabupaten', 'propinsi'
    ];
    
    // Validasi field wajib
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Field $field harus diisi");
        }
    }

    // Field yang tidak wajib diisi
    $optional_fields = [
        'nama_usaha', 'keterangan_usaha', 'agama', 
        'status_perkawinan', 'pekerjaan'
    ];
    
    // Ambil data dari formulir
    $data = [];
    foreach ($required_fields as $field) {
        $data[$field] = $_POST[$field];
    }
    
    foreach ($optional_fields as $field) {
        // Jika field kosong, set sebagai NULL
        $data[$field] = !empty($_POST[$field]) ? $_POST[$field] : NULL;
    }

    // Periksa apakah NIK sudah ada di database
    $stmt = $conn->prepare("SELECT * FROM userdata WHERE nik = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("s", $data['nik']);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Jika NIK sudah ada, redirect dengan error
        header("Location: data-input.php?error=nik_exists");
        exit();
    }

    // Jika NIK belum ada, lanjutkan dengan penyimpanan data
    $stmt = $conn->prepare("INSERT INTO userdata (
        nik, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, 
        alamat, rt, rw, dusun, desa, kecamatan, kabupaten, propinsi,
        nama_usaha, keterangan_usaha, agama, status_perkawinan, pekerjaan
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?
    )");
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    // Binding parameter dengan NULL untuk field opsional yang kosong
    $stmt->bind_param(
        "ssssssssssssssssss",
        $data['nik'],
        $data['nama_lengkap'],
        $data['tempat_lahir'],
        $data['tanggal_lahir'],
        $data['jenis_kelamin'],
        $data['alamat'],
        $data['rt'],
        $data['rw'],
        $data['dusun'],
        $data['desa'],
        $data['kecamatan'],
        $data['kabupaten'],
        $data['propinsi'],
        $data['nama_usaha'],
        $data['keterangan_usaha'],
        $data['agama'],
        $data['status_perkawinan'],
        $data['pekerjaan'],
    );

    if ($stmt->execute()) {
        // Data berhasil disimpan
        $_SESSION['success_message'] = "Data penduduk berhasil disimpan!";
        header("Location: data-input.php");
        exit();
    } else {
        throw new Exception("Error: " . $stmt->error);
    }

} catch (Exception $e) {
    // Tangani error dan tampilkan pesan
    $_SESSION['error_message'] = "Terjadi kesalahan: " . $e->getMessage();
    header("Location: data-input.php");
    exit();
}

// Menutup statement dan koneksi
if (isset($stmt)) $stmt->close();
if (isset($conn)) $conn->close();
?>