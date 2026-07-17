function formatTanggalJamJS(tanggal, waktu) {
    if (!tanggal) return '-';
    const [y, m, d] = tanggal.split('-');
    let hasil = `${d}/${m}/${y}`;
    if (waktu) {
        hasil += ' ' + waktu.substring(0, 5);
    }
    return hasil;
}

function initRekrutmenModal(dataRekrutmen) {
    document.querySelectorAll('.btn-read-more').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const item = dataRekrutmen.find(r => r.id == id);
            if (!item) return;

            document.getElementById('modalJudul').textContent = item.judul;
            document.getElementById('modalJenis').textContent = item.jenis || '-';

            document.getElementById('modalTanggalMulai').textContent =
                formatTanggalJamJS(item.tanggal_mulai, item.waktu_mulai);

            document.getElementById('modalTanggalBerakhir').textContent =
                formatTanggalJamJS(item.tanggal_berakhir, item.waktu_berakhir);

            document.getElementById('modalPersyaratan').textContent = item.persyaratan || '-';

            if (item.catatan && item.catatan.trim() !== '') {
                document.getElementById('modalCatatan').textContent = item.catatan;
                document.getElementById('modalCatatanWrapper').style.display = 'block';
            } else {
                document.getElementById('modalCatatanWrapper').style.display = 'none';
            }

            if (item.link_google_form && item.link_google_form.trim() !== '') {
                document.getElementById('modalLinkForm').href = item.link_google_form;
                document.getElementById('modalLinkWrapper').style.display = 'block';
            } else {
                document.getElementById('modalLinkWrapper').style.display = 'none';
            }

            document.getElementById('modalOverlay').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    });

    document.getElementById('closeModal').addEventListener('click', closeModalFunc);
    document.getElementById('modalOverlay').addEventListener('click', function (e) {
        if (e.target === this) closeModalFunc();
    });
}

function closeModalFunc() {
    document.getElementById('modalOverlay').style.display = 'none';
    document.body.style.overflow = 'auto';
}