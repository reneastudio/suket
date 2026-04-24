<!-- 
    Desain dan pengembangan : Ari Wibowo
    Website : reneastudio.com
    WhatsApp : 0877-5060-0070
    Email : info@reneastudio.com
-->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Surat Pengantar Pindah Domisili</title>
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
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
            <a class="navbar-brand" href="../">      
                <?php if ($data_desa && !empty($data_desa['logo_desa'])): ?>
                    <img src="../assets/images/<?php echo $data_desa['logo_desa']; ?>" alt="Logo Desa" class="logo-desa">
                <?php else: ?>
                    <img src="../assets/images/eksotik.png" height="48" alt="Desa Tunjungrejo" class="d-inline-block align-text-top">
                <?php endif; ?>      
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="menu-item navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Surat Keterangan</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../suketusaha">Surat Keterangan Usaha</a></li>
                            <li><a class="dropdown-item" href="../suketdomisili">Surat Keterangan Domisili</a></li>
                            <li><a class="dropdown-item" href="../suketskck">SKCK</a></li>
                            <li><a class="dropdown-item" href="../suketbedanama">Surat Keterangan Beda Nama</a></li>
                            <li><a class="dropdown-item" href="../suketkehilangan">Surat Keterangan Kehilangan</a></li>
                            <li><a class="dropdown-item" href="../suketkematian">Surat Keterangan Kematian</a></li>
                            <li><a class="dropdown-item" href="../suketkelahiran">Surat Keterangan Kelahiran</a></li>
                            <li><a class="dropdown-item" href="../suketjandaduda">Surat Keterangan Janda / Duda</a></li>
                            <li><a class="dropdown-item" href="../suketmenikah">Surat Keterangan Menikah</a></li>
                            <li><a class="dropdown-item" href="../suketbelumnikah">Surat Keterangan Belum Nikah</a></li>
                            <li><a class="dropdown-item" href="../suketpenghasilan">Surat Keterangan Penghasilan</a>
                            </li>
                            <li><a class="dropdown-item" href="../pindahdomisili">Persyaratan Pindah Domisili</a></li>
                            <li><a class="dropdown-item" href="../suratijinkeramaian">Surat Ijin Keramaian</a></li>
                            <li><a class="dropdown-item" href="../sukettidakmampu">Surat Keterangan Tidak Mampu</a></li>
                        </ul>
                    </li>
                </ul>
        <span class="admin-menu-container">
          <a class="navbar-text" href="../admin">
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