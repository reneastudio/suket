<?php
// Mulai session dan cek login
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include file konfigurasi database
require_once 'config.php';

// Ambil data desa
$query = "SELECT * FROM data_desa LIMIT 1";
$result = $conn->query($query);
$data_desa = $result->num_rows > 0 ? $result->fetch_assoc() : null;

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Ambil data statistik penduduk
$total_penduduk = 0;
$total_laki = 0;
$total_perempuan = 0;

$query = "SELECT COUNT(*) as total, 
                 SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as laki,
                 SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as perempuan
          FROM userdata";
$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    $data = $result->fetch_assoc();
    $total_penduduk = $data['total'];
    $total_laki = $data['laki'];
    $total_perempuan = $data['perempuan'];
}

include 'header.php'; 

// --- PHP Code to Fetch Data for Monthly Surat Chart ---
$chart_labels = [];
$chart_data = [];

// Use a consistent reference for the current date
$current_date_for_chart = new DateTime('first day of this month');

// Loop for the last 4 months
for ($i = 0; $i < 4; $i++) {
    // Create a new DateTime object for calculation inside the loop
    $date_in_loop = clone $current_date_for_chart;
    if ($i > 0) {
        $date_in_loop->modify("-{$i} months");
    }

    $year_chart = (int)$date_in_loop->format('Y');
    $month_chart = (int)$date_in_loop->format('n');
    
    // Indonesian month names for labels
    $bulanIndonesiaChart = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
    ];
    $chart_labels[] = $bulanIndonesiaChart[$month_chart] . " " . $year_chart;

    // For the current month ($i=0), query `surat` table in real-time
    if ($i === 0) {
        $query_current_month = $conn->prepare("SELECT COUNT(*) as total_surat FROM surat WHERE YEAR(tanggal_buat) = ? AND MONTH(tanggal_buat) = ?");
        if ($query_current_month) {
            $query_current_month->bind_param("ii", $year_chart, $month_chart);
            $query_current_month->execute();
            $result_current_month = $query_current_month->get_result();
            $data_current_month = $result_current_month->fetch_assoc();
            $chart_data[] = $data_current_month['total_surat'] ? (int)$data_current_month['total_surat'] : 0;
            $query_current_month->close();
        } else {
            $chart_data[] = 0; // Default to 0 if query fails
            error_log("Failed to prepare real-time chart data query for $year_chart-$month_chart: " . $conn->error);
        }
    } else {
        // For previous months, use the summary table
        $query_summary = $conn->prepare("SELECT SUM(count) as total_surat FROM monthly_surat_summary WHERE year = ? AND month = ?");
        if ($query_summary) {
            $query_summary->bind_param("ii", $year_chart, $month_chart);
            $query_summary->execute();
            $result_summary = $query_summary->get_result();
            $data_summary = $result_summary->fetch_assoc();
            $chart_data[] = $data_summary['total_surat'] ? (int)$data_summary['total_surat'] : 0;
            $query_summary->close();
        } else {
            $chart_data[] = 0; // Default to 0 if query fails
            error_log("Failed to prepare summary chart data query for $year_chart-$month_chart: " . $conn->error);
        }
    }
}

// Reverse arrays so the chart shows oldest month first, to most recent
$chart_labels = array_reverse($chart_labels);
$chart_data = array_reverse($chart_data);
// --- End of PHP Code for Chart Data ---

?>
<!-- It's often better to include JS libraries in header.php or footer.php -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="admin title-page">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="frontpage-title">
                    Dashboard Administrasi
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="admin container formulir">
    <!-- Statistik Penduduk -->
      <div class="grey form-bg rounded shadow mb-4">
            <div class="p-4">
            <div class="rounded">
                
    <div class="row mb-4">
        <div class="col-md-4 mb-md-0">
            <div class="full-height card bg-light border-0">
                <div class="info-singkat card-body rounded-2">
                    <div class="card-content">
                        <h2 class="card-title">Selamat datang <br/> Admin Desa <span class="nama_desa"></span></h2>
                        
                        <figure>
                          <blockquote class="blockquote">
                            <p>Pengajuan suket baru : <span id="dashboardNotificationBadge" class="notificationBadge badge rounded-pill bg-danger" style="display: none;">0</span></p>
                          </blockquote>
                            <a href="data-pengajuan-suket.php" class="btn btn-dark btn-lg" id="notificationLink">Buka surat</a>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 penduduk">
            <div class="card bg-light mb-4 border-0">
                <div class="total-penduduk card-body rounded-2">
                    <div class="card-content">
                        <h5 class="card-title fw-normal">Total penduduk tercatat</h5>
                        <p class="card-text display-2"><?php echo number_format($total_penduduk); ?></p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="edit-search.php" class="btn btn-success me-md-2 btn-lg" type="button">Data Penduduk</a>
                            <a href="data-input.php" class="btn btn-dark me-md-2 btn-lg" type="button">+ Tambah Baru</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card male bg-light mb-4 mb-md-0 border-0">
                        <div class="card-body">
                            <div class="card-content">
                            <h5 class="card-title fw-normal">Laki-laki</h5>
                            <p class="card-text display-4"><?php echo number_format($total_laki); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card female bg-light mb-4 mb-md-0 border-0">
                        <div class="card-body">
                            <div class="card-content">
                            <h5 class="card-title fw-normal">Perempuan</h5>
                            <p class="card-text display-4"><?php echo number_format($total_perempuan); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Statistik Pengajuan Surat Bulanan -->
    <div class="row mb-0">
        <div class="col">
            <div class="card p-4">
                <div class="card-header bg-white border-0 ps-0"> <!-- Removed left padding for header to align title -->
                    <h5 class="card-title mb-0">Statistik pengajuan surat (4 bulan terakhir)</h5>
                </div>
                <div class="card-body bg-white border-0 ps-0">
                    <div style="height: 300px;"> <!-- Wrapper div to control chart height -->
                        <canvas id="suratStatsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    
    

    <!-- Pengajuan Surat Terbaru -->
    <div class="row rounded">
        <div class="col">
            <div class="card p-4 rounded">
                <div class="card-header">
                    <h5 class="card-title mb-0">10 Pengajuan surat terakhir</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pemohon</th>
                                    <th>NIK Pemohon</th>
                                    <th>Jenis Surat</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Ambil data pengajuan surat terbaru (misal 10 terakhir)
                                // Sesuaikan query SELECT untuk menyertakan jenis_surat
                                $query_surat = "SELECT nama_lengkap, nik, jenis_surat, tanggal_buat, file_path FROM surat ORDER BY tanggal_buat DESC LIMIT 10";
                                $result_surat = $conn->query($query_surat);
                                $nomor = 1;
                                if ($result_surat && $result_surat->num_rows > 0) {
                                    // Fungsi untuk format tanggal dengan bulan Indonesia
                                    if (!function_exists('formatTanggalIndonesia')) { // Cek jika fungsi belum didefinisikan
                                        function formatTanggalIndonesia($tanggal) {
                                            if (empty($tanggal)) return '-';
                                            $bulanIndonesia = [
                                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                            ];
                                            $timestamp = strtotime($tanggal);
                                            if ($timestamp === false) return '-'; // Handle jika tanggal tidak valid
                                            $hari = date('d', $timestamp);
                                            $bulan = $bulanIndonesia[(int)date('m', $timestamp)];
                                            $tahun = date('Y', $timestamp);
                                            return "$hari $bulan $tahun";
                                        }
                                    }

                                    while ($row_surat = $result_surat->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $nomor++ . "</td>";
                                        echo "<td><span class='fw-bold'>" . htmlspecialchars($row_surat['nama_lengkap'] ?: '-') . "</span></td>";
                                        echo "<td>" . htmlspecialchars($row_surat['nik'] ?: '-') . "</td>"; 
                                        echo "<td>" . htmlspecialchars($row_surat['jenis_surat'] ?: '-') . "</td>"; // Menampilkan jenis surat
                                        echo "<td>" . formatTanggalIndonesia($row_surat['tanggal_buat']) . "</td>";
                                        if (!empty($row_surat['file_path'])) {
                                            // Pastikan path relatif dari root proyek
                                            $filePath = '../' . $row_surat['file_path']; 
                                            if (file_exists($filePath)) {
                                                echo "<td><a href='" . htmlspecialchars($filePath) . "' class='link-success text-decoration-none' target='_blank'>Unduh PDF</a></td>";
                                            } else {
                                                echo "<td>PDF tidak ditemukan</td>"; // Pesan jika file tidak ada
                                            }
                                        } else {
                                            echo "<td>Tidak ada PDF</td>";
                                        }
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>Belum ada pengajuan surat.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="../assets/js/app.js"></script>
<script src="../assets/js/load-data-desa-suket.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctxSuratStats = document.getElementById('suratStatsChart');
    if (ctxSuratStats) {
        new Chart(ctxSuratStats, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($chart_labels); ?>,
                datasets: [{
                    label: 'Total Pengajuan Surat',
                    data: <?php echo json_encode($chart_data); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)', // Slightly more transparent
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 9 // Rounded bars
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Important for custom height
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Ensure Y-axis steps are integers
                            precision: 0 
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true, // Keep legend
                        position: 'bottom', // Or 'top', 'left', 'right'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    } else {
        console.error("Canvas element with ID 'suratStatsChart' not found for chart rendering.");
    }
});
</script>
</body>
</html>