<?php
require "../api/cek_session.php";
require "../api/koneksi.php";

$filterJenis = trim($_GET['jenis'] ?? '');
$filterDari  = trim($_GET['dari'] ?? '');
$filterSampai = trim($_GET['sampai'] ?? '');

$sql = "SELECT id, nama, email, topik, penjelasan, ip_address, created_at FROM contact_messages WHERE 1=1";
$params = [];
$types = '';

if (!empty($filterJenis)) {
    $sql .= " AND topik = ?";
    $params[] = $filterJenis;
    $types .= 's';
}

if (!empty($filterDari)) {
    $sql .= " AND DATE(created_at) >= ?";
    $params[] = $filterDari;
    $types .= 's';
}

if (!empty($filterSampai)) {
    $sql .= " AND DATE(created_at) <= ?";
    $params[] = $filterSampai;
    $types .= 's';
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$stmt->bind_result($id, $nama, $email, $topik, $penjelasan, $ipAddress, $createdAt);

$dataReport = [];
while ($stmt->fetch()) {
    $dataReport[] = [
        'id'         => $id,
        'nama'       => $nama,
        'email'      => $email,
        'topik'      => $topik,
        'penjelasan' => $penjelasan,
        'ip_address' => $ipAddress,
        'created_at' => $createdAt,
    ];
}
$stmt->close();

function formatTglJam($datetime) {
    if (!$datetime) return '-';
    $ts = strtotime($datetime);
    return date('d/m/Y H:i', $ts);
}

function labelTopik($topik) {
    $map = [
        'bug'     => 'Laporan Bug',
        'cheat'   => 'Laporkan Pemain',
        'staff'   => 'Laporkan Staff Kami',
        'saran'   => 'Kritik & Saran',
        'banned'  => 'Ajukan Banding',
        'lainnya' => 'Lainnya',
    ];
    return $map[$topik] ?? $topik;
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
    <title>DKID ROBLOX - Admin Report</title>
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
            </ul>
        </div>
    </div>
</nav>

<section class="py-5" padding-top: 120px !important; style="margin-top: 3rem;">
    <div class="container text-white" style="max-width: 750px;">
        <div id="notifPopup" style="
            display:none; position:fixed; top:100px; right:20px; z-index:9999;
            min-width:280px; max-width:350px; padding:16px 20px; border-radius:10px;
            color:#fff; font-weight:600; box-shadow:0 4px 15px rgba(0,0,0,0.3);
        ">
            <span id="notifMessage"></span>
        </div>

        <h2 class="fw-bold mb-4" style="font-size: 1.6rem; letter-spacing: 0.5px;">REPORT HISTORY</h2>

        <form id="formFilter" method="GET" class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-5">

            <div class="d-flex flex-wrap gap-2 flex-grow-1" style="max-width: 520px;">
                <div style="flex: 1; min-width: 140px;">
                    <label class="form-label small text-white-50 mb-1" style="font-size: 0.75rem;"><i class="bi bi-tag-fill me-1"></i>Jenis</label>
                    <select name="jenis" class="form-select form-select-sm py-1.5" style="border-radius: 6px; border: none; font-size: 0.85rem;">
                        <option value="" <?= $filterJenis === '' ? 'selected' : '' ?>>Semua Jenis</option>
                        <option value="bug" <?= $filterJenis === 'bug' ? 'selected' : '' ?>>Laporan Bug</option>
                        <option value="cheat" <?= $filterJenis === 'cheat' ? 'selected' : '' ?>>Laporkan Pemain</option>
                        <option value="staff" <?= $filterJenis === 'staff' ? 'selected' : '' ?>>Laporkan Staff Kami</option>
                        <option value="saran" <?= $filterJenis === 'saran' ? 'selected' : '' ?>>Kritik & Saran</option>
                        <option value="banned" <?= $filterJenis === 'banned' ? 'selected' : '' ?>>Ajukan Banding</option>
                        <option value="lainnya" <?= $filterJenis === 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>

                <div style="flex: 1; min-width: 140px;">
                    <label class="form-label small text-white-50 mb-1" style="font-size: 0.75rem;"><i class="bi bi-calendar-event-fill me-1"></i>Dari</label>
                    <input type="date" name="dari" value="<?= htmlspecialchars($filterDari) ?>" class="form-control form-control-sm py-1.5 text-secondary" style="border-radius: 6px; border: none; font-size: 0.85rem;">
                </div>

                <div style="flex: 1; min-width: 140px;">
                    <label class="form-label small text-white-50 mb-1" style="font-size: 0.75rem;"><i class="bi bi-calendar-event-fill me-1"></i>Sampai</label>
                    <input type="date" name="sampai" value="<?= htmlspecialchars($filterSampai) ?>" class="form-control form-control-sm py-1.5 text-secondary" style="border-radius: 6px; border: none; font-size: 0.85rem;">
                </div>

                <div class="d-flex align-items-end">
                    <button type="submit" class="btn btn-sm btn-light" style="border-radius: 6px; font-size: 0.85rem;">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                </div>
            </div>

            <div>
                <button type="button" id="btnHapusSemua" class="btn btn-danger btn-sm px-3 py-1.5 d-inline-flex align-items-center fw-semibold shadow-sm" style="background-color: #e04f36; border: none; border-radius: 4px; font-size: 0.85rem;">
                    <i class="bi bi-trash3-fill me-2"></i> Hapus Semua
                </button>
            </div>

        </form>

        <div class="d-flex flex-column gap-3">

            <?php if (empty($dataReport)): ?>
                <p class="text-white-50 text-center py-4">Tidak ada laporan yang cocok dengan filter ini.</p>
            <?php endif; ?>

            <?php foreach ($dataReport as $item): ?>
            <div class="bg-white text-dark p-4 position-relative shadow-sm" style="border-radius: 12px;">
                <h5 class="fw-bold mb-3 text-uppercase" style="font-size: 1.15rem; letter-spacing: 0.3px; color: #000000;">
                    <?= htmlspecialchars(labelTopik($item['topik'])) ?>
                </h5>
                <div class="mb-4" style="font-size: 0.95rem; line-height: 1.6; color: #333333;">
                    <div>Nama : <?= htmlspecialchars($item['nama'] ?: '-') ?></div>
                    <div>Email : <?= htmlspecialchars($item['email']) ?></div>
                    <div>Penjelasan : <?= nl2br(htmlspecialchars($item['penjelasan'])) ?></div>
                </div>
                <span class="position-absolute bottom-0 start-0 p-3 text-muted" style="font-size: 0.7rem;">
                    <?= formatTglJam($item['created_at']) ?>
                </span>
                <a href="#" class="position-absolute bottom-0 end-0 p-3 text-danger opacity-75 hover-opacity-100 btn-hapus-satu" data-id="<?= $item['id'] ?>" style="font-size: 1.1rem;">
                    <i class="bi bi-trash3-fill"></i>
                </a>
            </div>
            <?php endforeach; ?>

        </div>

    </div>
</section>

<style>
    .hover-opacity-100:hover {
        opacity: 1 !important;
        transform: scale(1.1);
        transition: all 0.15s ease-in-out;
    }


</style>

<button id="btnBackToTop" title="Kembali ke atas" style="
    display:none;
    position:fixed;
    bottom:30px;
    right:30px;
    z-index:9997;
    width:48px;
    height:48px;
    border-radius:50%;
    background-color:#ff7b00;
    color:#fff;
    border:none;
    font-size:1.3rem;
    box-shadow:0 4px 12px rgba(0,0,0,0.3);
    cursor:pointer;
    transition: all 0.25s ease;
">
    <i class="bi bi-arrow-up"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
<script src="../script/reportadmin.js"></script>
</body>
</html>