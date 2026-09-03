<?php
// Mulai session dan cek login (jika diperlukan)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include file konfigurasi database
require_once 'config.php';

// Ensure column qr_tte exists in data_desa table
$check_col = $conn->query("SHOW COLUMNS FROM data_desa LIKE 'qr_tte'");
if ($check_col && $check_col->num_rows == 0) {
    $conn->query("ALTER TABLE data_desa ADD COLUMN qr_tte VARCHAR(255) NULL");
}

// Handler hapus QR Code TTE via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_qr_tte') {
    header('Content-Type: application/json');
    $query = "SELECT qr_tte FROM data_desa LIMIT 1";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['qr_tte'])) {
            $file_path = __DIR__ . "/../assets/images/" . $row['qr_tte'];
            if (file_exists($file_path)) {
                @unlink($file_path);
            }
            $conn->query("UPDATE data_desa SET qr_tte = NULL");
        }
    }
    echo json_encode(['success' => true]);
    exit();
}

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

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi input
    $nama_desa = isset($_POST['nama_desa']) ? trim($_POST['nama_desa']) : '';
    $nama_kepala_desa = isset($_POST['nama_kepala_desa']) ? trim($_POST['nama_kepala_desa']) : '';
    $alamat_balai_desa = isset($_POST['alamat_balai_desa']) ? trim($_POST['alamat_balai_desa']) : '';
    $nomor_whatsapp = isset($_POST['nomor_whatsapp']) ? trim($_POST['nomor_whatsapp']) : '';
    $alamat_email = isset($_POST['alamat_email']) ? trim($_POST['alamat_email']) : '';
    $data_kecamatan = isset($_POST['data_kecamatan']) ? trim($_POST['data_kecamatan']) : '';
    $data_kabupaten = isset($_POST['data_kabupaten']) ? trim($_POST['data_kabupaten']) : '';
    $data_provinsi = isset($_POST['data_provinsi']) ? trim($_POST['data_provinsi']) : '';
    $nip_kepala_desa = isset($_POST['nip_kepala_desa']) ? trim($_POST['nip_kepala_desa']) : '';
    $pj_kepala_desa = isset($_POST['pj_kepala_desa']) ? 1 : 0;
    if (empty($nip_kepala_desa)) {
        $nip_kepala_desa = null;
    }
    
    // Handle file upload
    $upload_dir = __DIR__ . "/../assets/images/";

    // Pastikan folder upload ada dan bisa ditulisi
    if (!file_exists($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            die("Gagal membuat folder upload. Path: " . $upload_dir);
        }
    }

    if (!is_writable($upload_dir)) {
        die("Folder upload tidak bisa ditulisi. Berikan izin dengan: chmod -R 755 " . $upload_dir);
    }

    // Fungsi untuk upload file
    function uploadFile($file, $upload_dir) {
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['error' => 'Error upload file'];
        }
        
        $target_file = $upload_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $imageFileType;
        $destination = $upload_dir . $new_filename;
        
        // Check if file is an actual image
        $check = @getimagesize($file["tmp_name"]);
        if ($check === false) {
            return ['error' => 'File bukan gambar'];
        }
        
        // Check file size (max 2MB)
        if ($file["size"] > 2000000) {
            return ['error' => 'Ukuran file terlalu besar (max 2MB)'];
        }
        
        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            return ['error' => 'Hanya format JPG, JPEG, PNG & GIF yang diizinkan'];
        }
        
        if (move_uploaded_file($file["tmp_name"], $destination)) {
            return ['success' => $new_filename];
        } else {
            return ['error' => 'Gagal mengupload file'];
        }
    }
    
    // Upload logo desa jika ada
    $logo_desa = null;
    if (!empty($_FILES['logo_desa']['name']) && $_FILES['logo_desa']['error'] === UPLOAD_ERR_OK) {
        $upload_result = uploadFile($_FILES['logo_desa'], $upload_dir);
        if (isset($upload_result['error'])) {
            $error = $upload_result['error'];
        } else {
            $logo_desa = $upload_result['success'];
        }
    }
    
    // Upload kop surat jika ada
    $kop_surat = null;
    if (!empty($_FILES['kop_surat']['name']) && $_FILES['kop_surat']['error'] === UPLOAD_ERR_OK) {
        $upload_result = uploadFile($_FILES['kop_surat'], $upload_dir);
        if (isset($upload_result['error'])) {
            $error = $upload_result['error'];
        } else {
            $kop_surat = $upload_result['success'];
        }
    }
    
    // Upload QR Code TTE jika ada
    $qr_tte = null;
    if (!empty($_FILES['qr_tte']['name']) && $_FILES['qr_tte']['error'] === UPLOAD_ERR_OK) {
        $upload_result = uploadFile($_FILES['qr_tte'], $upload_dir);
        if (isset($upload_result['error'])) {
            $error = $upload_result['error'];
        } else {
            $qr_tte = $upload_result['success'];
        }
    }

    try {
        // Cek apakah data sudah ada di database
        $check_query = "SELECT * FROM data_desa LIMIT 1";
        $check_result = $conn->query($check_query);
        
        if ($check_result === false) {
            throw new Exception("Error checking existing data: " . $conn->error);
        }
        
        if ($check_result->num_rows > 0) {
            // Update data yang sudah ada
            $row = $check_result->fetch_assoc();
            $id = $row['id'];
            
            // Jika tidak upload file baru, gunakan file yang lama
            if ($logo_desa === null) $logo_desa = $row['logo_desa'];
            if ($kop_surat === null) $kop_surat = $row['kop_surat'];
            if ($qr_tte === null) $qr_tte = isset($row['qr_tte']) ? $row['qr_tte'] : null;

            $stmt = $conn->prepare("UPDATE data_desa SET 
                nama_desa = ?, 
                nama_kepala_desa = ?, 
                alamat_balai_desa = ?, 
                nomor_whatsapp = ?, 
                alamat_email = ?, 
                logo_desa = ?, 
                kop_surat = ?,
                data_kecamatan = ?,
                data_kabupaten = ?,
                data_provinsi = ?,
                nip_kepala_desa = ?,
                pj_kepala_desa = ?,
                qr_tte = ?
                WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            
            $stmt->bind_param("ssssssssssissi",
                $nama_desa, 
                $nama_kepala_desa, 
                $alamat_balai_desa, 
                $nomor_whatsapp, 
                $alamat_email, 
                $logo_desa, 
                $kop_surat,
                $data_kecamatan,
                $data_kabupaten,
                $data_provinsi,
                $nip_kepala_desa,
                $pj_kepala_desa,
                $qr_tte,
                $id);
        } else {
            // Insert data baru
            $stmt = $conn->prepare("INSERT INTO data_desa (
                nama_desa, 
                nama_kepala_desa, 
                alamat_balai_desa, 
                nomor_whatsapp, 
                alamat_email, 
                logo_desa, 
                kop_surat,
                data_kecamatan,
                data_kabupaten,
                data_provinsi,
                nip_kepala_desa,
                pj_kepala_desa,
                qr_tte)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            
            $stmt->bind_param("sssssssssssis",
                $nama_desa, 
                $nama_kepala_desa, 
                $alamat_balai_desa, 
                $nomor_whatsapp, 
                $alamat_email, 
                $logo_desa, 
                $kop_surat,
                $data_kecamatan,
                $data_kabupaten,
                $data_provinsi,
                $nip_kepala_desa,
                $pj_kepala_desa,
                $qr_tte);
        }
        
        if ($stmt->execute()) {
            $success = "Data desa berhasil disimpan!";
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }
    } catch (Exception $e) {
        $error = "Gagal menyimpan data: " . $e->getMessage();
    }
}

// Ambil data desa yang sudah ada
$query = "SELECT * FROM data_desa LIMIT 1";
$result = $conn->query($query);
if ($result === false) {
    die("Error fetching data: " . $conn->error);
}
$data_desa = $result->num_rows > 0 ? $result->fetch_assoc() : null;

include 'header.php'; 
?>

    <style>
        .img-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>

<div class="admin title-page">
<div class="container">
<div class="row">
    <div class="col">
    <h1 class="frontpage-title">
        Data Desa
    </h1>
    </div>
</div>
</div>
</div>

<div class="container formulir">
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="grey form-bg rounded shadow">
            <div class="p-4 auto-fill">
            <div class="auto-fill-form card text-bg-white border rounded">
            <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_desa" class="form-label">Nama Desa</label>
                            <input type="text" class="form-control" id="nama_desa" name="nama_desa" 
                                value="<?php echo isset($data_desa['nama_desa']) ? $data_desa['nama_desa'] : ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nama_kepala_desa" class="form-label">Nama Kepala Desa</label>
                            <input type="text" class="form-control" id="nama_kepala_desa" name="nama_kepala_desa" 
                                value="<?php echo isset($data_desa['nama_kepala_desa']) ? $data_desa['nama_kepala_desa'] : ''; ?>" required>
                            
                            <input type="checkbox" class="form-check-input" id="pj_kepala_desa" name="pj_kepala_desa" value="1" <?php echo (isset($data_desa['pj_kepala_desa']) && $data_desa['pj_kepala_desa']) ? 'checked' : ''; ?>>
                            <label class="form-check-label text-muted" for="pj_kepala_desa">Centang jika Pj. Kepala Desa</label>
                        </div>

                        <div class="mb-3">
                            <label for="nip_kepala_desa" class="form-label">NIP Kepala Desa</label>
                            <input type="text" class="form-control" id="nip_kepala_desa" name="nip_kepala_desa" 
                                value="<?php echo isset($data_desa['nip_kepala_desa']) ? $data_desa['nip_kepala_desa'] : ''; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="alamat_balai_desa" class="form-label">Alamat Balai Desa</label>
                            <textarea class="form-control" id="alamat_balai_desa" name="alamat_balai_desa" rows="3" required><?php 
                                echo isset($data_desa['alamat_balai_desa']) ? $data_desa['alamat_balai_desa'] : ''; 
                            ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="data_kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" class="form-control" id="data_kecamatan" name="data_kecamatan" 
                                value="<?php echo isset($data_desa['data_kecamatan']) ? $data_desa['data_kecamatan'] : ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="data_kabupaten" class="form-label">Kabupaten</label>
                            <input type="text" class="form-control" id="data_kabupaten" name="data_kabupaten" 
                                value="<?php echo isset($data_desa['data_kabupaten']) ? $data_desa['data_kabupaten'] : ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="data_provinsi" class="form-label">Provinsi</label>
                            <input type="text" class="form-control" id="data_provinsi" name="data_provinsi" 
                                value="<?php echo isset($data_desa['data_provinsi']) ? $data_desa['data_provinsi'] : ''; ?>" required>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="col-md-6"><div class="mb-3">
                            <label for="nomor_whatsapp" class="form-label">Nomor WhatsApp</label>
                            <input type="text" class="form-control" id="nomor_whatsapp" name="nomor_whatsapp" 
                                value="<?php echo isset($data_desa['nomor_whatsapp']) ? $data_desa['nomor_whatsapp'] : ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="alamat_email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="alamat_email" name="alamat_email" 
                                value="<?php echo isset($data_desa['alamat_email']) ? $data_desa['alamat_email'] : ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="logo_desa" class="form-label">Logo Desa</label>
                            <input type="file" class="form-control" id="logo_desa" name="logo_desa" accept="image/*">
                            <?php if (isset($data_desa['logo_desa']) && !empty($data_desa['logo_desa'])): ?>
                                <div class="mt-2">
                                    <img src="../assets/images/<?php echo $data_desa['logo_desa']; ?>" class="img-preview" id="logo_preview">
                                    <p class="text-muted">File saat ini: <?php echo $data_desa['logo_desa']; ?></p>
                                </div>
                            <?php else: ?>
                                <div class="mt-2">
                                    <img src="" class="img-preview" id="logo_preview" style="display:none;">
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="kop_surat" class="form-label">Kop Surat Desa</label>
                            <input type="file" class="form-control" id="kop_surat" name="kop_surat" accept="image/*">
                            <?php if (isset($data_desa['kop_surat']) && !empty($data_desa['kop_surat'])): ?>
                                <div class="mt-2">
                                    <img src="../assets/images/<?php echo $data_desa['kop_surat']; ?>" class="img-preview" id="kop_preview">
                                    <p class="text-muted">File saat ini: <?php echo $data_desa['kop_surat']; ?></p>
                                </div>
                            <?php else: ?>
                                <div class="mt-2">
                                    <img src="" class="img-preview" id="kop_preview" style="display:none;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="qr_tte" class="form-label">QR Code TTE (Tanda Tangan Elektronik)</label>
                            <input type="file" class="form-control" id="qr_tte" name="qr_tte" accept="image/*">
                            <div id="qr_tte_container" class="mt-2">
                                <?php if (isset($data_desa['qr_tte']) && !empty($data_desa['qr_tte'])): ?>
                                    <img src="../assets/images/<?php echo $data_desa['qr_tte']; ?>" class="img-preview" id="qr_preview">
                                    <p class="text-muted mb-2" id="qr_filename">File saat ini: <?php echo $data_desa['qr_tte']; ?></p>
                                    <button type="button" class="btn btn-danger btn-sm" id="btn_delete_qr">Hapus QR Code</button>
                                <?php else: ?>
                                    <img src="" class="img-preview" id="qr_preview" style="display:none;">
                                    <p class="text-muted mb-2" id="qr_filename" style="display:none;"></p>
                                    <button type="button" class="btn btn-danger btn-sm" id="btn_delete_qr" style="display:none;">Hapus QR Code</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4 d-grid">
                    <button type="submit" class="btn btn-success">Simpan Data Desa</button>
                </div>
            </form>
        </div>
    </div>
        </div>
    </div>
</div>

    <script>
        // Preview gambar sebelum upload
        document.getElementById('logo_desa').addEventListener('change', function(e) {
            const preview = document.getElementById('logo_preview');
            const file = e.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            
            if (file) {
                reader.readAsDataURL(file);
            }
        });
        
        document.getElementById('kop_surat').addEventListener('change', function(e) {
            const preview = document.getElementById('kop_preview');
            const file = e.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            
            if (file) {
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('qr_tte').addEventListener('change', function(e) {
            const preview = document.getElementById('qr_preview');
            const btnDelete = document.getElementById('btn_delete_qr');
            const filenameText = document.getElementById('qr_filename');
            const file = e.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('btn_delete_qr')?.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin menghapus gambar QR Code TTE?')) {
                const formData = new FormData();
                formData.append('action', 'delete_qr_tte');

                fetch('data-desa.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const preview = document.getElementById('qr_preview');
                        const btnDelete = document.getElementById('btn_delete_qr');
                        const filenameText = document.getElementById('qr_filename');
                        const inputQr = document.getElementById('qr_tte');

                        if (preview) { preview.src = ''; preview.style.display = 'none'; }
                        if (filenameText) { filenameText.innerText = ''; filenameText.style.display = 'none'; }
                        if (btnDelete) { btnDelete.style.display = 'none'; }
                        if (inputQr) { inputQr.value = ''; }
                        alert('QR Code TTE berhasil dihapus.');
                    } else {
                        alert('Gagal menghapus QR Code TTE.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus QR Code TTE.');
                });
            }
        });
    </script>
    
    <?php include 'footer.php'; ?>

    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/load-data-desa-suket.js"></script>
</body>
</html>