<?php
require "api/koneksi.php";

$result = $conn->prepare("SELECT id, judul, deskripsi, created_at FROM pengumuman ORDER BY created_at DESC");
$result->execute();
$result->bind_result($id, $judul, $deskripsi, $createdAt);

$dataPengumuman = [];
while ($result->fetch()) {
    $dataPengumuman[] = [
        'id'         => $id,
        'judul'      => $judul,
        'deskripsi'  => $deskripsi,
        'created_at' => $createdAt,
    ];
}
$result->close();

function formatTanggalPengumuman($datetime)
{
    if (!$datetime) return '-';
    $ts = strtotime($datetime);
    $hariMap = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
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
    <link rel="stylesheet" href="../style/style.css">
    <link rel="icon" type="image/png" href="/Images/logo11.png">
    <title>DKID ROBLOX - Announcement</title>
</head>

<body>

    <div class="text-center text-white" style="background-color: #031430; padding-top: 130px; padding-bottom: 120px;">
        <h2 class="fw-semibold m-0" style="font-size: 2.5rem; letter-spacing: 0.5px;">Announcement</h2>
    </div>

    <section class="py-5">
        <div class="container text-white" style="max-width: 800px;">

            <?php if (empty($dataPengumuman)): ?>
                <p class="text-white-50 text-center py-4">Belum ada pengumuman saat ini.</p>
            <?php endif; ?>

            <div class="d-flex flex-column gap-3">
                <?php foreach ($dataPengumuman as $item): ?>
                    <div class="bg-white text-dark p-3 p-md-4" style="border-radius: 10px;">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <h6 class="fw-bold text-uppercase mb-1" style="font-size: 0.95rem; letter-spacing: 0.3px;">
                                <?= htmlspecialchars($item['judul']) ?>
                            </h6>
                            <span class="text-muted flex-shrink-0" style="font-size: 0.75rem; white-space: nowrap;">
                                <?= formatTanggalPengumuman($item['created_at']) ?>
                            </span>
                        </div>
                        <p class="mb-0 text-secondary" style="font-size: 0.9rem; line-height: 1.5; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                            <?= nl2br(htmlspecialchars($item['deskripsi'])) ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</body>

</html>