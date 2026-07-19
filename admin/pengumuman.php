<?php
require "../api/cek_session.php";
require "../api/koneksi.php";

$stmt = $conn->prepare("SELECT id, judul, deskripsi, created_at FROM pengumuman ORDER BY created_at DESC");
$stmt->execute();
$stmt->bind_result($id, $judul, $deskripsi, $createdAt);

$dataPengumuman = [];
while ($stmt->fetch()) {
    $dataPengumuman[] = [
        'id'         => $id,
        'judul'      => $judul,
        'deskripsi'  => $deskripsi,
        'created_at' => $createdAt,
    ];
}
$stmt->close();

function formatTglJamPengumuman($datetime)
{
    if (!$datetime) return '-';
    $ts = strtotime($datetime);
    $hariMap = ['Sunday' => 'Sabtu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
    $hari = $hariMap[date('l', $ts)];
    return $hari . ', ' . date('d/m/Y H:i', $ts) . ' WIB';
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
    <title>DKID ROBLOX - Admin Announcement</title>
</head>

<body style="background-color: #031430;">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-blur fixed-top">
        <div class="container">
            <a href="" class="navbar-brand imej m-0">
                <img src="../Images/other/logo.png" alt="Logo" style="max-height: 50px;">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav text-center py-3 py-lg-0">
                    <li class="nav-item px-2"><a class="nav-link text-white" href="index.php">Home</a></li>
                    <li class="nav-item px-2"><a class="nav-link text-white" href="rekrut.php">Recruitment</a></li>
                    <li class="nav-item px-2"><a class="nav-link text-white" href="report.php">Report</a></li>
                    <li class="nav-item px-2"><a class="nav-link text-white" href="pengumuman.php">Announcement</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="py-5" style="padding-top: 120px !important;">
        <div class="container text-white" style="max-width: 650px;">
            <div id="notifPopup" style="
            display:none; position:fixed; top:100px; right:20px; z-index:9999;
            min-width:280px; max-width:350px; padding:16px 20px; border-radius:10px;
            color:#fff; font-weight:600; box-shadow:0 4px 15px rgba(0,0,0,0.3);
        ">
                <span id="notifMessage"></span>
            </div>

            <h2 class="fw-bold mb-4" style="font-size: 1.6rem; letter-spacing: 0.5px;">ANNOUNCEMENT SETUP</h2>

            <form id="formPengumuman" method="POST" class="mb-5">

                <div class="mb-3">
                    <label for="judul" class="form-label fw-semibold mb-2">Judul <span class="text-danger">*</span></label>
                    <input type="text" class="form-control px-3 py-2" id="judul" name="judul" required
                        style="border-radius: 10px; border: none;">
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="form-label fw-semibold mb-2">Catatan <span class="text-danger">*</span></label>
                    <textarea class="form-control px-3 py-2" id="deskripsi" name="deskripsi" rows="5" required
                        style="border-radius: 15px; border: none; resize: none;"></textarea>
                </div>

                <button type="submit" id="btnSubmitForm" class="btn btn-warning">Buat Pengumuman</button>
            </form>

            <h2 class="fw-bold mb-4 pt-3" style="font-size: 1.6rem; letter-spacing: 0.5px;">ANNOUNCEMENT HISTORY</h2>

            <?php if (empty($dataPengumuman)): ?>
                <p class="text-white-50">Belum ada pengumuman yang dibuat.</p>
            <?php endif; ?>

            <?php foreach ($dataPengumuman as $item): ?>
                <div class="bg-white text-dark p-4 position-relative mb-4" style="border-radius: 15px;">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                        <h5 class="fw-bold mb-0 text-uppercase" style="font-size: 1.05rem; letter-spacing: 0.3px;">
                            <?= htmlspecialchars($item['judul']) ?>
                        </h5>
                        <span class="text-muted flex-shrink-0" style="font-size: 0.75rem;">
                            <?= formatTglJamPengumuman($item['created_at']) ?>
                        </span>
                    </div>
                    <p class="text-secondary mb-3" style="font-size: 0.9rem; line-height: 1.5;">
                        <?= nl2br(htmlspecialchars($item['deskripsi'])) ?>
                    </p>

                    <div class="d-flex justify-content-end gap-3" style="font-size: 0.85rem;">
                        <a href="#" class="text-primary text-decoration-none d-inline-flex align-items-center opacity-75 hover-opacity-100 btn-edit-pengumuman" data-id="<?= $item['id'] ?>">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                        <a href="#" class="text-danger text-decoration-none d-inline-flex align-items-center opacity-75 hover-opacity-100 btn-hapus-pengumuman" data-id="<?= $item['id'] ?>">
                            <i class="bi bi-trash3 me-1"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </section>

    <div id="modalEditPengumuman" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.7); z-index:9998; justify-content:center; align-items:center; padding:20px;">
        <div style="background:#031430; color:#fff; max-width:550px; width:100%; max-height:88vh; overflow-y:auto; border-radius:20px; padding:35px; position:relative;">
            <button id="closeModalEditPengumuman" type="button" style="position:absolute; top:18px; right:18px; background:transparent; border:none; color:#fff; font-size:1.6rem; cursor:pointer;">&times;</button>

            <h4 class="fw-bold mb-4" style="font-size: 1.3rem;">EDIT PENGUMUMAN</h4>

            <form id="formEditPengumuman" method="POST">
                <input type="hidden" id="edit_pengumuman_id" name="id" value="">

                <div class="mb-3">
                    <label for="edit_judul" class="form-label fw-semibold mb-2">Judul <span class="text-danger">*</span></label>
                    <input type="text" class="form-control px-3 py-2" id="edit_judul" name="judul" required
                        style="border-radius: 10px; border: none;">
                </div>

                <div class="mb-4">
                    <label for="edit_deskripsi" class="form-label fw-semibold mb-2">Catatan <span class="text-danger">*</span></label>
                    <textarea class="form-control px-3 py-2" id="edit_deskripsi" name="deskripsi" rows="5" required
                        style="border-radius: 15px; border: none; resize: none;"></textarea>
                </div>

                <button type="submit" id="btnUpdatePengumuman" class="btn btn-warning">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <style>
        .hover-opacity-100:hover {
            opacity: 1 !important;
        }
    </style>

    <script>
        const dataPengumuman = <?= json_encode($dataPengumuman) ?>;
    </script>
    <script src="../script/pengumumanadmin.js"></script>
</body>

</html>