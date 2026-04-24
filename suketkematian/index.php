<?php
// Include file konfigurasi database
require_once '../admin/config.php';

// Ambil data desa
$query = "SELECT * FROM data_desa LIMIT 1";
$result = $conn->query($query);
$data_desa = $result->num_rows > 0 ? $result->fetch_assoc() : null;

include 'header.php'; 
?>

<div class="title-page">
<div class="container">
<div class="row">
    <div class="col">
    <h1 class="frontpage-title">
        Formulir Permohonan <br>
        Surat Keterangan Kematian
    </h1>
    </div>
</div>
    <div class="row">
        <div class="col border border-0">
            <!-- Tahaps -->
            <ul id="progressbar">
                <li class="active" id="step1"></li>
                <li id="step2"></li>
                <li id="step3"></li>
            </ul>
        </div>
    </div>
</div>
</div>

    <div class="container formulir">
        <form class="needs-validation" action="printPage.php" method="GET" novalidate>
            <div class="row form-bg rounded">
                <div class="col-sm-5 col-md-5 col-xs-5 col-lg-5 p-4">
                    <h5 class="form-heading"><strong>Data Pribadi</strong></h5>
                    <div class="form-group">
                        <label>NIK / Nomor KTP</label>
                        <input type="number" name="nik" id="nik" class="form-control"
                            placeholder="Contoh: 3508071234567890" onkeyup="GetDetail(this.value)" value="" required>
                        <small class="text-danger">
                            <strong>* Wajib diisi.</strong> NIK Anda tidak ada? Hubungi admin.
                        </small>
                    </div>
                    <div class="form-group">
                        <label>Agama</label>
                        <select class="form-select" id="agama" name="agama" required>
                            <option selected disabled value="">Pilih...</option>
                            <option value="Buddha"> Buddha </option>
                            <option value="Hindu"> Hindu </option>
                            <option value="Islam"> Islam </option>
                            <option value="Katolik"> Katolik </option>
                            <option value="Kristen"> Kristen </option>
                            <option value="Konghucu"> Konghucu </option>
                        </select>
                        <div class="invalid-feedback">
                            Lengkapi data dengan benar
                        </div>
                    </div>
                    <br>
                    <h5 class="form-heading"><strong>Data Meninggal</strong></h5>
                    <div class="form-group">
                        <label>Tanggal Meninggal</label>
                        <input type="date" name="tanggal_meninggal" id="tanggal_meninggal" class="form-control" required>
                        <div class="invalid-feedback">
                            Isi dengan tanggal meninggal
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Penyebab Meninggal</label>
                        <input type="text" name="nama_usaha" id="nama_usaha" class="form-control"
                            placeholder="Contoh: Sakit" value="" required>
                        <div class="invalid-feedback">
                            Isi dengan penyebab meninggal
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Meninggal Di</label>
                        <input type="text" name="keterangan_usaha" id="keterangan_usaha" class="form-control"
                            placeholder="Contoh: Rumah Sakit Umum Daerah" value="" required>
                        <div class="invalid-feedback">
                            Isi dengan keterangan tempat meninggal
                        </div>
                    </div>
                </div>

                <div class="col-sm-7 col-md-7 col-xs-7 col-lg-7 p-4 auto-fill">
                    <div class="auto-fill-form card text-bg-white border rounded">
                        <p><strong>**Kotak dibawah akan terisi otomatis sesuai data NIK Anda</strong></p>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                                placeholder="Nama lengkap" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                                placeholder="Tempat lahir" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                placeholder="Tanggal lahir" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control"
                                placeholder="Jenis kelamin" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat" value=""
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Dusun</label>
                            <input type="text" name="dusun" id="dusun" class="form-control" placeholder="Dusun" value=""
                                readonly>
                        </div>
                        <div class="row rt-rw">
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label>RT</label>
                                    <input type="text" name="rt" id="rt" class="form-control" placeholder="000" value="" readonly maxlength="3"
                                        oninput="formatRT(this)">
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label>RW</label>
                                    <input type="text" name="rw" id="rw" class="form-control" placeholder="000" value="" readonly maxlength="3"
                                        oninput="formatRW(this)">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Desa</label>
                            <input type="text" name="desa" id="desa" class="form-control" placeholder="Desa" value=""
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <input type="text" name="kecamatan" id="kecamatan" class="form-control" placeholder="Kecamatan"
                                value="" readonly>
                        </div>
                        <div class="form-group">
                            <label>Kabupaten</label>
                            <input type="text" name="kabupaten" id="kabupaten" class="form-control" placeholder="Kabupaten"
                                value="" readonly>
                        </div>
                        <div class="form-group">
                            <label>Propinsi</label>
                            <input type="text" name="propinsi" id="propinsi" class="form-control" placeholder="Propinsi"
                                value="" readonly>
                        </div>
                        <button type="submit" class="formulir-btn btn btn-success">Kirim</button>
                    </div>
                </div>
            </div>
    </div>
    </form>

    <?php include 'footer.php'; ?>

    <script src="js/collect-data.js"></script>
    <script src="../assets/js/load-data-desa-suket.js"></script>

</body>

</html>