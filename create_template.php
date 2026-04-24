<?php
echo "Attempting to load autoloader...\n";
require 'vendor/autoload.php';
echo "Autoloader loaded.\n";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

echo "Creating Spreadsheet object...\n";
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$headers = [
    'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 
    'alamat', 'rt', 'rw', 'dusun', 'desa', 'kecamatan', 'kabupaten', 'propinsi',
    'nama_usaha', 'keterangan_usaha', 'agama', 'status_perkawinan', 'pekerjaan'
];

$sheet->fromArray([$headers], NULL, 'A1');

$writer = new Xlsx($spreadsheet);
$writer->save('admin/template-import-data.xlsx');

echo "Template file created successfully.";
?>
