<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['import_file'])) {
    $file = $_FILES['import_file'];

    // Validasi tipe file
    $allowed_mime_types = ['text/csv', 'application/csv'];
    $file_info = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($file_info, $file['tmp_name']);
    finfo_close($file_info);

    if (!in_array($mime_type, $allowed_mime_types)) {
        $_SESSION['error_message'] = "Error: Format file tidak valid. Harap unggah file CSV.";
        header("Location: data-input.php");
        exit();
    }

    $file_handle = fopen($file['tmp_name'], 'r');
    if ($file_handle === FALSE) {
        $_SESSION['error_message'] = "Error: Tidak dapat membuka file yang diunggah.";
        header("Location: data-input.php");
        exit();
    }

    // Baca header
    $header = fgetcsv($file_handle);
    $expected_header = [
        'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 
        'alamat', 'rt', 'rw', 'dusun', 'desa', 'kecamatan', 'kabupaten', 'propinsi',
        'nama_usaha', 'keterangan_usaha', 'agama', 'status_perkawinan', 'pekerjaan'
    ];

    if ($header !== $expected_header) {
        $_SESSION['error_message'] = "Error: Header file CSV tidak sesuai dengan template.";
        fclose($file_handle);
        header("Location: data-input.php");
        exit();
    }

    $success_count = 0;
    $error_count = 0;
    $errors = [];

    $conn->begin_transaction();

    try {
        while (($data = fgetcsv($file_handle)) !== FALSE) {
            $row_data = array_combine($expected_header, $data);

            // Periksa NIK
            $nik = $row_data['nik'];
            if (empty($nik)) {
                $error_count++;
                $errors[] = "Baris " . ($success_count + $error_count + 1) . ": NIK kosong.";
                continue;
            }

            $stmt_check = $conn->prepare("SELECT nik FROM userdata WHERE nik = ?");
            $stmt_check->bind_param("s", $nik);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                $error_count++;
                $errors[] = "Baris " . ($success_count + $error_count + 1) . ": NIK " . $nik . " sudah ada.";
                $stmt_check->close();
                continue;
            }
            $stmt_check->close();

            // Siapkan data untuk insert
            $params = [];
            foreach($expected_header as $key) {
                $params[$key] = !empty($row_data[$key]) ? $row_data[$key] : NULL;
            }

            $stmt_insert = $conn->prepare("INSERT INTO userdata (
                nik, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, 
                alamat, rt, rw, dusun, desa, kecamatan, kabupaten, propinsi,
                nama_usaha, keterangan_usaha, agama, status_perkawinan, pekerjaan
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt_insert->bind_param(
                "ssssssssssssssssss",
                $params['nik'], $params['nama_lengkap'], $params['tempat_lahir'], $params['tanggal_lahir'], 
                $params['jenis_kelamin'], $params['alamat'], $params['rt'], $params['rw'], 
                $params['dusun'], $params['desa'], $params['kecamatan'], $params['kabupaten'], 
                $params['propinsi'], $params['nama_usaha'], $params['keterangan_usaha'], 
                $params['agama'], $params['status_perkawinan'], $params['pekerjaan']
            );

            if ($stmt_insert->execute()) {
                $success_count++;
            } else {
                $error_count++;
                $errors[] = "Baris " . ($success_count + $error_count + 1) . ": Gagal disimpan ke database.";
            }
            $stmt_insert->close();
        }

        $conn->commit();
        $_SESSION['success_message'] = "Import berhasil: " . $success_count . " data berhasil diimpor.";
        if ($error_count > 0) {
            $_SESSION['error_message'] = "Import gagal untuk " . $error_count . " data. Rincian: <br>" . implode("<br>", $errors);
        }

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error_message'] = "Terjadi kesalahan saat import: " . $e->getMessage();
    } finally {
        fclose($file_handle);
    }

} else {
    $_SESSION['error_message'] = "Tidak ada file yang diunggah.";
}

header("Location: data-input.php");
exit();
?>
