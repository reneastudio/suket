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
        Surat Keterangan Kehilangan
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
                    <div class="form-group">
                        <label>Status Perkawinan</label>
                        <select class="form-select" id="status_perkawinan" name="status_perkawinan" required>
                            <option selected disabled value="">Pilih...</option>
                            <option value="Belum Kawin"> Belum Kawin </option>
                            <option value="Kawin"> Kawin </option>
                            <option value="Cerai Hidup"> Cerai Hidup </option>
                            <option value="Cerai Mati"> Cerai Mati </option>
                        </select>
                        <div class="invalid-feedback">
                            Lengkapi data dengan benar
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan</label>
                        <select class="form-select" id="pekerjaan" name="pekerjaan" required>
                            <option selected disabled value="">Pilih...</option>
                            <option value="Belum/Tidak Bekerja"> Belum/Tidak Bekerja </option>
                            <option value="Mengurus Rumah Tangga"> Mengurus Rumah Tangga </option>
                            <option value="Pelajar/Mahasiswa"> Pelajar/Mahasiswa </option>
                            <option value="Pensiunan"> Pensiunan </option>
                            <option value="Pegawai Negeri Sipil"> Pegawai Negeri Sipil </option>
                            <option value="Tentara Nasional Indonesia"> Tentara Nasional Indonesia </option>
                            <option value="Kepolisian RI"> Kepolisian RI </option>
                            <option value="Perdagangan"> Perdagangan </option>
                            <option value="Petani/Pekebun"> Petani/Pekebun </option>
                            <option value="Peternak"> Peternak </option>
                            <option value="Nelayan/Perikanan"> Nelayan/Perikanan </option>
                            <option value="Industri"> Industri </option>
                            <option value="Konstruksi"> Konstruksi </option>
                            <option value="Transportasi"> Transportasi </option>
                            <option value="Karyawan Swasta"> Karyawan Swasta </option>
                            <option value="Karyawan BUMN"> Karyawan BUMN </option>
                            <option value="Karyawan BUMD"> Karyawan BUMD </option>
                            <option value="Karyawan Honorer"> Karyawan Honorer </option>
                            <option value="Buruh Harian Lepas"> Buruh Harian Lepas </option>
                            <option value="Buruh Tani/Perkebunan"> Buruh Tani/Perkebunan </option>
                            <option value="Buruh Nelayan/Perikanan"> Buruh Nelayan/Perikanan </option>
                            <option value="Buruh Peternakan"> Buruh Peternakan </option>
                            <option value="Pembantu Rumah Tangga"> Pembantu Rumah Tangga </option>
                            <option value="Tukang Cukur"> Tukang Cukur </option>
                            <option value="Tukang Listrik"> Tukang Listrik </option>
                            <option value="Tukang Batu"> Tukang Batu </option>
                            <option value="Tukang Kayu"> Tukang Kayu </option>
                            <option value="Tukang Sol Sepatu"> Tukang Sol Sepatu </option>
                            <option value="Tukang Las/Pandai Besi"> Tukang Las/Pandai Besi </option>
                            <option value="Tukang Jahit"> Tukang Jahit </option>
                            <option value="Tukang Gigi"> Tukang Gigi </option>
                            <option value="Penata Rias"> Penata Rias </option>
                            <option value="Penata Busana"> Penata Busana </option>
                            <option value="Penata Rambut"> Penata Rambut </option>
                            <option value="Mekanik"> Mekanik </option>
                            <option value="Seniman"> Seniman </option>
                            <option value="Tabib"> Tabib </option>
                            <option value="Imam Masjid"> Imam Masjid </option>
                            <option value="Pendeta"> Pendeta </option>
                            <option value="Pastor"> Pastor </option>
                            <option value="Wartawan"> Wartawan </option>
                            <option value="Anggota DPR-RI"> Anggota DPR-RI </option>
                            <option value="Anggota DPD"> Anggota DPD </option>
                            <option value="Anggota BPK"> Anggota BPK </option>
                            <option value="Presiden"> Presiden </option>
                            <option value="Wakil Presiden"> Wakil Presiden </option>
                            <option value="Gubernur"> Gubernur </option>
                            <option value="Wakil Gubernur"> Wakil Gubernur </option>
                            <option value="Bupati"> Bupati </option>
                            <option value="Wakil Bupati"> Wakil Bupati </option>
                            <option value="Walikota"> Walikota </option>
                            <option value="Wakil Walikota"> Wakil Walikota </option>
                            <option value="Anggota DPRD Provinsi"> Anggota DPRD Provinsi </option>
                            <option value="Anggota DPRD Kabupaten/Kota"> Anggota DPRD Kabupaten/Kota </option>
                            <option value="Dosen"> Dosen </option>
                            <option value="Guru"> Guru </option>
                            <option value="Pilot"> Pilot </option>
                            <option value="Pengacara"> Pengacara </option>
                            <option value="Notaris"> Notaris </option>
                            <option value="Arsitek"> Arsitek </option>
                            <option value="Akuntan"> Akuntan </option>
                            <option value="Konsultan"> Konsultan </option>
                            <option value="Dokter"> Dokter </option>
                            <option value="Bidan"> Bidan </option>
                            <option value="Perawat"> Perawat </option>
                            <option value="Apoteker"> Apoteker </option>
                            <option value="Sopir"> Sopir </option>
                            <option value="Paranormal"> Paranormal </option>
                            <option value="Pedagang"> Pedagang </option>
                            <option value="Perangkat Desa"> Perangkat Desa </option>
                            <option value="Kepala Desa"> Kepala Desa </option>
                            <option value="Wiraswasta"> Wiraswasta </option>
                        </select>
                        <div class="invalid-feedback">
                            Lengkapi data dengan benar
                        </div>
                    </div>
                    <br>
                    <h5 class="form-heading"><strong>Data Kehilangan</strong></h5>
                    <div class="form-group">
                        <label>Keterangan barang yang hilang</label>
                        <textarea type="textarea" placeholder="Contoh: Dokumen Kartu Keluarga dan KTP pada tanggal 24 Juli 2024. Diperkirakan tercecer di sekitaran jalan ABCD" name="keterangan_usaha" id="keterangan_usaha" class="form-control" cols="100" rows="4" required></textarea>
                        <div class="invalid-feedback">
                            Isi dengan keterangan
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