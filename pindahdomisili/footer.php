<div class="container footer">
      <div class="row">
            <div class="col-sm-6 col-md-6 col-xs-6 col-lg-6">
                <p>      
                    <?php if ($data_desa && !empty($data_desa['logo_desa'])): ?>
                        <img src="../assets/images/<?php echo $data_desa['logo_desa']; ?>" alt="Logo Desa" class="logo-desa">
                    <?php else: ?>
                        <img src="../assets/images/eksotik.png" height="48" alt="Desa Tunjungrejo" class="d-inline-block align-text-top">
                    <?php endif; ?>    
                </p>
                <p>Website layanan surat keterangan mandiri dibuat untuk memudahkan masyarakat dalam mengurus surat-surat keterangan desa dengan tujuan untuk mewujudkan desa digital yang mandiri.</p>
                <p>
            </div>
            <div class="col-sm-6 col-md-6 col-xs-6 col-lg-6"">
                <strong>Alamat :</strong> <br>
                <span class="alamat_balai_desa"></span><br/>
                Desa <span class="nama_desa"></span> - Kecamatan <span class="data_kecamatan"></span> - Kabupaten <span class="data_kabupaten"></span><br/>
                <span class="data_provinsi"></span>
                </p>
                <p>
                    <strong>Kontak :</strong> <br>
                    Email : <span class="alamat_email"></span> <br>
                WhatsApp : <span class="nomor_whatsapp"></span>
                </p>
                <p class="tanggal-jam">
                    <strong>Waktu saat ini :</strong> <br>
                    <span id="tanggal" onload="showDate()"></span> - <span id="jam" class="clock" onload="showTime()"></span>
                </p>
            </div>
      </div>
      <div class="row">
        <div class="col">
            <p>©2025<strong><a href="https://suketdesa.id"> SuketDesa.id</a></strong>. Hak cipta dilindungi.<br/>Desain dan pengembangan oleh <strong><a href="https://reneastudio.com">Renea Studio</a></strong>.</p>
        </div>
      </div>
  </div>
  
  <script src="../assets/js/browser-check.js"></script>