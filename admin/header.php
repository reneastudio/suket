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
    <title>Admin Pemerintahan Desa</title>
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

<body id="innerpage">
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
    <nav class="admin navbar navbar-expand-lg fixed-top">
        <div class="container-md">
            <a class="navbar-brand" href="index.php">      
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
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Data Pemdes</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="data-desa.php">Profil Desa</a></li>
                                <li class="nav-item"><a class="nav-link" href="nomor-surat.php">Nomor Register Surat</a></li>
                                <li class="nav-item"><a class="nav-link" href="ganti-password.php">Ganti Password</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Penduduk</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="data-input.php">Masukkan data baru</a></li>
                                <li><a class="dropdown-item" href="edit-search.php">Data penduduk</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="data-pengajuan-suket.php">Data Pengajuan Suket</a></li>
                    </ul>
                <span class="admin-menu-container">
                    <a class="navbar-text me-3" href="data-pengajuan-suket.php" id="notificationLink">
                        <div class="admin-menu btn btn-light position-relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z"/>
                            </svg>
                            <span id="headerNotificationBadge" class="notificationBadge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">
                                0
                            </span>
                        </div>
                    </a>
                    <a class="navbar-text" href="logout.php">
                        <div class="admin-menu btn btn-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                            </svg> <span>&nbsp; Logout</span>
                        </div>
                    </a>
                </span>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php if (isset($_SESSION['username'])): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const headerBadge = document.getElementById('headerNotificationBadge');
        const dashboardBadge = document.getElementById('dashboardNotificationBadge');

        function checkNewSurat() {
            fetch('check_new_surat.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        console.error('Error from server:', data.error);
                        return;
                    }
                    
                    const unreadCount = data.unread_count;

                    if (headerBadge) {
                        headerBadge.textContent = unreadCount;
                        if (unreadCount > 0) {
                            headerBadge.style.display = '';
                        } else {
                            headerBadge.style.display = 'none';
                        }
                    }

                    if (dashboardBadge) {
                        dashboardBadge.textContent = unreadCount;
                        dashboardBadge.style.display = ''; 
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        }

        setInterval(checkNewSurat, 5000);

        checkNewSurat();
    });
    </script>
    <?php endif; ?>
