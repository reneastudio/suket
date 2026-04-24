<!-- 
    Desain dan pengembangan : Ari Wibowo
    Website : reneastudio.com
    WhatsApp : 0877-5060-0070
    Email : info@reneastudio.com
-->
<?php
// Include file konfigurasi database
require_once 'admin/config.php';

// Ambil data desa
$query = "SELECT * FROM data_desa LIMIT 1";
$result = $conn->query($query);
$data_desa = $result->num_rows > 0 ? $result->fetch_assoc() : null;
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Layanan Surat Keterangan Desa Mandiri</title>
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</head>
</head>

<body id="frontpage">
  <nav class="frosted navbar navbar-expand-lg fixed-top">
    <div class="container-md">
      <div class="navbar-brand" href="index.php">
      
      <?php if ($data_desa && !empty($data_desa['logo_desa'])): ?>
          <img src="assets/images/<?php echo $data_desa['logo_desa']; ?>" alt="Logo Desa" class="logo-desa">
      <?php else: ?>
          <img src="assets/images/eksotik.png" height="48" alt="Desa Tunjungrejo" class="d-inline-block align-text-top">
      <?php endif; ?>
      
      </div>
    </div>
  </nav>
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-md">
      <a class="navbar-brand" href="index.php">
      
      <?php if ($data_desa && !empty($data_desa['logo_desa'])): ?>
          <img src="assets/images/<?php echo $data_desa['logo_desa']; ?>" alt="Logo Desa" class="logo-desa">
      <?php else: ?>
          <img src="assets/images/eksotik.png" height="48" alt="Desa Tunjungrejo" class="d-inline-block align-text-top">
      <?php endif; ?>
      
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="menu-item navbar-nav me-auto mb-2 mb-lg-0 nav justify-content-center">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Beranda</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">Surat Keterangan</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="suketusaha">Surat Keterangan Usaha</a></li>
              <li><a class="dropdown-item" href="suketdomisili">Surat Keterangan Domisili</a></li>
              <li><a class="dropdown-item" href="suketskck">SKCK</a></li>
              <li><a class="dropdown-item" href="suketbedanama">Surat Keterangan Beda Nama</a></li>
              <li><a class="dropdown-item" href="suketkehilangan">Surat Keterangan Kehilangan</a></li>
              <li><a class="dropdown-item" href="suketkematian">Surat Keterangan Kematian</a></li>
              <li><a class="dropdown-item" href="suketkelahiran">Surat Keterangan Kelahiran</a></li>
              <li><a class="dropdown-item" href="suketjandaduda">Surat Keterangan Janda / Duda</a></li>
              <li><a class="dropdown-item" href="suketmenikah">Surat Keterangan Menikah</a></li>
              <li><a class="dropdown-item" href="suketbelumnikah">Surat Keterangan Belum Menikah</a></li>
              <li><a class="dropdown-item" href="suketpenghasilan">Surat Keterangan Penghasilan</a></li>
              <li><a class="dropdown-item" href="pindahdomisili">Surat Pengantar Pindah Domisili</a></li>
              <li><a class="dropdown-item" href="suratijinkeramaian">Surat Ijin Keramaian</a></li>
              <li><a class="dropdown-item" href="sukettidakmampu">Surat Keterangan Tidak Mampu</a></li>
            </ul>
          </li>
        </ul>
        <span class="admin-menu-container">
          <a class="navbar-text" href="admin">
          <div class="admin-menu btn btn-light">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
  </svg> <span>&nbsp; Admin</span>
          </div>
          </a>
        </span>
      </div>
    </div>
  </nav>

  <div class="title-page">
    <div class="container">
    <div class="row">
      <div class="col">
        <h1 class="frontpage-title">
          Layanan <br/> Surat Keterangan Desa <span class="nama_desa"></span> <br/> Mandiri
        </h1>
      </div>
    </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
        <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<circle cx="50" cy="50" r="36.5" fill="#fff5cf"></circle><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M28.41,45.725	c-3.971,6.04-3.729,11.318,1.031,13.381c5.578,2.418,10.798,0.444,11.133-3.777c0.361-4.559-5.807-5.967-8.233-5.456"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M74.767,20.451	c0,0-11.193,7.515-18.918,9.797c-8.047,2.377-12.752,2.23-18.977,7.113"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M90.839,53.278	c0,0-10.33,8.354-22.881,11.722c-5.896,1.582-8.426,2.17-8.426,2.17"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M48.936,71.574	l2.095,2.742c-1.944,4.032-1.609,8.983,1.303,12.776c3.195,4.161,8.534,5.687,13.273,4.245l-6.443-8.392	c-1.446-1.883-1.091-4.581,0.792-6.027c1.883-1.446,4.581-1.091,6.027,0.792l6.443,8.392c2.617-4.206,2.522-9.758-0.672-13.92	c-2.912-3.793-7.608-5.396-12.006-4.56L34.372,34.569c1.944-4.033,1.609-8.983-1.303-12.776c-3.195-4.161-8.534-5.687-13.273-4.245	l6.443,8.392c1.446,1.883,1.091,4.581-0.792,6.027s-4.581,1.091-6.027-0.792l-6.443-8.392c-2.617,4.206-2.522,9.758,0.672,13.92	c2.912,3.793,7.608,5.396,12.006,4.56l6.558,8.547"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M27.789,58.341	c0,0-1.36,5.705,5.604,8.305c6.963,2.6,11.772-1.488,11.521-5.381c-0.215-3.347-4.004-4.604-4.004-4.604"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M35.826,67.843	c0.14,1.021,2.316,6.084,9.992,4.865c7.446-1.182,6.358-9.664-0.842-10.034"></path><path fill="#fff5cf" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M43.078,40.522	c0,0-7.12,5.626-9.022,12.489c-2.573,9.287,7.36,10.235,9.631,4.414c1.457-3.733,3.497-4.129,7.355-3.723	c4.085,0.43,7.617,1.442,10.979-3.191"></path>
</svg><br/>
            <h3 class="card-title">Surat Keterangan Usaha</h3>
            <p class="deskripsi-surat">Surat keterangan usaha dari desa yang membuktikan legalitas dari suatu bisnis atau usaha.</p>
        </div>
          <div class="card-body tombol-pilih-suket">
            <a href="suketusaha" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
          <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<circle cx="50" cy="50" r="36.5" fill="#e9f6ff"></circle><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M9.404,60.809	c0,0,17.102-11.032,35.577-7.895c16.352,2.777,18.731,0.688,26.511-2.688c5.244-2.275,6.72,3.257,6.072,5.038"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M80.94,63.208	c4.093-5.473-1.869-9.132-4.747-7.45c0,0-9.67,5.03-16.258,5.725"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M61.261,68.747	c0,0,7.77-0.992,13.859-4.862c5.921-3.763,11.593,2.722,5.131,7.441c-5.925,4.327-13.215,7.726-33.214,10.584	c-18.649,2.665-22.26,5.177-25.056,7.087"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M30.748,59.963	c0,0,4.077-0.501,9.27,3.532c3.482,2.326,5.904,1.688,8.419,0.452c4.658-2.29,9.922,3.91,2.595,8.999	c-7.327,5.09-18.281,6.196-18.281,6.196"></path><polyline fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="25.766,25.351 49.416,6.905 73.766,25.351"></polyline><polyline fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="69.05,22.128 69.05,45.681 30.482,45.681 30.482,22.128"></polyline><rect width="7.755" height="10.436" x="38.277" y="23.032" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></rect><rect width="8.521" height="15.032" x="54.117" y="30.5" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></rect><line x1="38.277" x2="46.032" y1="26.527" y2="26.527" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line>
</svg><br/>
            <h3 class="card-title">Surat Keterangan Domisili</h3>
            <p class="deskripsi-surat">Surat keterangan yang menerangkan bahwa anda benar tinggal di wilayah desa.</p></div>
          <div class="card-body tombol-pilih-suket">
            <a href="suketdomisili" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
          <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<circle cx="50" cy="50" r="36.5" fill="#f0ffd2"></circle><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M67.63,50.175 c0,0-7.532-5.872-13.787-7.277s-12,4.34-4.851,9.702s7.404,6.128,7.404,6.128s-0.383,9.574,9.191,14.681"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M39.02,49.902 c-0.549,1.14-0.715,2.693-0.178,4.805c1.34,5.266,5.989,7.055,8.362,7.723c3.511,0.989,8.298-0.83,5.904-6.479"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M39.992,57.388 c0,0-6.099,2.818-2.202,9.096c1.723,2.777,5.363,4.388,9.096,4.309c4.5-0.096,6.798-5.362,2.872-8.138"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M91.375,65.239 c0,0-8.97-11.548-20.719-22.522"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M60.992,93.452 c0,0-10.979-17.489-16.723-22.723"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M13.431,24.453 c0,0-1.861,5.704,2.623,14.53"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M9.008,25.113 c0,0-1.861,5.704,2.623,14.53"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M63.406,47.094 c8.193-3.909,13.625-10.754,13.625-18.546c0-12.15-13.208-22-29.5-22c-16.292,0-29.5,9.85-29.5,22 c0,5.823,3.039,11.114,7.992,15.049l-4.992,9.951l12.941-5.463c3.818,1.477,8.119,2.354,12.684,2.454"></path>
</svg><br/>
            <h3 class="card-title">Surat Pengantar SKCK</h3>
            <p class="deskripsi-surat">Surat pengantar dari desa untuk pengurusan Surat Keterangan Catatan Kepolisian (SKCK)</p></div>
          <div class="card-body tombol-pilih-suket">
            <a href="suketskck" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
          <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<circle cx="50" cy="50" r="36.5" fill="#e9f6ff"></circle><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M64.13,50.637	c0,0-6.539-6.961-12.503-9.311c-5.965-2.35-12.525,2.442-6.286,8.84s6.373,7.194,6.373,7.194s-1.852,9.402,6.823,15.92"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M35.903,45.965	c-0.718,1.042-1.121,2.551-0.915,4.72c0.514,5.409,4.832,7.892,7.074,8.918c3.317,1.518,8.327,0.457,6.831-5.493"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M35.711,53.511	c0,0-6.46,1.846-3.575,8.649c1.276,3.009,4.624,5.161,8.325,5.657c4.461,0.598,7.542-4.252,4.09-7.599"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M85.274,69.175	c0,0-5.985-12.651-17.998-26.686"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M50.912,92.377	c0,0-8.157-18.97-13.028-25.026"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M42.698,45.064 l-14.621,1.557c-2.401,0.256-4.554-1.483-4.809-3.884l-1.818-17.075"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M66.595,7.567 c1.531-0.163,2.904,0.946,3.067,2.477l3.09,29.016c0.163,1.531-0.946,2.904-2.477,3.067l-13.98,1.489"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M62.204,16.316 c1.598-0.17,2.755-1.603,2.585-3.201l-0.269-2.523c-0.163-1.531,0.678-2.875,1.916-3.007l-44.488,4.737 c-2.241,0.239-3.864,2.248-3.625,4.489l0.627,5.892c0.189,1.773,1.779,3.058,3.553,2.869l8.947-0.953 c0.99-0.105,1.88-0.648,2.428-1.479l1.835-2.784c0.548-0.831,1.438-1.373,2.428-1.479L62.204,16.316z"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M70.599,42.093 c-0.022,0.002-0.043-0.002-0.065,0c-0.022,0.003-0.042,0.011-0.063,0.014L70.599,42.093z"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M64.93,13.329 l2.797,26.266c0.16,1.507,1.41,2.608,2.807,2.497c1.389-0.186,2.378-1.525,2.218-3.032l-2.797-26.266L64.93,13.329z"></path>
</svg><br/>
            <h3 class="card-title">Surat Keterangan Beda Nama</h3>
            <p class="deskripsi-surat">Surat keterangan untuk pengurusan perubahan penulisan nama pada identitas dokumen yang berbeda.</p></div>
          <div class="card-body tombol-pilih-suket">
            <a href="suketbedanama" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
          <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<circle cx="50" cy="50" r="36.5" fill="#fff5cf"></circle><circle cx="39.871" cy="27.326" r="17.661" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></circle><path fill="#fff5cf" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M65.207,46.034	c0,0-9.183-0.471-15.215,3.486c-8.164,5.355-1.231,12.713,4.388,9.797c3.603-1.87,6.987-0.501,9.128,2.795	c2.141,3.296,5.916,3.431,11.379,1.022"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M35.66,44.532	c-3.938,2.785-4.487,6.361-2.217,9.838c3.368,5.158,8.884,6.401,11.522,3.018c2.849-3.653-1.516-8.187-4.598-9.352"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M93.344,46.976	c0,0-13.078-0.78-20.916-3.053c-7.194-2.087-14.047-3.758-20.492-3.771"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M32.473,52.801	c0,0-5.087,3.885-0.65,9.97s12.119,5.996,14.188,1.993s-1.608-6.704-1.608-6.704"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M34.091,65.1	c-0.451,0.942-1.561,6.659,5.61,9.912c6.956,3.156,14.398-4.199,5.595-9.069"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M81.571,84.884	c0,0-9.771-0.706-18.562-4.554c-11.716-5.128-18.418-4.553-18.418-4.553"></path><line x1="49.857" x2="51.94" y1="42.136" y2="48.231" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M55.744,58.848	c0,0,1.43,5.096,2.42,7.819c1.698,4.669-3.995,10.003-9.04,4.886"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M20.353,16.367	c-3.179,3.179-7.064,19.543,6.004,28.255"></path>
</svg><br/>
            <h3 class="card-title">Surat Keterangan Kehilangan</h3>
            <p class="deskripsi-surat">Surat keterangan sebagai pengantar atau bukti awal kehilangan sebelum mengurus surat kehilangan resmi dari pihak kepolisian</p></div>
          <div class="card-body tombol-pilih-suket">
            <a href="suketkehilangan" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
          <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<circle cx="50" cy="50" r="36.5" fill="#fde9f1"></circle><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M16.652,71.478	c0,0,24.913-27.522,35.739-39.13s19.797-11.641,21.783-8.609c3.587,5.478-7.424,9.544-10.033,13.457"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M44.598,49.37	c3.522-7.435,15.254-19.303,18.88-13.793c2.543,3.864-4.94,8.609-7.63,17.902C53.337,62.152,50,62.772,50,62.772"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M74.433,24.184	c0,0,2.47-1.113,4.061,1.218c4.207,6.163-10.19,13.337-12.929,17.38"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M78.104,31.27	c1.713,0.936,3.247,4.164-2.055,8.855C69.69,45.75,63.609,53.283,57.543,64.63S41.37,86.87,41.37,86.87"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M49.865,34.777	c-0.804-0.868-1.559-1.682-2.257-2.429c-10.826-11.609-19.797-11.641-21.783-8.609c-3.587,5.478,7.424,9.544,10.033,13.457"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M83.348,71.478	c0,0-8.534-9.427-17.783-19.574"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M46.84,38.348	c-4.093-3.681-8.372-5.728-10.318-2.771c-1.68,2.552,1.014,5.488,3.813,9.866"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M25.567,24.184	c0,0-2.47-1.113-4.061,1.218c-4.207,6.163,10.19,13.337,12.929,17.38"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M50.048,76.397	c4.52,6.096,8.582,10.473,8.582,10.473"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M21.896,31.27	c-1.713,0.936-3.247,4.164,2.055,8.855c3.577,3.164,7.066,6.932,10.514,11.642"></path>
</svg><br/>
            <h3 class="card-title">Surat Keterangan Kematian</h3>
            <p class="deskripsi-surat">Surat keterangan sebagai lampiran untuk mengajukan akta kematian ke Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil).</p></div>
          <div class="card-body tombol-pilih-suket">
            <a href="suketkematian" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
          <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<circle cx="50" cy="50" r="36.5" fill="#fff5cf"></circle><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M9.404,60.809 c0,0,17.102-11.032,35.577-7.895c16.352,2.777,18.731,0.688,26.511-2.688c5.244-2.275,6.72,3.257,6.072,5.038"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M80.94,63.208 c4.093-5.473-1.869-9.132-4.747-7.45c0,0-9.67,5.03-16.258,5.725"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M61.261,68.747 c0,0,7.77-0.992,13.859-4.862c5.921-3.763,11.593,2.722,5.131,7.441c-5.925,4.327-13.215,7.726-33.214,10.584 c-18.649,2.665-22.26,5.177-25.056,7.087"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M30.748,59.963 c0,0,4.077-0.501,9.27,3.532c3.482,2.326,5.904,1.688,8.419,0.452c4.658-2.29,9.922,3.91,2.595,8.999 c-7.327,5.09-18.281,6.196-18.281,6.196"></path><g><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M62.109,21.197 c-0.325-6.186-5.466-11.106-11.778-11.106s-11.453,4.92-11.778,11.106c0,0-0.031,0.511-0.031,0.617 c0,3.088,1.659,5.738,3.178,7.983c1.267,1.731,2.377,3.385,2.863,6.293c0.11,0.659,0.688,1.149,1.361,1.149h8.813 c0.675,0,1.254-0.491,1.362-1.153c0.486-2.98,1.444-4.262,2.865-6.289c1.725-2.461,3.178-4.895,3.178-7.983 C62.141,21.708,62.109,21.197,62.109,21.197z"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M50.32,47.665 L50.32,47.665c-1.527,0-2.764-1.255-2.764-2.803v-0.279h5.528v0.279C53.084,46.41,51.846,47.665,50.32,47.665z"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M53.729,44.569 h-6.818c-1.735,0-2.68-2.065-1.607-3.751c-0.613-1.12-0.651-2.301-0.092-3.545h10.215c0.738,1.044,0.616,2.219,0,3.468 C56.727,42.428,55.526,44.569,53.729,44.569z"></path><line x1="49.231" x2="55.427" y1="40.803" y2="40.741" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><line x1="23.013" x2="33.701" y1="22.037" y2="21.975" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><line x1="24.716" x2="34.476" y1="33.794" y2="28.857" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><line x1="24.678" x2="34.289" y1="9.654" y2="14.954" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><line x1="77.242" x2="66.554" y1="22.037" y2="21.975" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><line x1="75.54" x2="65.779" y1="33.794" y2="28.857" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><line x1="75.578" x2="65.966" y1="9.654" y2="14.954" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M49.907,14.09 c0,0-6.702,1.053-6.798,8.138"></path></g>
</svg><br/>
            <h3 class="card-title">Surat Keterangan Kelahiran</h3>
            <p class="deskripsi-surat">Surat keterangan sebagai lampiran untuk mengajukan akta kelahiran ke Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil).</p></div>
          <div class="card-body tombol-pilih-suket">
            <a href="suketkelahiran" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
          <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<path fill="#f0ffd2" d="M86.5,50c0,20.158-17.122,33.537-37.28,33.537s-36.5-16.342-36.5-36.5S29.842,13.5,50,13.5	S86.5,29.842,86.5,50z"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M61.457,13.873	c-6.065-1.504-10.273-1.092-12.882,0.291c-4.521,2.396-7.587,8.062-3.281,13.255s11.792,0.467,9.997-4.456s-2.838-5.443-2.838-5.443"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M99.391,37.276	c0,0-6.056-8.293-21.515-16.641c-1.19-0.643-2.344-1.239-3.461-1.791"></path><line x1="68.451" x2="55.457" y1="4.062" y2="23.017" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><line x1="69.819" x2="79.441" y1="25.536" y2="11.605" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><polyline fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="50.889,29.679 41.863,42.845 39.699,57.11 52.436,50.701 62.201,36.565"></polyline><ellipse cx="74.05" cy="7.772" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" rx="2.179" ry="6.674" transform="rotate(-56.337 74.053 7.771)"></ellipse><ellipse cx="74.05" cy="7.772" fill="#231f20" rx=".638" ry="1.955" transform="rotate(-56.337 74.053 7.771)"></ellipse><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M54.551,47.74	c0,0,5.212,1.015,9.851-1.135c3.709-1.719,6.257-8.785-2.092-10.035"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M51.606,51.208	c0.104,1.654,1.713,5.008,6.768,5.132c3.749,0.092,6.546-1.326,8.41-3.43c1.497-1.69,2.25-5.238-1.428-6.838"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M78.04,74.629	c-3.024-7.813-6.932-14.449-12.53-20.276"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M73.142,26.251	c0,0-1.253-0.426-3.15-0.725c-2.469-0.389-6.029-0.561-9.335,0.704c-5.845,2.237-4.484,9.92,1.228,10.242	c5.712,0.322,10.022,2.451,10.022,2.451s-1.779,8.112,5.879,12.49"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M41.812,43.014	c0,0,2.631,4.841,6.388,6.298"></path><path fill="#231f20" d="M40.025,51.958c0,0,1.394,2.385,4.408,3.241c-3.822,1.633-4.734,1.91-4.734,1.91L40.025,51.958z"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M39.699,57.11	c-11.963,8.286-21.272,21.272-21.272,21.272S13.606,70.824,5.63,65.585"></path>
</svg><br/>
            <h3 class="card-title">Surat Keterangan Janda/Duda</h3>
            <p class="deskripsi-surat">Surat keterangan yang menyatakan seseorang adalah janda/duda untuk melengkapi administrasi pensiunan, pengajuan menikah, atau kepentingan administrasi lainnya.</p></div>
          <div class="card-body tombol-pilih-suket">
            <a href="suketjandaduda" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
          <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<circle cx="49.5" cy="50.5" r="36.5" fill="#fff5cf"></circle><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M93.043,68.15	c-3.846-10.314-8.057-20.558-10.593-23.511c-5.591-6.511-9.081-1.756-9.081-1.756"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M76.907,49.652	c0,0-5.588-14.723-14.228-6.997"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M50.462,46.917	c0,0-4.418,10.679-4.24,16.48c0.179,5.801,7.616,15.043,12.237,28.907"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M65.423,48.889	c0,0-5.304-12.853-9.237-17.465s-10.205-1.921-8.676,5.044c1.529,6.965,5.717,17.727,6.543,27.475"></path><polygon fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="43,38.638 20.5,15.734 20.5,48.473 27.789,41.359 34.015,54.033 38.941,51.847 32.833,39.439"></polygon>
</svg><br/>
            <h3 class="card-title">Surat Keterangan Menikah</h3>
            <p class="deskripsi-surat">Surat keterangan yang menyatakan identitas pasangan yang telah menikah untuk keperluan administrasi pasangan tersebut.</p></div>
          <div class="card-body tombol-pilih-suket">
            <a href="suketmenikah" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
          <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<circle cx="50" cy="50" r="36.5" fill="#e9f6ff"></circle><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M45.456,71.19	c0.309,0.196,0.677,0.31,1.07,0.31H74.5c1.657,0,3-1.343,3-3v-26c0-1.657-1.343-3-3-3h-27c-1.657,0-3,1.343-3,3v4.7"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M58.5,56.895V61	c0,1.381,1.119,2.5,2.5,2.5s2.5-1.119,2.5-2.5v-4.105c1.78-0.911,3-2.758,3-4.895c0-3.038-2.462-5.5-5.5-5.5	c-2.095,0-3.917,1.172-4.846,2.896"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M53.5,39.5h-6V32	c0-7.444,6.056-13.5,13.5-13.5S74.5,24.556,74.5,32v2.5h-6V32c0-4.136-3.364-7.5-7.5-7.5s-7.5,3.364-7.5,7.5V39.5z"></path><line x1="82.891" x2="89.473" y1="35.159" y2="32.777" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><line x1="82.6" x2="87.687" y1="39.647" y2="39.833" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><line x1="79.795" x2="83.584" y1="31.898" y2="28.498" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M40.225,51.299	c0.187-0.456,0.427-0.898,0.721-1.319c1.224-1.751,3.257-2.896,5.555-2.893c2.916,0.003,5.393,1.826,6.341,4.413H65.7"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M53.3,56.5h10.854"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M12.924,83.064	c9.087-0.413,23.42-2.75,26.8-3.864c7.454-2.456,4.651-7.309,4.651-7.309"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M36.117,73.394	c0,0,14.394,0.411,10.875-9.587c-0.071-0.203-0.148-0.403-0.228-0.6"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M43.931,47.423	c-2.542-2.003-5.992-3.728-8.732-4.76c-4.966-1.872-8.72-1.463-21.233,1.448"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M38.5,63.807	c0,0,5.864,0.231,11.134-1.485s4.95-8.553-1.471-9.689c-6.421-1.136-7.629-0.839-16.157-3.539"></path>
</svg><br/>
            <h3 class="card-title">Surat Keterangan Belum Menikah</h3>
            <p class="deskripsi-surat">Surat keterangan yang menyatakan bahwa seseorang belum pernah menikah atau berstatus lajang. Biasanya digunakan untuk mengurus pernikahan, melamar pekerjaan, dan keperluan lainnya.</p></div>
          <div class="card-body tombol-pilih-suket">
            <a href="suketbelumnikah" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
          <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<circle cx="50" cy="50" r="36.5" fill="#fff5cf"></circle><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M67.223,91.106	C47.117,83.638,31.224,68.11,28.946,64.718c-5.024-7.478,0.764-9.679,0.764-9.679"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M35.569,60.512	c0,0-13.079-8.783-2.389-17.735"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M54.739,44.407	c0,0-1.408-11.888,2.616-18.229c4.692-7.394,11.035-2.214,10.443,5.567C66.674,46.513,78.33,53.383,92.691,60.277"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M38.008,48.679	c0,0-7.232-5.956-10.534-21.527c-1.32-6.224,5.612-9.364,8.679-2.536c4.175,9.293,7.516,15.555,19.598,20.567"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M57.474,16.039 c-0.543-0.543-0.298-1.459,0.442-1.664c0.671-0.186,1.398-0.6,2.207-1.376c0.822-0.789,1.378-1.862,1.378-3.001 c-0.001-2.487-2.019-4.502-4.507-4.499c-1.139,0.002-2.211,0.56-2.999,1.383c-0.775,0.81-1.188,1.539-1.372,2.211 c-0.202,0.736-1.11,0.983-1.65,0.444c-0.755-0.755-1.629-1.629-2.344-2.344c-0.781-0.781-2.044-0.778-2.825,0.003l-3.262,3.262 c-0.575,0.575-0.575,1.508,0,2.083l0.097,0.097c0.515,0.515,1.199,0.862,1.928,0.871c1.317,0.017,2.625,0.677,3.409,1.999 c0.733,1.235,0.715,2.832-0.041,4.053c-1.422,2.297-4.477,2.553-6.262,0.767c-0.757-0.757-1.141-1.741-1.162-2.732 c-0.016-0.767-0.395-1.481-0.937-2.023l-0.026-0.026c-0.58-0.58-1.513-0.58-2.088-0.005l-3.044,3.044 c-0.781,0.781-0.781,2.047,0,2.828l12.172,12.172c0.781,0.781,2.047,0.781,2.828,0l11.389-11.389c0.781-0.781,0.781-2.047,0-2.828 L57.474,16.039z"></path>
</svg><br/>
            <h3 class="card-title">Surat Keterangan Penghasilan</h3>
            <p class="deskripsi-surat">Surat keterangan yang menyatakan penghasilan orang tua. Biasanya digunakan untuk kebutuhan administrasi pengajuan beasiswa.</p></div>
          <div class="card-body tombol-pilih-suket">
            <a href="suketpenghasilan" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
          <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<circle cx="50" cy="50" r="36.5" fill="#fde9f1"></circle><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M32.298,16.048	c0.139,9.708,1.896,26.607,3.128,29.812c2.716,7.066,7.024,4.15,7.024,4.15"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M41.517,43.337	c0,0,0.28,13.888,9.747,10.029"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M68.5,46.5	c1.318-1.926,2.022-3.751,2.583-5.49c1.571-4.873-3.415-14.899-3.147-27.786"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M50.832,47.375	c0,0,0.598,13.972,2.499,18.969c1.901,4.997,7.909,4.62,8.702-1.62c0.793-6.24,0.502-18.143,2.704-26.486"></path><polyline fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="34.5,41.5 31.5,41.5 31.3,95 50,82.9 68.7,95 68.5,41.5 64.25,41.5"></polyline>
</svg><br/>
            <h3 class="card-title">Surat Keterangan Tidak Mampu</h3>
            <p class="deskripsi-surat">Surat keterangan yang diperuntukan bagi keluarga tidak mampu secara finansial agar mendapatkan kemudahan dalam berbagai layanan di bidang sosial, kesehatan, dan pendidikan.</p></div>
          <div class="card-body tombol-pilih-suket">
            <a href="sukettidakmampu" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
          <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<circle cx="50" cy="50" r="36.5" fill="#fff5cf"></circle><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M33.228,10.984 c1.1,6.738,1.108,12.523,0.229,18.381c-0.596,3.973-0.594,10.22,0.413,14.576c1.348,5.835,7.546,5.177,8.778,1.306 c0.963-3.025,0.275-9.626,0.275-9.626s6.352-1.338,6.509-8.786"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M49.692,50.939 c1.513,3.369,6.362,2.399,7.601-1.268c1.268-3.751,0.869-9.249,0.55-10.589c-0.958-4.02-6.119-3.713-7.77-0.344"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M57.293,50.015 c1.513,1.856,5.569,1.169,6.463-1.719c0.997-3.22,0.732-6.017,0.413-7.357c-0.958-4.02-5.247-3.907-6.051-0.963"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M40.066,48.258 c0.963,6.669,8.381,6.419,9.763,1.719c1.031-3.507,0.739-8.992,0.46-10.341c-0.667-3.227-4.334-5.152-7.267-2.035"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M63.765,11.438 c0.267,2.815,2.639,17.666,0.652,31.578"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M32.458,56.563 v-1.169c0-3.195,0.854-6.191,2.347-8.771"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M64.653,45.745 c1.826,2.768,2.889,6.084,2.889,9.648v1.169"></path><line x1="59.94" x2="59.94" y1="56.563" y2="51.885" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><line x1="40.06" x2="40.06" y1="48.377" y2="56.563" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></line><g><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M66.198,89.016 H33.802c-3.314,0-6-2.686-6-6V62.867c0-3.314,2.686-6,6-6h32.396c3.314,0,6,2.686,6,6v20.149 C72.198,86.33,69.512,89.016,66.198,89.016z"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M46.173,75.238 H33.16c-2.959,0-5.358-2.399-5.358-5.358v-0.765"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M72.198,69.114 v0.765c0,2.959-2.399,5.358-5.358,5.358H53.062"></path><circle cx="49.617" cy="75.238" r="3.062" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></circle></g>
</svg><br/>
            <h3 class="card-title">Surat Pengantar Pindah Domisili</h3>
            <p class="deskripsi-surat">Surat pengantar dari desa sebagai persyaratan untuk mengurus kepindahan domisili dari satu daerah ke daerah yang lain.</p></div>
          <div class="card-body tombol-pilih-suket">
            <a href="pindahdomisili" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
      <div class="pilihan-suket col-lg-4 col-md-6 align-items-stretch">
        <div class="card form-bg rounded border-0 shadow">
          <div class="card-header rounded"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
<circle cx="50" cy="50" r="36.5" fill="#f0ffd2"></circle><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M9.404,60.809	c0,0,17.102-11.032,35.577-7.895c16.352,2.777,18.731,0.688,26.511-2.688c5.244-2.275,6.72,3.257,6.072,5.038"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M80.94,63.208	c4.093-5.473-1.869-9.132-4.747-7.45c0,0-9.67,5.03-16.258,5.725"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M61.261,68.747	c0,0,7.77-0.992,13.859-4.862c5.921-3.763,11.593,2.722,5.131,7.441c-5.925,4.327-13.215,7.726-33.214,10.584	c-18.649,2.665-22.26,5.177-25.056,7.087"></path><path fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M30.748,59.963	c0,0,4.077-0.501,9.27,3.532c3.482,2.326,5.904,1.688,8.419,0.452c4.658-2.29,9.922,3.91,2.595,8.999	c-7.327,5.09-18.281,6.196-18.281,6.196"></path><ellipse cx="46" cy="39.452" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" rx="9.5" ry="9.048"></ellipse><polyline fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="55.5,38.5 50.522,9.625 50.5,9.5 67.25,13.75 67.25,22.25 52.5,18.5"></polyline>
</svg><br/>
            <h3 class="card-title">Surat Ijin Keramaian</h3>
            <p class="deskripsi-surat">Surat ijin dari desa atas pelaksanaan kegiatan yang mengundang keramaian untuk menjaga suasana yang kondusif bagi semua pihak.</p></div>
          <div class="card-body tombol-pilih-suket">
            <a href="suratijinkeramaian" class="d-flex btn-lg pilih-suket btn btn-success align-middle">Buat</a>
          </div>
        </div>
      </div>
    </div>

  </div>

  <?php include 'footer.php'; ?>

  <script src="assets/js/app.js"></script>
  <script src="assets/js/load-data-desa-main.js"></script>
  <script src="assets/js/browser-check.js"></script>

</body>

</html>