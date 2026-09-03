<?php
// Include file konfigurasi database
require_once '../admin/config.php';

// Ambil logo desa
$query = "SELECT * FROM data_desa LIMIT 1";
$result = $conn->query($query);
$data_desa = $result->num_rows > 0 ? $result->fetch_assoc() : null;

// Persiapkan QR Code TTE jika tidak ada custom qr_tte image
$qr_tte_src = '';
if (!empty($data_desa['qr_tte']) && file_exists(__DIR__ . '/../assets/images/' . $data_desa['qr_tte'])) {
    $qr_tte_src = '../assets/images/' . $data_desa['qr_tte'];
} else {
    try {
        if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
            require_once __DIR__ . '/../vendor/autoload.php';
            $qrText = 'Dokumen ini telah ditandatangani secara elektronik oleh Kepala Desa ' . ($data_desa['nama_desa'] ?? '') . ' (' . ($data_desa['nama_kepala_desa'] ?? '') . ')';
            $qrCode = new \Endroid\QrCode\QrCode($qrText);
            $writer = new \Endroid\QrCode\Writer\PngWriter();
            $result = $writer->write($qrCode);
            $qr_tte_src = $result->getDataUri();
        }
    } catch (\Exception $e) {
        $qr_tte_src = '';
    }
}


// Ambil nomor surat untuk suket_meninggal
$query = "SELECT nomor_surat FROM nomor_register WHERE nama_surat = 'suket_penghasilan' LIMIT 1";
$result = $conn->query($query);
$nomor_suket_penghasilan = $result->num_rows > 0 ? $result->fetch_assoc()['nomor_surat'] : '';

// Ambil data dari URL
$nik_url = isset($_GET['nik']) ? htmlspecialchars(urldecode($_GET['nik'])) : '';
$data_url = isset($_GET['data']) ? $_GET['data'] : '';

$data_values = [];
if (!empty($data_url)) {
    $data_parts = explode(',', $data_url);
    $data_values = array_map(function($item) {
        return htmlspecialchars(urldecode($item));
    }, $data_parts);
}

// Tetapkan variabel sesuai urutan di JavaScript
$nama_lengkap_url = $data_values[0] ?? '';
$tempat_lahir_url = $data_values[1] ?? '';
$tanggal_lahir_url = $data_values[2] ?? '';
$jenis_kelamin_url = $data_values[3] ?? '';
$agama_url = $data_values[4] ?? '';
$status_perkawinan_url = $data_values[5] ?? '';
$pekerjaan_url = $data_values[6] ?? '';
$alamat_url = $data_values[7] ?? '';
$rt_url = $data_values[8] ?? '';
$rw_url = $data_values[9] ?? '';
$dusun_url = $data_values[10] ?? '';
$desa_url = $data_values[11] ?? '';
$kecamatan_url = $data_values[12] ?? '';
$kabupaten_url = $data_values[13] ?? '';
$propinsi_url = $data_values[14] ?? '';
$nama_usaha_url = $data_values[15] ?? '';
$keterangan_usaha_url = $data_values[16] ?? '';
$tempat_lahir_anak_url = $data_values[17] ?? '';
$tanggal_lahir_anak_url = $data_values[18] ?? '';
$nik_anak_url = $data_values[19] ?? '';
$penghasilan_ortu_url = $data_values[20] ?? '';
// Jika ada data desa, kepala desa, dll., tambahkan di sini sesuai urutan


include 'header.php'; 
?>

<div class="title-page">
<div class="container">
<div class="row">
    <div class="col">
    <h1 class="frontpage-title">
        Formulir Permohonan <br>
        Surat Keterangan Penghasilan Orang Tua
    </h1>
    </div>
</div>
    <div class="row">
        <div class="col border border-0">
            <!-- Tahaps -->
            <ul id="progressbar">
                <li class="active" id="step1"></li>
                <li class="active" id="step2"></li>
                <li id="step3"></li>
            </ul>
        </div>
    </div>
</div>
</div>

    <div class="container f4 formulir">
        <div class="content-container grey rounded p-4 card text-bg-white border-0">
        <div class="row">
            <div class="col border border-0">
                <p>Silakan periksa data dalam surat berikut. <br> Jika data sudah benar, tekan tombol <strong>Kirim</strong> dibawah untuk mengirim surat keterangan ke Admin Pemerintah Desa untuk dicetak.</p>
            </div>  
        </div>
        <div class="row form-bg">
            <div class="col border border-0">
                <div class="pdf-container-style border rounded">
                <div id="pdf-content" class="padding-5mm">
                    <img src="../assets/images/<?php echo $data_desa['kop_surat']; ?>"><br>
                    <h4>Surat Keterangan Penghasilan Orang Tua</h4>
                    <p class="nomor-register">Nomor: <span class="preserve-spaces"><?php echo htmlspecialchars($nomor_suket_penghasilan); ?></span></p>
                    <div class="row isi-surat">
                        <div class="col">
                            <p>Yang bertanda tangan di bawah ini, Kepala Desa <span class="nama_desa"></span>, Kecamatan <span class="data_kecamatan"></span>, Kabupaten
                                <span class="data_kabupaten"></span>, menerangkan bahwa :</p>
        
                            <dl>
                                <dt>Nama :</dt>
                                <dd><span class="nama_lengkap"></span></dd>
        
                                <dt>Jenis kelamin :</dt>
                                <dd><span class="jenis_kelamin"></span></dd>
        
                                <dt>Tempat / Tgl. Lahir :</dt>
                                <dd><span class="tempat_lahir"></span>, <span class="tanggal_lahir"></span></dd>
        
                                <dt>Agama :</dt>
                                <dd><span class="agama"></span></dd>
        
                                <dt>Status Perkawinan :</dt>
                                <dd><span class="status_perkawinan"></span></dd>
        
                                <dt>Pekerjaan :</dt>
                                <dd><span class="pekerjaan"></span></dd>
                
                                <dt>Alamat :</dt>
                                <dd><span class="alamat"></span></dd>
                                <dd>Dusun <span class="dusun"></span> RT.<span class="rt"></span>/RW.<span class="rw"></span>
                                </dd>
                                <dt></dt>
                                <dd>Desa/Kel. : <span class="desa"></span></dd>
                                <dd>Kecamatan : <span class="kecamatan"></span></dd>
                                <dd>Kabupaten : <span class="kabupaten"></span></dd>
                                <dd>Propinsi : <span class="propinsi"></span></dd>
        
                                <dt>NIK :</dt>
                                <dd><span class="nik"></span></dd>
                            </dl>

                            <p>Adalah benar orang tua / wali dari :</p>
                            <dl>
                                <dt>Nama :</dt>
                                <dd><span class="nama_usaha"></span></dd>
        
                                <dt>Tempat / Tgl. Lahir :</dt>
                                <dd><span class="tempat_lahir_anak"></span>, <span class="tanggal_lahir_anak"></span></dd>

                                <dt>Institusi Pendidikan :</dt>
                                <dd><span class="keterangan_usaha"></span></dd>

                                <dt>NIK / Nomor KTP :</dt>
                                <dd><span class="nik_anak"></span></dd>
                            </dl>
        
                            <p>Yang bersangkutan di atas adalah benar-benar Penduduk Desa <span class="nama_desa"></span> Kecamatan <span class="data_kecamatan"></span> Kabupaten <span class="data_kabupaten"></span>. Dan menurut pengamatan kami, yang bersangkutan benar memiliki penghasilan sebesar <span class="penghasilan_ortu garis-bawah"></span> per bulan.</p>
                                    
                            <p>Demikian Surat Keterangan ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.</p>
        
                        </div>
                    </div>
                                        <div class="row">
                        <div class="col offset-md-6 tanda-tangan text-center">
                            <p><span class="nama_desa"></span>, <span id="tanggal_sekarang"></span> <br> <span class="jabatan_kepala_desa">Kepala Desa</span> <span class="nama_desa"></span></p>
                            <div class="tte-box my-2 p-2 border rounded text-center style-tte" style="display: inline-block; text-align: center; border: 1px solid #000 !important; padding: 6px; margin: 5px 0;">
                                <small style="font-size: 9px; display: block; margin-bottom: 3px; font-weight: bold;">Ditandatangani secara elektronik oleh:</small>
                                <img src="<?php echo $qr_tte_src; ?>" alt="QR Code TTE" style="width: 80px; height: 80px; object-fit: contain;">
                                <small style="font-size: 8px; display: block; margin-top: 3px; color: #555;">Tersertifikasi Digital</small>
                            </div>
                            <p class="mb-0"><strong><u><span class="nama_kepala_desa"></span></u></strong></p>
                            <p class="nip-line" style="display:none; margin-top:0;"><small>NIP. <span class="nip_kepala_desa"></span></small></p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="d-grid gap-2">
                    <button id="download-btn" class="formulir btn btn-success">Kirim ke admin</button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal Loading -->
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-spinner">
        <div class="modal-body text-center">
            <!-- Spinner Bootstrap -->
            <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Mengirim surat, mohon tunggu...</p>
        </div>
        </div>
    </div>
    </div>

    <?php include 'footer.php'; ?>
    
    <script src="js/print.js"></script>
    <script src="../assets/js/load-data-desa-suket.js"></script>

</body>

</html>