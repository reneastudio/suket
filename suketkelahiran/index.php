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
        Surat Keterangan Kelahiran
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
                    <h5 class="form-heading"><strong>Identitas Ayah</strong></h5>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_ayah" id="nama_ayah" class="form-control" placeholder="Nama lengkap ayah" required>
                    </div>
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="number" name="nik_ayah" id="nik_ayah" class="form-control" placeholder="NIK ayah" required>
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayah" class="form-control" placeholder="Tempat lahir ayah" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Agama</label>
                        <select class="form-select" name="agama_ayah" id="agama_ayah" required>
                            <option selected disabled value="">Pilih...</option>
                            <option value="Buddha"> Buddha </option>
                            <option value="Hindu"> Hindu </option>
                            <option value="Islam"> Islam </option>
                            <option value="Katolik"> Katolik </option>
                            <option value="Kristen"> Kristen </option>
                            <option value="Konghucu"> Konghucu </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan</label>
                        <select class="form-select" name="pekerjaan_ayah" id="pekerjaan_ayah" required>
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
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat_ayah" id="alamat_ayah" class="form-control" rows="3" placeholder="Alamat ayah" required></textarea>
                    </div>
                    
                    <br/>

                    <h5 class="form-heading"><strong>Identitas Ibu</strong></h5>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" placeholder="Nama lengkap ibu" required>
                    </div>
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="number" name="nik_ibu" id="nik_ibu" class="form-control" placeholder="NIK ibu" required>
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_ibu" id="tempat_lahir_ibu" class="form-control" placeholder="Tempat lahir ibu" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Agama</label>
                        <select class="form-select" name="agama_ibu" id="agama_ibu" required>
                            <option selected disabled value="">Pilih...</option>
                            <option value="Buddha"> Buddha </option>
                            <option value="Hindu"> Hindu </option>
                            <option value="Islam"> Islam </option>
                            <option value="Katolik"> Katolik </option>
                            <option value="Kristen"> Kristen </option>
                            <option value="Konghucu"> Konghucu </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan</label>
                        <select class="form-select" name="pekerjaan_ibu" id="pekerjaan_ibu" required>
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
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="same_address" onchange="copyAddress()">
                            <label class="form-check-label" for="same_address">
                                Alamat sama dengan Ayah
                            </label>
                        </div>
                        <label>Alamat</label>
                        <textarea name="alamat_ibu" id="alamat_ibu" class="form-control" rows="3" placeholder="Alamat ibu" required></textarea>
                    </div>
                </div>

                <div class="col-sm-7 col-md-7 col-xs-7 col-lg-7 p-4 auto-fill">
                    <div class="auto-fill-form card text-bg-white border rounded">
                        <h5 class="form-heading"><strong>Identitas Anak</strong></h5>
                        <div class="form-group">
                            <label>Nama Lengkap Anak</label>
                            <input type="text" name="nama_anak" id="nama_anak" class="form-control"
                                placeholder="Contoh: Okta Afriyanti" value="" required>
                            <div class="invalid-feedback">
                                Isi dengan nama lengkap anak
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir_anak" id="tempat_lahir_anak" class="form-control"
                                placeholder="Contoh: Lumajang" value="" required>
                            <div class="invalid-feedback">
                                Isi dengan keterangan tempat meninggal
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir Anak</label>
                            <input type="date" name="tanggal_lahir_anak" id="tanggal_lahir_anak" class="form-control" required>
                            <div class="invalid-feedback">
                                Isi dengan tanggal lahir anak
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Anak ke</label>
                            <input type="number" name="anak_ke" id="anak_ke" class="form-control" placeholder="Contoh: 1" required>
                            <div class="invalid-feedback">
                                Isi dengan urutan anak
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin Anak</label>
                            <select class="form-select" name="jenis_kelamin_anak" id="jenis_kelamin_anak" required>
                                <option selected disabled value="">Pilih...</option>
                                <option value="Laki-laki"> Laki-laki </option>
                                <option value="Perempuan"> Perempuan </option>
                            </select>
                            <div class="invalid-feedback">
                                Pilih jenis kelamin anak
                            </div>
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

    <script>
        function copyAddress() {
            var checkbox = document.getElementById("same_address");
            var alamatAyah = document.getElementById("alamat_ayah").value;
            var alamatIbu = document.getElementById("alamat_ibu");

            if (checkbox.checked) {
                alamatIbu.value = alamatAyah;
            } else {
                alamatIbu.value = "";
            }
        }
    </script>
</body>

</html>