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

// Mengosongkan formulir
function clearForm() {
    document.getElementById("nama_ayah").value = "";
    document.getElementById("nik_ayah").value = "";
    document.getElementById("tempat_lahir_ayah").value = "";
    document.getElementById("tanggal_lahir_ayah").value = "";
    document.getElementById("agama_ayah").value = "";
    document.getElementById("pekerjaan_ayah").value = "";
    document.getElementById("alamat_ayah").value = "";
    document.getElementById("nama_ibu").value = "";
    document.getElementById("nik_ibu").value = "";
    document.getElementById("tempat_lahir_ibu").value = "";
    document.getElementById("tanggal_lahir_ibu").value = "";
    document.getElementById("agama_ibu").value = "";
    document.getElementById("pekerjaan_ibu").value = "";
    document.getElementById("alamat_ibu").value = "";
    document.getElementById("nama_anak").value = "";
    document.getElementById("tempat_lahir_anak").value = "";
    document.getElementById("tanggal_lahir_anak").value = "";
    document.getElementById("anak_ke").value = "";
    document.getElementById("jenis_kelamin_anak").value = "";
}

// Mengisi formulir dengan data
function populateForm(data) {
    document.getElementById("nama_ayah").value = data.nama_ayah;
    document.getElementById("nik_ayah").value = data.nik_ayah;
    document.getElementById("tempat_lahir_ayah").value = data.tempat_lahir_ayah;
    document.getElementById("tanggal_lahir_ayah").value = data.tanggal_lahir_ayah;
    document.getElementById("agama_ayah").value = data.agama_ayah;
    document.getElementById("pekerjaan_ayah").value = data.pekerjaan_ayah;
    document.getElementById("alamat_ayah").value = data.alamat_ayah;
    document.getElementById("nama_ibu").value = data.nama_ibu;
    document.getElementById("nik_ibu").value = data.nik_ibu;
    document.getElementById("tempat_lahir_ibu").value = data.tempat_lahir_ibu;
    document.getElementById("tanggal_lahir_ibu").value = data.tanggal_lahir_ibu;
    document.getElementById("agama_ibu").value = data.agama_ibu;
    document.getElementById("pekerjaan_ibu").value = data.pekerjaan_ibu;
    document.getElementById("alamat_ibu").value = data.alamat_ibu;
    document.getElementById("nama_anak").value = data.nama_anak;
    document.getElementById("tempat_lahir_anak").value = data.tempat_lahir_anak;
    document.getElementById("tanggal_lahir_anak").value = data.tanggal_lahir_anak;
    document.getElementById("anak_ke").value = data.anak_ke;
    document.getElementById("jenis_kelamin_anak").value = data.jenis_kelamin_anak;
}

function printData() {
    var nama_ayah = document.getElementById("nama_ayah").value;
    var nik_ayah = document.getElementById("nik_ayah").value;
    var tempat_lahir_ayah = document.getElementById("tempat_lahir_ayah").value;
    var tanggal_lahir_ayah = document.getElementById("tanggal_lahir_ayah").value;
    var agama_ayah = document.getElementById("agama_ayah").value;
    var pekerjaan_ayah = document.getElementById("pekerjaan_ayah").value;
    var alamat_ayah = document.getElementById("alamat_ayah").value;
    var nama_ibu = document.getElementById("nama_ibu").value;
    var nik_ibu = document.getElementById("nik_ibu").value;
    var tempat_lahir_ibu = document.getElementById("tempat_lahir_ibu").value;
    var tanggal_lahir_ibu = document.getElementById("tanggal_lahir_ibu").value;
    var agama_ibu = document.getElementById("agama_ibu").value;
    var pekerjaan_ibu = document.getElementById("pekerjaan_ibu").value;
    var alamat_ibu = document.getElementById("alamat_ibu").value;
    var nama_anak = document.getElementById("nama_anak").value;
    var tempat_lahir_anak = document.getElementById("tempat_lahir_anak").value;
    var tanggal_lahir_anak = document.getElementById("tanggal_lahir_anak").value;
    var anak_ke = document.getElementById("anak_ke").value;
    var jenis_kelamin_anak = document.getElementById("jenis_kelamin_anak").value;

    // Mengumpulkan data menjadi satu string dipisahkan koma
    var dataArray = [
        nama_ayah,
        nik_ayah,
        tempat_lahir_ayah,
        tanggal_lahir_ayah,
        agama_ayah,
        pekerjaan_ayah,
        alamat_ayah,
        nama_ibu,
        nik_ibu,
        tempat_lahir_ibu,
        tanggal_lahir_ibu,
        agama_ibu,
        pekerjaan_ibu,
        alamat_ibu,
        nama_anak,
        tempat_lahir_anak,
        tanggal_lahir_anak,
        anak_ke,
        jenis_kelamin_anak
    ];

    var dataString = dataArray.map(item => encodeURIComponent(item)).join(',');

    window.location.href = "printPage.php?data=" + dataString;
}
