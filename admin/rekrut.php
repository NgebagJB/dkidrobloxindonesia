<?php
require "../api/cek_session.php";
require "../api/koneksi.php";

$result = $conn->query("SELECT * FROM rekrutmen ORDER BY created_at DESC");
$dataRekrutmen = [];
while ($row = $result->fetch_assoc()) {
    $dataRekrutmen[] = $row;
}

function formatTgl($tanggal, $waktu)
{
    if (!$tanggal) return '-';
    $parts = explode('-', $tanggal);
    $hasil = $parts[2] . '/' . $parts[1] . '/' . $parts[0];
    if ($waktu) $hasil .= ' ' . substr($waktu, 0, 5);
    return $hasil;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../style/style.css">

    <link rel="icon" type="image/png" href="/Images/logo11.png">
    <title>DKID ROBLOX - Admin Rekrutmen</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-blur fixed-top">
        <div class="container">

            <a href="" class="navbar-brand imej m-0">
                <img src="../Images/other/logo.png" alt="Logo" style="max-height: 50px;">
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav text-center py-3 py-lg-0">
                    <li class="nav-item px-2">
                        <a class="nav-link text-white" href="index.php">Home</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link text-white" href="rekrut.php">Recruitment</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link text-white" href="report.php">Report</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <section class="py-5" style="background-color: #031430; padding-top: 120px !important;">
        <div class="container text-white" style="max-width: 650px;">
            <div id="notifPopup" style="
            display:none; position:fixed; top:100px; right:20px; z-index:9999;
            min-width:280px; max-width:350px; padding:16px 20px; border-radius:10px;
            color:#fff; font-weight:600; box-shadow:0 4px 15px rgba(0,0,0,0.3);
        ">
                <span id="notifMessage"></span>
            </div>

            <h2 class="fw-bold mb-4" style="font-size: 1.6rem; letter-spacing: 0.5px;">RECRUITMENT SETUP</h2>

            <form id="formRekrutmen" method="POST" class="mb-5">

                <div class="mb-3">
                    <label for="judul" class="form-label fw-semibold mb-2">Judul Rekrutmen <span class="text-danger">*</span></label>
                    <input type="text" class="form-control px-3 py-2" id="judul" name="judul" required
                        style="border-radius: 10px; border: none;">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold mb-2">Durasi Mulai <span class="text-danger">*</span></label>
                    <div class="row g-2">
                        <div class="col-8">
                            <input type="date" class="form-control px-3 py-2" id="tanggal_mulai" name="tanggal_mulai" required
                                style="border-radius: 10px; border: none;">
                        </div>
                        <div class="col-4">
                            <input type="time" class="form-control px-3 py-2" id="waktu_mulai" name="waktu_mulai" required
                                style="border-radius: 10px; border: none;">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold mb-2">Durasi Selesai <span class="text-danger">*</span></label>
                    <div class="row g-2">
                        <div class="col-8">
                            <input type="date" class="form-control px-3 py-2" id="tanggal_berakhir" name="tanggal_berakhir" required
                                style="border-radius: 10px; border: none;">
                        </div>
                        <div class="col-4">
                            <input type="time" class="form-control px-3 py-2" id="waktu_berakhir" name="waktu_berakhir" required
                                style="border-radius: 10px; border: none;">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="jenis" class="form-label fw-semibold mb-2">Jenis Rekrutmen <span class="text-danger">*</span></label>
                    <select class="form-select px-3 py-2" id="jenis" name="jenis" required
                        style="border-radius: 10px; border: none;">
                        <option value="" selected disabled>Silahkan Dipilih Dulu</option>
                        <option value="Project based contract">Project based contract</option>
                        <option value="Permanent Developer">Permanent Developer</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="persyaratan" class="form-label fw-semibold mb-2">Persyaratan <span class="text-danger">*</span></label>
                    <textarea class="form-control px-3 py-2" id="persyaratan" name="persyaratan" rows="4"
                        placeholder="Contoh :&#10;- Dapat memainkan roblox studio&#10;- Berpengalaman minimal 1 tahun&#10;- Tidak mempunyai jejak rekam buruk"
                        required style="border-radius: 15px; border: none; resize: none;"></textarea>
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label fw-semibold mb-2">Catatan</label>
                    <textarea class="form-control px-3 py-2" id="catatan" name="catatan" rows="3"
                        placeholder="Contoh : akan diumumkan di discord kami"
                        style="border-radius: 15px; border: none; resize: none;"></textarea>
                </div>

                <div class="mb-4">
                    <label for="link_gform" class="form-label fw-semibold mb-2">Link Google Form <span class="text-danger">*</span></label>
                    <input type="url" class="form-control px-3 py-2" id="link_gform" name="link_google_form" required
                        style="border-radius: 10px; border: none;">
                </div>

                <button type="submit" id="btnSubmitForm" class="btn btn-warning">Buat Rekrutmen</button>
            </form>

            <h2 class="fw-bold mb-4 pt-3" style="font-size: 1.6rem; letter-spacing: 0.5px;">RECRUITMENT HISTORY</h2>

            <?php if (empty($dataRekrutmen)): ?>
                <p class="text-white-50">Belum ada rekrutmen yang dibuat.</p>
            <?php endif; ?>

            <?php foreach ($dataRekrutmen as $item): ?>
                <div class="bg-white text-dark p-4 position-relative mb-4" style="border-radius: 15px;">
                    <h5 class="fw-bold mb-2 text-uppercase" style="font-size: 1.05rem; letter-spacing: 0.3px;">
                        <?= htmlspecialchars($item['judul']) ?>
                    </h5>
                    <div class="text-muted mb-3" style="font-size: 0.85rem; line-height: 1.6;">
                        <div>Tanggal Mulai : <?= formatTgl($item['tanggal_mulai'], $item['waktu_mulai']) ?> || Berakhir : <?= formatTgl($item['tanggal_berakhir'], $item['waktu_berakhir']) ?></div>
                        <div>Jenis : <?= htmlspecialchars($item['jenis']) ?></div>
                        <div>Persyaratan : <a href="#" class="text-primary text-decoration-none fw-semibold btn-read-more" data-id="<?= $item['id'] ?>">Read More...</a></div>
                    </div>

                    <div class="position-absolute bottom-0 end-0 p-3 d-flex gap-3" style="font-size: 0.85rem;">
                        <a href="#" class="text-primary text-decoration-none d-inline-flex align-items-center opacity-75 hover-opacity-100 btn-edit" data-id="<?= $item['id'] ?>">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                        <a href="#" class="text-danger text-decoration-none d-inline-flex align-items-center opacity-75 hover-opacity-100 btn-hapus" data-id="<?= $item['id'] ?>">
                            <i class="bi bi-trash3 me-1"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </section>

    <div id="modalEdit" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.7); z-index:9998; justify-content:center; align-items:center; padding:20px;">
        <div style="background:#031430; color:#fff; max-width:600px; width:100%; max-height:88vh; overflow-y:auto; border-radius:20px; padding:35px; position:relative;">
            <button id="closeModalEdit" type="button" style="position:absolute; top:18px; right:18px; background:transparent; border:none; color:#fff; font-size:1.6rem; cursor:pointer;">&times;</button>

            <h4 class="fw-bold mb-4" style="font-size: 1.3rem;">EDIT REKRUTMEN</h4>

            <form id="formEditRekrutmen" method="POST">
                <input type="hidden" id="edit_id" name="id" value="">

                <div class="mb-3">
                    <label for="edit_judul" class="form-label fw-semibold mb-2">Judul Rekrutmen <span class="text-danger">*</span></label>
                    <input type="text" class="form-control px-3 py-2" id="edit_judul" name="judul" required
                        style="border-radius: 10px; border: none;">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold mb-2">Durasi Mulai <span class="text-danger">*</span></label>
                    <div class="row g-2">
                        <div class="col-8">
                            <input type="date" class="form-control px-3 py-2" id="edit_tanggal_mulai" name="tanggal_mulai" required
                                style="border-radius: 10px; border: none;">
                        </div>
                        <div class="col-4">
                            <input type="time" class="form-control px-3 py-2" id="edit_waktu_mulai" name="waktu_mulai" required
                                style="border-radius: 10px; border: none;">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold mb-2">Durasi Selesai <span class="text-danger">*</span></label>
                    <div class="row g-2">
                        <div class="col-8">
                            <input type="date" class="form-control px-3 py-2" id="edit_tanggal_berakhir" name="tanggal_berakhir" required
                                style="border-radius: 10px; border: none;">
                        </div>
                        <div class="col-4">
                            <input type="time" class="form-control px-3 py-2" id="edit_waktu_berakhir" name="waktu_berakhir" required
                                style="border-radius: 10px; border: none;">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="edit_jenis" class="form-label fw-semibold mb-2">Jenis Rekrutmen <span class="text-danger">*</span></label>
                    <select class="form-select px-3 py-2" id="edit_jenis" name="jenis" required
                        style="border-radius: 10px; border: none;">
                        <option value="" disabled>Silahkan Dipilih Dulu</option>
                        <option value="Project based contract">Project based contract</option>
                        <option value="Permanent Developer">Permanent Developer</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="edit_persyaratan" class="form-label fw-semibold mb-2">Persyaratan <span class="text-danger">*</span></label>
                    <textarea class="form-control px-3 py-2" id="edit_persyaratan" name="persyaratan" rows="4" required
                        style="border-radius: 15px; border: none; resize: none;"></textarea>
                </div>

                <div class="mb-3">
                    <label for="edit_catatan" class="form-label fw-semibold mb-2">Catatan</label>
                    <textarea class="form-control px-3 py-2" id="edit_catatan" name="catatan" rows="3"
                        style="border-radius: 15px; border: none; resize: none;"></textarea>
                </div>

                <div class="mb-4">
                    <label for="edit_link_gform" class="form-label fw-semibold mb-2">Link Google Form <span class="text-danger">*</span></label>
                    <input type="url" class="form-control px-3 py-2" id="edit_link_gform" name="link_google_form" required
                        style="border-radius: 10px; border: none;">
                </div>

                <button type="submit" id="btnUpdateRekrutmen" class="btn btn-warning">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <style>
        .hover-opacity-100:hover {
            opacity: 1 !important;
        }
    </style>

    <script>
        const dataRekrutmen = <?= json_encode($dataRekrutmen) ?>;
    </script>
    <script src="../script/rekrutmenadmin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>