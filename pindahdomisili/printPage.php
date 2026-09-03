<?php
// Include file konfigurasi database
require_once '../admin/config.php';

// Ambil logo desa
$query = "SELECT * FROM data_desa LIMIT 1";
$result = $conn->query($query);
$data_desa = $result->num_rows > 0 ? $result->fetch_assoc() : null;

// Ambil nomor surat untuk suket_pindah_domisili
$query = "SELECT nomor_surat FROM nomor_register WHERE nama_surat = 'suket_pindah_domisili' LIMIT 1";
$result = $conn->query($query);
$nomor_suket_pindah_domisili = $result->num_rows > 0 ? $result->fetch_assoc()['nomor_surat'] : '';

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
$keterangan_usaha_url = $data_values[15] ?? '';
// Jika ada data desa, kepala desa, dll., tambahkan di sini sesuai urutan


include 'header.php'; 
?>

<div class="title-page">
<div class="container">
<div class="row">
    <div class="col">
    <h1 class="frontpage-title">
        Formulir Permohonan <br>
        Surat Pengantar Pindah Domisili
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
                    <h4>Surat Pengantar Pindah Domisili</h4>
                    <p class="nomor-register">Nomor: <span class="preserve-spaces"><?php echo htmlspecialchars($nomor_suket_pindah_domisili); ?></span></p>
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
        
                                <dt>Kebangsaan :</dt>
                                <dd><span>WNI</span></dd>
        
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
        
                            <p>Yang bersangkutan di atas adalah benar-benar Penduduk Desa <span class="nama_desa"></span> Kecamatan <span class="data_kecamatan"></span> Kabupaten <span class="data_kabupaten"></span>. Surat Pengantar ini dibuat untuk menerangkan bahwa yang bersangkutan mengajukan permohonan pindah domisili ke <span class="keterangan_usaha garis-bawah"></span>.</p>
        
                            <p>Demikian Surat Keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>
        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col offset-md-6 tanda-tangan">
                            <p><span class="nama_desa"></span>, <span id="tanggal_sekarang"></span> <br> <span class="jabatan_kepala_desa">Kepala Desa</span> <span class="nama_desa"></span></p>
                            <div class="qr_tte_container"><br>&nbsp;<br>&nbsp;<br></div>
                            <p><strong><u><span class="nama_kepala_desa"></span></u></strong></p>
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