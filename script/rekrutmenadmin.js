function formatTanggalJamJS(tanggal, waktu) {
    if (!tanggal) return '-';
    const [y, m, d] = tanggal.split('-');
    let hasil = `${d}/${m}/${y}`;
    if (waktu) hasil += ' ' + waktu.substring(0, 5);
    return hasil;
}

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

document.getElementById('formRekrutmen').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const btn = document.getElementById('btnSubmitForm');
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    const formData = new FormData(form);
    formData.append('id', '');

    fetch('../api/rekrut_simpan.php', {
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
    .catch(() => showNotif('Terjadi kesalahan koneksi ke server.', false))
    .finally(() => {
        btn.disabled = false;
        btn.textContent = originalText;
    });
});

document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        const id = this.dataset.id;
        const item = dataRekrutmen.find(r => r.id == id);
        if (!item) return;

        document.getElementById('edit_id').value = item.id;
        document.getElementById('edit_judul').value = item.judul;
        document.getElementById('edit_jenis').value = item.jenis;
        document.getElementById('edit_tanggal_mulai').value = item.tanggal_mulai;
        document.getElementById('edit_waktu_mulai').value = item.waktu_mulai ? item.waktu_mulai.substring(0,5) : '';
        document.getElementById('edit_tanggal_berakhir').value = item.tanggal_berakhir;
        document.getElementById('edit_waktu_berakhir').value = item.waktu_berakhir ? item.waktu_berakhir.substring(0,5) : '';
        document.getElementById('edit_persyaratan').value = item.persyaratan;
        document.getElementById('edit_catatan').value = item.catatan || '';
        document.getElementById('edit_link_gform').value = item.link_google_form || '';

        document.getElementById('modalEdit').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    });
});

document.getElementById('closeModalEdit').addEventListener('click', closeEditModal);

function closeEditModal() {
    document.getElementById('modalEdit').style.display = 'none';
    document.body.style.overflow = 'auto';
}

document.getElementById('formEditRekrutmen').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const btn = document.getElementById('btnUpdateRekrutmen');
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    const formData = new FormData(form);

    fetch('../api/rekrut_simpan.php', {
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
    .catch(() => showNotif('Terjadi kesalahan koneksi ke server.', false))
    .finally(() => {
        btn.disabled = false;
        btn.textContent = originalText;
    });
});

document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        const id = this.dataset.id;

        if (!confirm('Yakin ingin menghapus rekrutmen ini? Data yang dihapus tidak bisa dikembalikan.')) {
            return;
        }

        const formData = new FormData();
        formData.append('id', id);

        fetch('../api/rekrut_hapus.php', {
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

document.querySelectorAll('.btn-read-more').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        const id = this.dataset.id;
        const item = dataRekrutmen.find(r => r.id == id);
        if (!item) return;

        document.getElementById('detailJudul').textContent = item.judul;
        document.getElementById('detailJenis').textContent = item.jenis;
        document.getElementById('detailTanggalMulai').textContent = formatTanggalJamJS(item.tanggal_mulai, item.waktu_mulai);
        document.getElementById('detailTanggalBerakhir').textContent = formatTanggalJamJS(item.tanggal_berakhir, item.waktu_berakhir);
        document.getElementById('detailPersyaratan').textContent = item.persyaratan;
        document.getElementById('detailCatatan').textContent = item.catatan || '-';

        document.getElementById('modalDetail').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    });
});

document.getElementById('closeModalDetail').addEventListener('click', closeDetailModal);

function closeDetailModal() {
    document.getElementById('modalDetail').style.display = 'none';
    document.body.style.overflow = 'auto';
}