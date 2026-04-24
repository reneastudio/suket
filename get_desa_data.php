<?php
include 'admin/config.php';

$query = "SELECT * FROM data_desa LIMIT 1";
$result = $conn->query($query);
$data_desa = $result->num_rows > 0 ? $result->fetch_assoc() : null;

if ($data_desa) {
    header('Content-Type: application/json');
    echo json_encode($data_desa);
} else {
    echo json_encode(['error' => 'Data desa tidak ditemukan']);
}
?>