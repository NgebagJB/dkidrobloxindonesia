<?php
require "../api/cek_session.php";
require "../api/koneksi.php";

$resultRekrut = $conn->query("SELECT COUNT(*) AS total FROM rekrutmen");
$totalRekrutmen = $resultRekrut->fetch_assoc()['total'];

$resultReport = $conn->query("SELECT COUNT(*) AS total FROM contact_messages");
$totalReport = $resultReport->fetch_assoc()['total'];

$resultAnnouncement = $conn->query("SELECT COUNT(*) AS total FROM pengumuman");
$totalAnnouncement = $resultAnnouncement->fetch_assoc()['total'];
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
    <title>DKID ROBLOX</title>
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
                    <li class="nav-item px-2">
                        <a class="nav-link text-white" href="pengumuman.php">Announcement</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <section class="d-flex align-items-center justify-content-center flex-column"
        style="background-color: #031430; min-height: 100vh; font-family: system-ui, -apple-system, sans-serif;">
        <h2 class="text-white text-center fw-bold mb-5" style="letter-spacing: 0.5px;">Welcome To DKID ROBLOX Dashboard
        </h2>

        <div class="container" style="max-width: 900px;">
            <div class="row g-4 justify-content-center mb-5">
                <div class="col-md-6 col-sm-12">
                    <div class="card border-0 bg-white p-4 position-relative d-flex flex-row align-items-start"
                        style="border-radius: 20px; min-height: 160px;">
                        <div class="bg-black d-flex align-items-center justify-content-center text-white me-3"
                            style="width: 70px; height: 70px; border-radius: 12px;">
                            <i class="bi bi-folder-symlink" style="font-size: 2rem;"></i>
                        </div>
                        <div class="text-start flex-grow-1">
                            <span class="text-secondary fw-bold text-uppercase d-block"
                                style="font-size: 0.75rem; letter-spacing: 0.5px; opacity: 0.8;">Recruitment</span>
                            <h2 class="fw-bold my-1 text-dark" style="font-size: 2.2rem; line-height: 1;"><?= $totalRekrutmen ?></h2>
                            <small class="text-muted d-block mb-3" style="font-size: 0.75rem;">Rekrutmen yang anda buat</small>
                            <a href="rekrut.php"
                                class="text-decoration-none text-dark fw-semibold small d-inline-flex align-items-center"
                                style="font-size: 0.8rem; opacity: 0.7;">
                                Lihat Data <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="card border-0 bg-white p-4 position-relative d-flex flex-row align-items-start"
                        style="border-radius: 20px; min-height: 160px;">
                        <div class="bg-black d-flex align-items-center justify-content-center text-white me-3"
                            style="width: 70px; height: 70px; border-radius: 12px;">
                            <i class="bi bi-file-earmark-bar-graph" style="font-size: 2rem;"></i>
                        </div>
                        <div class="text-start flex-grow-1">
                            <span class="text-secondary fw-bold text-uppercase d-block"
                                style="font-size: 0.75rem; letter-spacing: 0.5px; opacity: 0.8;">Report</span>
                            <h2 class="fw-bold my-1 text-dark" style="font-size: 2.2rem; line-height: 1;"><?= $totalReport ?></h2>
                            <small class="text-muted d-block mb-3" style="font-size: 0.75rem;">Total Laporan
                                Masuk</small>

                            <a href="report.php"
                                class="text-decoration-none text-dark fw-semibold small d-inline-flex align-items-center"
                                style="font-size: 0.8rem; opacity: 0.7;">
                                Lihat Data <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="card border-0 bg-white p-4 position-relative d-flex flex-row align-items-start"
                        style="border-radius: 20px; min-height: 160px;">
                        <div class="bg-black d-flex align-items-center justify-content-center text-white me-3"
                            style="width: 70px; height: 70px; border-radius: 12px;">
                            <i class="bi bi-file-earmark-bar-graph" style="font-size: 2rem;"></i>
                        </div>
                        <div class="text-start flex-grow-1">
                            <span class="text-secondary fw-bold text-uppercase d-block"
                                style="font-size: 0.75rem; letter-spacing: 0.5px; opacity: 0.8;">Announcement</span>
                            <h2 class="fw-bold my-1 text-dark" style="font-size: 2.2rem; line-height: 1;"><?= $totalAnnouncement ?></h2>
                            <small class="text-muted d-block mb-3" style="font-size: 0.75rem;">Announcement yang anda buat</small>

                            <a href="pengumuman.php"
                                class="text-decoration-none text-dark fw-semibold small d-inline-flex align-items-center"
                                style="font-size: 0.8rem; opacity: 0.7;">
                                Lihat Data <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="../api/logout.php" class="btn btn-danger text-decoration-none">LogOut</a>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>