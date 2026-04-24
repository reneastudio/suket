<?php
include '../admin/config.php';

if (isset($_POST['nik'])) {
    $nik = $_POST['nik'];
    
    $stmt = $conn->prepare("SELECT * FROM userdata WHERE nik = ?");
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
    
    $stmt->close();
    $conn->close();
}
?>
