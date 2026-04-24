/* TANGGAL DAN JAM */
function formatTimeUnit(unit) {
    return unit < 10 ? "0" + unit : unit;
}

function showTime() {
    const date = new Date();
    let h = date.getHours();
    const m = formatTimeUnit(date.getMinutes());
    const s = formatTimeUnit(date.getSeconds());

    h = h % 12 || 12;
    h = formatTimeUnit(h);

    const time = `${h}:${m}:${s}`;
    const jamElement = document.getElementById("jam");
    jamElement.innerText = time;
    jamElement.textContent = time;

    setTimeout(showTime, 1000);
}
showTime();

function showDate() {
    const today = new Date();
    const dd = formatTimeUnit(today.getDate());
    const mm = formatTimeUnit(today.getMonth() + 1);
    const yyyy = today.getFullYear();

    const formattedDate = `${dd}/${mm}/${yyyy}`;
    const tanggalElement = document.getElementById("tanggal");
    tanggalElement.innerText = formattedDate;
    tanggalElement.textContent = formattedDate;
}
showDate();

/* BULAN DALAM BAHASA INDONESIA
   UNTUK DITAMPILKAN DALAM SURAT
   */
function getFormattedDate() {
    const bulanIndonesia = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    const sekarang = new Date();
    const hari = String(sekarang.getDate()).padStart(2, '0'); // Menambahkan 0 di depan jika angka hanya 1 digit
    const bulan = bulanIndonesia[sekarang.getMonth()]; // Mengambil nama bulan dari array
    const tahun = sekarang.getFullYear();

    return `${hari} ${bulan} ${tahun}`;
}


/* MENAMPILKAN VALUE DARI DATABASE KE DALAM SURAT 
   UNTUK DIJADIKAN PDF */
function formatTanggal(tanggal) {
    // Pastikan tanggal tidak null atau undefined sebelum di-split
    if (tanggal) {
        var parts = tanggal.split("-");
        // Pastikan parts memiliki 3 elemen sebelum mengaksesnya
        if (parts.length === 3) {
            return parts[2] + "-" + parts[1] + "-" + parts[0];
        }
    }
    return ""; // Kembalikan string kosong jika tanggal tidak valid
}

function formatTanggalKelahiran(tanggal) {
    if (!tanggal) return "";

    const hariIndonesia = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    
    const date = new Date(tanggal);
    const hari = hariIndonesia[date.getDay()];
    const tgl = String(date.getDate()).padStart(2, '0');
    const bulan = String(date.getMonth() + 1).padStart(2, '0');
    const tahun = date.getFullYear();

    return `${hari}, ${tgl}-${bulan}-${tahun}`;
}

function setValueByClassName(className, value) {
    const elements = document.getElementsByClassName(className);
    for (let element of elements) {
        element.innerText = value || ''; // Isi dengan string kosong jika value null atau undefined
    }
}

window.onload = function () {
    const urlParams = new URLSearchParams(window.location.search);
    const nik = urlParams.get('nik');
    const dataString = urlParams.get('data');

    setValueByClassName('nik', nik);

    if (dataString) {
        const dataArray = dataString.split(',').map(item => decodeURIComponent(item));

        // Urutan data sesuai dengan yang dikirim dari collect-data.js
        // dan di-parse di printPage.php
        setValueByClassName('nama_ayah', dataArray[0]);
        setValueByClassName('nik_ayah', dataArray[1]);
        setValueByClassName('tempat_lahir_ayah', dataArray[2]);
        setValueByClassName('tanggal_lahir_ayah', formatTanggal(dataArray[3]));
        setValueByClassName('agama_ayah', dataArray[4]);
        setValueByClassName('pekerjaan_ayah', dataArray[5]);
        setValueByClassName('alamat_ayah', dataArray[6]);
        setValueByClassName('nama_ibu', dataArray[7]);
        setValueByClassName('nik_ibu', dataArray[8]);
        setValueByClassName('tempat_lahir_ibu', dataArray[9]);
        setValueByClassName('tanggal_lahir_ibu', formatTanggal(dataArray[10]));
        setValueByClassName('agama_ibu', dataArray[11]); // Ini akan diisi dari data user
        setValueByClassName('pekerjaan_ibu', dataArray[12]); // Ini akan diisi dari data user
        setValueByClassName('alamat_ibu', dataArray[13]); // Ini akan diisi dari data user
        setValueByClassName('nama_anak', dataArray[14]); // Ini akan diisi dari data user
        setValueByClassName('tempat_lahir_anak', dataArray[15]); // Ini akan diisi dari data user
        setValueByClassName('tanggal_lahir_anak', formatTanggalKelahiran(dataArray[16]));
        setValueByClassName('anak_ke', dataArray[17]);
        setValueByClassName('jenis_kelamin_anak', dataArray[18]);
        
        // Untuk nama_desa, data_kecamatan, data_kabupaten di header surat dan di bagian tanda tangan,
        // sebaiknya diambil dari variabel PHP $data_desa yang sudah ada di printPage.php
        // atau jika ingin tetap dari JS, pastikan data tersebut ada di `dataArray`
        // Contoh jika $data_desa sudah ada dan ingin diakses via JS (misal di-render ke atribut data-* atau variabel global JS oleh PHP)
        // Jika tidak, elemen span .nama_desa, .data_kecamatan, .data_kabupaten, .nama_kepala_desa akan tetap kosong
        // atau diisi oleh load-data-desa-suket.js jika skrip tersebut menangani ini.
    }

    document.getElementById('tanggal_sekarang').innerText = getFormattedDate();
    
    // Data desa seperti nama_desa, nama_kepala_desa, dll., yang digunakan di beberapa tempat di surat
    // (kop, isi, tanda tangan) sebaiknya diisi oleh skrip `../assets/js/load-data-desa-suket.js`
    // atau langsung dari variabel PHP `$data_desa` jika memungkinkan.
    // Periksa apakah `load-data-desa-suket.js` sudah mengisi elemen-elemen tersebut.
    // Jika belum, dan data tersebut ada di $data_desa (PHP), maka perlu cara untuk meneruskannya ke JS
    // atau langsung mengisi elemen span tersebut dari PHP.
    // Untuk saat ini, saya biarkan `load-data-desa-suket.js` yang mengurusnya.
}

// Fungsi untuk menampilkan modal loading
function showLoadingModal() {
    var loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
    loadingModal.show();
    return loadingModal;
}

function convertToPDFAndEmail() {
    const element = document.getElementById('pdf-content'); // Hanya konten PDF

    // Ambil nama lengkap dari elemen dengan kelas 'nama_lengkap'
    // Kita ambil yang pertama karena seharusnya hanya ada satu atau semua isinya sama
    const namaLengkapElement = document.querySelector('.nama_lengkap');
    let namaLengkap = 'Pemohon'; // Default name
    if (namaLengkapElement && namaLengkapElement.innerText.trim() !== '') {
        namaLengkap = namaLengkapElement.innerText.trim();
    }

    // Bersihkan nama lengkap untuk nama file (ganti spasi dengan underscore, hapus karakter tidak valid)
    const sanitizedNamaLengkap = namaLengkap.replace(/\s+/g, '_').replace(/[^a-zA-Z0-9_.-]/g, '');
    const filename = `Surat_Keterangan_Kelahiran_${sanitizedNamaLengkap}.pdf`;

    // Setting custom ukuran halaman
    const opt = {
        margin: [0.5, 2.54, 0.5, 2.54],
        filename: filename, // Gunakan nama file yang sudah dibuat
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'mm', format: [215, 330], orientation: 'portrait' }
    };

    // Tampilkan modal loading saat proses dimulai
    const loadingModal = showLoadingModal();

    // Generate PDF
    html2pdf().from(element).set(opt).output('blob').then((pdfBlob) => {
        const formData = new FormData();
        // Gunakan nama file yang sudah dibuat saat menambahkan ke FormData
        formData.append('pdf', pdfBlob, filename);
        
        // Ambil NIK dari URL parameters untuk dikirim ke send_email.php
        const urlParams = new URLSearchParams(window.location.search);
        const nik = urlParams.get('nik');
        if (nik) {
            formData.append('nik', nik);
        } else {
            console.warn('NIK tidak ditemukan di URL params untuk dikirim ke email.');
            // Server akan menggunakan default 'Pemohon' jika NIK tidak ada
        }
        // Pastikan NIK ditambahkan ke formData jika ada
        if (nik) {
            formData.append('nik', nik);
        } else {
            // Jika NIK tidak ada, mungkin kirim string kosong atau handle di server
            formData.append('nik', ''); 
            console.warn('NIK tidak ada di URL, mengirim NIK kosong ke server.');
        }

        // Kirim PDF dan NIK ke server menggunakan fetch ke skrip baru
        fetch('save_and_send_email.php', { // Ganti ke skrip baru
            method: 'POST',
            body: formData
        }).then(response => {
            // Cek jika respons adalah JSON sebelum mencoba parse
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.indexOf("application/json") !== -1) {
                return response.json().then(data => {
                    if (response.ok) {
                        loadingModal.hide();
                        window.location.href = 'finishPage.php'; // Redirect ke halaman finishPage
                    } else {
                        console.error('Gagal memproses permintaan:', data.message || 'Tidak ada pesan error spesifik.');
                        alert('Terjadi kesalahan: ' + (data.message || 'Silakan coba lagi.'));
                        loadingModal.hide();
                    }
                });
            } else {
                // Jika bukan JSON, mungkin ada error HTML atau teks biasa dari server
                return response.text().then(text => {
                    console.error('Respons server bukan JSON:', text);
                    alert('Terjadi kesalahan tak terduga dari server. Silakan cek log server.');
                    loadingModal.hide();
                });
            }
        }).catch(error => {
            console.error('Error saat fetch:', error);
            alert('Terjadi kesalahan jaringan atau koneksi. Silakan coba lagi.');
            loadingModal.hide(); // Tutup modal jika ada error
        });
    });
}

document.getElementById('download-btn').addEventListener('click', function () {
    convertToPDFAndEmail();
});
