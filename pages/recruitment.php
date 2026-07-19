<?php
require "api/koneksi.php";

$result = $conn->query("SELECT * FROM rekrutmen ORDER BY tanggal_mulai DESC");
$dataRekrutmen = [];
while ($row = $result->fetch_assoc()) {
    $dataRekrutmen[] = $row;
}

function formatTanggalJam($tanggal, $waktu) {
    if (!$tanggal) return '-';
    $parts = explode('-', $tanggal);
    $tgl = $parts[2] . '/' . $parts[1] . '/' . $parts[0];
    if ($waktu) {
        $tgl .= ' ' . substr($waktu, 0, 5) . ' WIB';
    }
    return $tgl;
}
?>

<div class="text-center text-white" style="background-color: #031430; padding-top: 130px; padding-bottom: 120px;">
    <h2 class="fw-semibold m-0" style="font-size: 2.5rem; letter-spacing: 0.5px;">Recruitment</h2>
</div>

<section class="py-5">
    <div class="container">

        <?php if (empty($dataRekrutmen)): ?>
            <div class="bg-white text-dark p-4 p-md-5 text-center" style="border-radius: 20px;">
                Belum ada informasi rekrutmen saat ini.
            </div>
        <?php endif; ?>

        <?php foreach ($dataRekrutmen as $item): ?>
            <div class="bg-white text-dark p-4 p-md-5 mb-4" style="border-radius: 20px;">
                <h3 class="fw-bold mb-3 text-uppercase"
                    style="font-size: 1.35rem; letter-spacing: 0.5px; color: #000000;">
                    <?= htmlspecialchars($item['judul']) ?>
                </h3>

                <div class="lh-lg" style="font-size: 0.95rem; color: #333333;">
                    <div>
                        Tanggal Mulai : <?= formatTanggalJam($item['tanggal_mulai'], $item['waktu_mulai']) ?>
                        || Berakhir : <?= formatTanggalJam($item['tanggal_berakhir'], $item['waktu_berakhir']) ?>
                    </div>
                    <div>
                        Jenis : <?= htmlspecialchars($item['jenis']) ?>
                    </div>
                    <div>
                        Persyaratan :
                        <a href="#"
                           class="text-primary text-decoration-none fw-semibold btn-read-more"
                           data-id="<?= $item['id'] ?>"
                           style="cursor:pointer;">
                            Read More...
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</section>

<div id="modalOverlay" style="
    display:none;
    position:fixed;
    top:0; left:0; right:0; bottom:0;
    background:rgba(0,0,0,0.7);
    z-index:9998;
    justify-content:center;
    align-items:center;
    padding: 20px;
">
    <div style="
        background:#ffffff;
        color:#222;
        max-width:550px;
        width:100%;
        max-height:85vh;
        overflow-y:auto;
        border-radius:20px;
        padding:35px;
        position:relative;
        box-shadow:0 10px 40px rgba(0,0,0,0.4);
    ">
        <button id="closeModal" style="
            position:absolute;
            top:18px; right:18px;
            background:transparent;
            border:none;
            color:#333;
            font-size:1.6rem;
            cursor:pointer;
            line-height:1;
        ">&times;</button>

        <h4 id="modalJudul" class="fw-bold text-uppercase mb-3" style="color:#031430; font-size: 1.2rem;"></h4>

        <div style="font-size: 0.95rem; color: #333;">
            <p class="mb-1"><strong>Jenis :</strong> <span id="modalJenis"></span></p>
            <p class="mb-1"><strong>Tanggal Mulai :</strong> <span id="modalTanggalMulai"></span> WIB</p>
            <p class="mb-3"><strong>Tanggal Berakhir :</strong> <span id="modalTanggalBerakhir"></span> WIB</p>

            <p class="mb-1"><strong>Persyaratan :</strong></p>
            <p id="modalPersyaratan" class="mb-3" style="white-space:pre-line;"></p>

            <div id="modalCatatanWrapper" class="mb-3">
                <p class="mb-1"><strong>Catatan :</strong></p>
                <p id="modalCatatan" style="white-space:pre-line;"></p>
            </div>
        </div>

        <div id="modalLinkWrapper" class="text-start mt-4">
            <a id="modalLinkForm" href="#" target="_blank" class="btn fw-semibold px-4 py-2"
               style="background-color:#ff7b00; color:#fff; border-radius:8px; text-decoration:none;">
                Daftar Sekarang
            </a>
        </div>
    </div>
</div>

<script src="../script/rekrutmenscript.js"></script>
<script>
    const dataRekrutmen = <?= json_encode($dataRekrutmen) ?>;
    initRekrutmenModal(dataRekrutmen);
</script>