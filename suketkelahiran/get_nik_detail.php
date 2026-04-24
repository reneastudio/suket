<?php
include '../admin/config.php';

if (isset($_POST['nik'])) {
    $nik = $_POST['nik'];
    
    // Mempersiapkan statement untuk menghindari SQL injection
    $stmt = $conn->prepare("SELECT * FROM userdata WHERE nik = ?");
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Mengembalikan data dalam format JSON
        echo json_encode([
            'success' => true,
            'nama_lengkap' => $row['nama_lengkap'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'agama' => $row['agama'],
            'status_perkawinan' => $row['status_perkawinan'],
            'alamat' => $row['alamat'],
            'rt' => $row['rt'],
            'rw' => $row['rw'],
            'dusun' => $row['dusun'],
            'desa' => $row['desa'],
            'kecamatan' => $row['kecamatan'],
            'kabupaten' => $row['kabupaten'],
            'propinsi' => $row['propinsi'],
            'nama_usaha' => $row['nama_usaha'],
            'keterangan_usaha' => $row['keterangan_usaha'],
            'nama_pemdes' => $row['nama_pemdes'],
            'nama_kades' => $row['nama_kades'],
            'tanggal_meninggal' => $row['tanggal_meninggal']
        ]);
    } else {
        // Jika NIK tidak ditemukan
        echo json_encode(['success' => false]);
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'NIK tidak disediakan']);
}
?>
