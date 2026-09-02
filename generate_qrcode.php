<?php
// Endpoint untuk menyajikan QR Code secara dinamis sebagai gambar PNG
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$text = isset($_GET['text']) ? $_GET['text'] : 'Dokumen Terverifikasi TTE';

// Buat QR code
$qrCode = new QrCode($text);
$writer = new PngWriter();
$result = $writer->write($qrCode);

header('Content-Type: image/png');
echo $result->getString();
exit;
