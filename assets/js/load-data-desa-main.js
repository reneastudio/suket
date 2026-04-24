fetch('get_desa_data.php')
    .then(response => response.json())
    .then(data => {
        if (!data.error) {
            // Isi data ke elemen dengan class yang sesuai
            document.querySelectorAll('.nama_desa').forEach(el => {
                el.textContent = data.nama_desa;
            });
            document.querySelectorAll('.alamat_balai_desa').forEach(el => {
                el.textContent = data.alamat_balai_desa;
            });
            document.querySelectorAll('.data_kecamatan').forEach(el => {
                el.textContent = data.data_kecamatan;
            });
            document.querySelectorAll('.data_kabupaten').forEach(el => {
                el.textContent = data.data_kabupaten;
            });
            document.querySelectorAll('.data_provinsi').forEach(el => {
                el.textContent = data.data_provinsi;
            });
            document.querySelectorAll('.nomor_whatsapp').forEach(el => {
                el.textContent = data.nomor_whatsapp;
            });
            document.querySelectorAll('.alamat_email').forEach(el => {
                el.textContent = data.alamat_email;
            });
            
            // Untuk gambar
            if (data.logo_desa) {
                document.querySelectorAll('.logo_desa').forEach(el => {
                    el.src = '../assets/uploads/' + data.logo_desa;
                });
            }
            
            if (data.kop_surat) {
                document.querySelectorAll('.kop_surat').forEach(el => {
                    el.src = '../assets/uploads/' + data.kop_surat;
                });
            }
        }
    });