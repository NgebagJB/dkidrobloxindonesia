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

document.getElementById('formPengumuman').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const btn = document.getElementById('btnSubmitForm');
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    const formData = new FormData(form);
    formData.append('id', '');

    fetch('../api/pengumuman_simpan.php', {
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

document.querySelectorAll('.btn-edit-pengumuman').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        const id = this.dataset.id;
        const item = dataPengumuman.find(p => p.id == id);
        if (!item) return;

        document.getElementById('edit_pengumuman_id').value = item.id;
        document.getElementById('edit_judul').value = item.judul;
        document.getElementById('edit_deskripsi').value = item.deskripsi;

        document.getElementById('modalEditPengumuman').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    });
});

document.getElementById('closeModalEditPengumuman').addEventListener('click', closeEditModalPengumuman);

function closeEditModalPengumuman() {
    document.getElementById('modalEditPengumuman').style.display = 'none';
    document.body.style.overflow = 'auto';
}

document.getElementById('formEditPengumuman').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const btn = document.getElementById('btnUpdatePengumuman');
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    const formData = new FormData(form);

    fetch('../api/pengumuman_simpan.php', {
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

document.querySelectorAll('.btn-hapus-pengumuman').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        const id = this.dataset.id;

        if (!confirm('Yakin ingin menghapus pengumuman ini? Data yang dihapus tidak bisa dikembalikan.')) {
            return;
        }

        const formData = new FormData();
        formData.append('id', id);

        fetch('../api/pengumuman_hapus.php', {
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