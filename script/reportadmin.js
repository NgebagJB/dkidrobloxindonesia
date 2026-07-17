function showNotif(message, isSuccess) {
    const popup = document.getElementById('notifPopup');
    const msg = document.getElementById('notifMessage');
    popup.style.backgroundColor = isSuccess ? '#28a745' : '#dc3545';
    msg.textContent = message;
    popup.style.display = 'block';
    popup.style.opacity = '1';
    setTimeout(() => {
        popup.style.opacity = '0';
        setTimeout(() => { popup.style.display = 'none'; }, 300);
    }, 3000);
}

document.querySelectorAll('.btn-hapus-satu').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        const id = this.dataset.id;

        if (!confirm('Yakin ingin menghapus laporan ini? Data yang dihapus tidak bisa dikembalikan.')) {
            return;
        }

        const formData = new FormData();
        formData.append('id', id);

        fetch('../api/report_hapus_satu.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            showNotif(data.message, data.status === 'success');
            if (data.status === 'success') {
                setTimeout(() => location.reload(), 800);
            }
        })
        .catch(() => showNotif('Terjadi kesalahan koneksi ke server.', false));
    });
});

const btnHapusSemua = document.getElementById('btnHapusSemua');
if (btnHapusSemua) {
    btnHapusSemua.addEventListener('click', function () {
        if (!confirm('Yakin ingin menghapus SEMUA laporan? Tindakan ini tidak bisa dibatalkan!')) {
            return;
        }

        fetch('../api/report_hapus_semua.php', {
            method: 'POST'
        })
        .then(res => res.json())
        .then(data => {
            showNotif(data.message, data.status === 'success');
            if (data.status === 'success') {
                setTimeout(() => location.reload(), 800);
            }
        })
        .catch(() => showNotif('Terjadi kesalahan koneksi ke server.', false));
    });
}

const btnBackToTop = document.getElementById('btnBackToTop');

if (btnBackToTop) {
    window.addEventListener('scroll', function () {
        if (window.scrollY > 400) {
            btnBackToTop.style.display = 'flex';
            btnBackToTop.style.alignItems = 'center';
            btnBackToTop.style.justifyContent = 'center';
        } else {
            btnBackToTop.style.display = 'none';
        }
    });

    btnBackToTop.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}