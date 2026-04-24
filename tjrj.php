<?php 
// Get NIK  
$nik = $_REQUEST['nik']; 
  
// Include konfigurasi database
include 'admin/config.php'; // File konfigurasi database
  
if ($nik !== "") { 
      
    $query = mysqli_query($con, "SELECT nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, status_perkawinan, pekerjaan, alamat, rt, rw, dusun, desa, kecamatan, kabupaten, propinsi, nama_usaha, keterangan_usaha FROM userdata WHERE nik='$nik'"); 
  
    $row = mysqli_fetch_array($query); 
    $nama_lengkap = $row["nama_lengkap"]; 
    $tempat_lahir = $row["tempat_lahir"]; 
    $tanggal_lahir = $row["tanggal_lahir"]; 
    $jenis_kelamin = $row["jenis_kelamin"]; 
    $agama = $row["agama"]; 
    $status_perkawinan = $row["status_perkawinan"]; 
    $pekerjaan = $row["pekerjaan"]; 
    $alamat = $row["alamat"]; 
    $rt = $row["rt"]; 
    $rw = $row["rw"]; 
    $rt = str_pad($rt, 3, '0', STR_PAD_LEFT);
    $rw = str_pad($rw, 3, '0', STR_PAD_LEFT);
    $dusun = $row["dusun"]; 
    $desa = $row["desa"]; 
    $kecamatan = $row["kecamatan"]; 
    $kabupaten = $row["kabupaten"]; 
    $propinsi = $row["propinsi"]; 
    $nama_usaha = $row["nama_usaha"]; 
    $keterangan_usaha = $row["keterangan_usaha"]; 

    // Convert tanggal_lahir from YYYY/MM/DD to DD/MM/YYYY
    $tanggal_lahir_obj = DateTime::createFromFormat('Y-m-d', $tanggal_lahir);
    $tanggal_lahir_formatted = $tanggal_lahir_obj->format('d/m/Y');
} 
  
// Store it in an array 
$result = array("$nama_lengkap", "$tempat_lahir", "$tanggal_lahir_formatted", "$jenis_kelamin", "$agama", "$status_perkawinan", "$pekerjaan", "$alamat", "$rt", "$rw", "$dusun", "$desa", "$kecamatan", "$kabupaten", "$propinsi", "$nama_usaha", "$keterangan_usaha"); 
  
// Send in JSON encoded form 
$myJSON = json_encode($result); 
echo $myJSON; 
?> 
