document.addEventListener('DOMContentLoaded', function() {
    // Cek apakah browser adalah Firefox
    if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
        // Buat elemen alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'firefox-alert shadow';
        
        const message = document.createElement('p');
        message.textContent = 'Untuk hasil cetak PDF terbaik, kami sarankan menggunakan browser Google Chrome.';
        
        const closeBtn = document.createElement('button');
        closeBtn.className = 'btn btn-dark close-btn';
        closeBtn.innerHTML = '&times;';
        closeBtn.onclick = function() {
            alertDiv.style.display = 'none';
        };
        
        alertDiv.appendChild(message);
        alertDiv.appendChild(closeBtn);
        
        // Tambahkan alert ke body
        document.body.appendChild(alertDiv);
    }
});
