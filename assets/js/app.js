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
    'use strict';

    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                form.submit(); 
            }
            form.classList.add('was-validated');
            addCheckIcons(form);
        }, false);
    });
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

/* ADD .active ON MENU ITEM */
var currentPath = window.location.pathname;
var menuItems = document.querySelectorAll('.nav-link');
menuItems.forEach(function (menuItem) {
    var href = menuItem.getAttribute('href');

    // Cek apakah href dari link sama dengan URL saat ini atau jika beranda (../ atau /)
    if ((href === currentPath.split('/').pop()) || (href === '../' && currentPath === '/') || (href === '/' && currentPath === '/')) {
        // Tambahkan class 'active' pada elemen yang cocok
        menuItem.classList.add('active');
    }
});

/* Login error message */
document.addEventListener('DOMContentLoaded', function() {
    // Cek apakah ada parameter error di URL
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');

    // Jika ada parameter error, tampilkan modal
    if (error) {
        let errorMessage = '';

        if (error === 'password') {
            errorMessage = 'Password yang Anda masukkan salah.';
        } else if (error === 'username') {
            errorMessage = 'Username tidak ditemukan.';
        }

        // Masukkan pesan error ke dalam modal
        document.getElementById('errorMessage').innerText = errorMessage;

        // Tampilkan modal
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    }
  });