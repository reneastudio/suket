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


/* VALIDASI FORMULIR */
(() => {
    'use strict'

    const forms = document.querySelectorAll('.needs-validation')

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            } else {
                event.preventDefault();
                printData();
            }

            form.classList.add('was-validated');
            addCheckIcons(form);
        }, false)
    })
})();

function addCheckIcons(form) {
    const inputs = form.querySelectorAll('.form-control');
    inputs.forEach(input => {
        if (input.checkValidity()) {
            input.classList.add('is-valid');
        } else {
            input.classList.remove('is-valid');
        }
    });
}

/* MENAMPILKAN VALUE DARI DATABASE KE FORMULIR */
function GetDetail(nik) {
    if (nik.length === 16) {
        fetch('check_nik.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ 'nik': nik })
        })
        .then(response => response.json())
        .then(data => {
            const submitButton = document.querySelector('.formulir-btn');
            if (data.exists) {
                submitButton.disabled = false;

                // Mengambil detail NIK dari database
                return fetch('get_nik_detail.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({ 'nik': nik })
                });
            } else {
                submitButton.disabled = true;
                clearForm();
            }
        })
        .then(response => {
            if (response) {
                return response.json();
            }
        })
        .then(data => {
            if (data && data.success) {
                populateForm(data);
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        clearForm();
    }
}

// Mengosongkan formulir
function clearForm() {
    document.getElementById("nama_lengkap").value = "";
    document.getElementById("tempat_lahir").value = "";
    document.getElementById("tanggal_lahir").value = "";
    document.getElementById("jenis_kelamin").value = "";
    document.getElementById("agama").value = "";
    document.getElementById("status_perkawinan").value = "";
    document.getElementById("pekerjaan").value = "";
    document.getElementById("alamat").value = "";
    document.getElementById("rt").value = "";
    document.getElementById("rw").value = "";
    document.getElementById("dusun").value = "";
    document.getElementById("desa").value = "";
    document.getElementById("kecamatan").value = "";
    document.getElementById("kabupaten").value = "";
    document.getElementById("propinsi").value = "";
    document.getElementById("keterangan_usaha").value = "";
    document.getElementById("nama_desa").value = "";
    document.getElementById("nama_kepala_desa").value = "";
    document.getElementById("data_kecamatan").value = "";
    document.getElementById("data_kabupaten").value = "";
}

// Mengisi formulir dengan data
function populateForm(data) {
    document.getElementById("nama_lengkap").value = data.nama_lengkap;
    document.getElementById("tempat_lahir").value = data.tempat_lahir;
    document.getElementById("tanggal_lahir").value = data.tanggal_lahir;
    document.getElementById("jenis_kelamin").value = data.jenis_kelamin;
    document.getElementById("agama").value = data.agama;
    document.getElementById("status_perkawinan").value = data.status_perkawinan;
    document.getElementById("pekerjaan").value = data.pekerjaan;
    document.getElementById("alamat").value = data.alamat;
    document.getElementById("rt").value = data.rt;
    document.getElementById("rw").value = data.rw;
    document.getElementById("dusun").value = data.dusun;
    document.getElementById("desa").value = data.desa;
    document.getElementById("kecamatan").value = data.kecamatan;
    document.getElementById("kabupaten").value = data.kabupaten;
    document.getElementById("propinsi").value = data.propinsi;
    document.getElementById("keterangan_usaha").value = data.keterangan_usaha;
    document.getElementById("nama_desa").value = data.nama_desa;
    document.getElementById("nama_kepala_desa").value = data.nama_kepala_desa;
    document.getElementById("data_kecamatan").value = data.data_kecamatan;
    document.getElementById("data_kabupaten").value = data.data_kabupaten;
}

function printData() {
    var nik = document.getElementById("nik").value;
    var nama_lengkap = document.getElementById("nama_lengkap").value;
    var tempat_lahir = document.getElementById("tempat_lahir").value;
    var tanggal_lahir = document.getElementById("tanggal_lahir").value;
    var jenis_kelamin = document.getElementById("jenis_kelamin").value;
    var agama = document.getElementById("agama").value;
    var status_perkawinan = document.getElementById("status_perkawinan").value;
    var pekerjaan = document.getElementById("pekerjaan").value;
    var alamat = document.getElementById("alamat").value;
    var rt = document.getElementById("rt").value;
    var rw = document.getElementById("rw").value;
    var dusun = document.getElementById("dusun").value;
    var desa = document.getElementById("desa").value;
    var kecamatan = document.getElementById("kecamatan").value;
    var kabupaten = document.getElementById("kabupaten").value;
    var propinsi = document.getElementById("propinsi").value;
    var keterangan_usaha = document.getElementById("keterangan_usaha").value;
    // Data desa dan kepala desa tidak perlu dikirim via URL jika sudah ada di session atau diambil di printPage.php
    // var nama_desa = document.getElementById("nama_desa").value;
    // var nama_kepala_desa = document.getElementById("nama_kepala_desa").value;
    // var data_kecamatan = document.getElementById("data_kecamatan").value;
    // var data_kabupaten = document.getElementById("data_kabupaten").value;

    // Mengumpulkan data menjadi satu string dipisahkan koma
    var dataArray = [
        nama_lengkap,
        tempat_lahir,
        tanggal_lahir,
        jenis_kelamin,
        agama,
        status_perkawinan,
        pekerjaan,
        alamat,
        rt,
        rw,
        dusun,
        desa,
        kecamatan,
        kabupaten,
        propinsi,
        keterangan_usaha
        // nama_desa, // Jika masih diperlukan, tambahkan kembali
        // nama_kepala_desa, // Jika masih diperlukan, tambahkan kembali
        // data_kecamatan, // Jika masih diperlukan, tambahkan kembali
        // data_kabupaten // Jika masih diperlukan, tambahkan kembali
    ];

    var dataString = dataArray.map(item => encodeURIComponent(item)).join(',');

    window.location.href = "printPage.php?nik=" + encodeURIComponent(nik) +
        "&data=" + dataString;
}

// Fungsi untuk mengecek NIK dan menonaktifkan/aktifkan tombol submit
// Inisialisasi, tombol submit dinonaktifkan saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const submitButton = document.querySelector('.formulir-btn');
    submitButton.disabled = true;
});

// Event listener pada input NIK
document.getElementById('nik').addEventListener('input', function() {
    const nik = this.value;
    GetDetail(nik);
});
