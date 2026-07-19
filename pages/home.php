<?php
require __DIR__ . '/../api/koneksi.php';

$resultPengumuman = $conn->prepare("SELECT id, judul, deskripsi, created_at FROM pengumuman ORDER BY created_at DESC LIMIT 2");
$resultPengumuman->execute();
$resultPengumuman->bind_result($pId, $pJudul, $pDeskripsi, $pCreatedAt);

$dataPengumuman = [];
while ($resultPengumuman->fetch()) {
    $dataPengumuman[] = [
        'id'         => $pId,
        'judul'      => $pJudul,
        'deskripsi'  => $pDeskripsi,
        'created_at' => $pCreatedAt,
    ];
}
$resultPengumuman->close();

function formatTanggalPengumuman($datetime) {
    if (!$datetime) return '-';
    $ts = strtotime($datetime);
    $hariMap = ['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
    $hari = $hariMap[date('l', $ts)];
    return $hari . ', ' . date('d/m/Y H:i', $ts) . ' WIB';
}
?>

<!-- Hero -->
<section class="position-relative overflow-hidden text-left hero-section" style="min-height: 100vh;">
    <div id="heroCarousel" class="carousel slide carousel-fade position-absolute top-1 start-0 w-100 h-100" data-bs-ride="carousel" data-bs-interval="5000" style="z-index: 0;">
        <div class="carousel-inner h-100">
            <div class="carousel-item active h-100">
                <img src="Images/hero/h1.png" class="d-block w-100 h-100 object-fit-cover" alt="Slide 1">
            </div>

            <div class="carousel-item h-100">
                <img src="Images/hero/h2.png" class="d-block w-100 h-100 object-fit-cover" alt="Slide 2">
            </div>

            <div class="carousel-item h-100">
                <img src="Images/hero/h3.png" class="d-block w-100 h-100 object-fit-cover" alt="Slide 3">
            </div>

            <div class="carousel-item h-100">
                <img src="Images/hero/h4.png" class="d-block w-100 h-100 object-fit-cover" alt="Slide 3">
            </div>

            <div class="carousel-item h-100">
                <img src="Images/hero/h5.png" class="d-block w-100 h-100 object-fit-cover" alt="Slide 3">
            </div>

            <div class="carousel-item h-100">
                <img src="Images/hero/h6.png" class="d-block w-100 h-100 object-fit-cover" alt="Slide 3">
            </div>

            <div class="carousel-item h-100">
                <img src="Images/hero/h7.png" class="d-block w-100 h-100 object-fit-cover" alt="Slide 3">
            </div>

            <div class="carousel-item h-100">
                <img src="Images/hero/h8.png" class="d-block w-100 h-100 object-fit-cover" alt="Slide 3">
            </div>

            <div class="carousel-item h-100">
                <img src="Images/hero/h9.png" class="d-block w-100 h-100 object-fit-cover" alt="Slide 3">
            </div>

            <div class="carousel-item h-100">
                <img src="Images/hero/h10.png" class="d-block w-100 h-100 object-fit-cover" alt="Slide 3">
            </div>
        </div>
    </div>

    <div class="heroconten">
        <div class="position-absolute top-0 start-0 w-100 h-100"
            style="background-color: rgba(0, 0, 0, 0.3); z-index: 1;">
        </div>

        <div class="position-absolute top-0 start-0 w-100 h-100"
            style="background: linear-gradient(to right, rgba(2, 28, 59, 0.95) 0%, rgba(2, 28, 59, 0.5) 30%, rgba(2, 28, 59, 0.1) 60%); z-index: 1;">
        </div>

        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center justify-content-md-start" style="z-index: 2;">
            <div class="subjudul col-11 col-md-6 p-lg-5 text-white text-center text-md-start mx-auto mx-md-5">
                <h1 class="fw-normal display-4 mb-3 text-shadow">WE CREATE <br> YOU PLAY EVERYDAY</h1>

                <div class="bg-white my-4 mx-auto ms-md-0" style="height: 1.5px; width: 30%;"></div>

                <p class="lead fw-normal mb-4">
                    DUNIA KERETA INDONESIA STUDIO is a game studio that carries the concept of railways in Indonesia, officially established since 2022
                </p>
                <a class="btn btn-primary btn-lg px-4" href="https://discord.gg/hfRD2Ej4ru" target="_blank">Join Discord</a>
            </div>

        </div>
    </div>
</section>

<!-- About -->
<section class="py-5 reveal">
    <div class="container py-4">
        <div class="p-4 p-md-5 rounded-3 text-white" style="background-color: #0F2A44; border: 1px solid #010A3F;">
            <div class="row align-items-center g-4">

                <div class="col-lg-5">
                    <h2 class="display-6 fw-bold mb-4">Passion, Imagination<br>Creation</h2>
                    <p class="text-secondary mb-5"
                        style="color: #a0aec0 !important; line-height: 1.6; font-size: 0.95rem;">
                        Welcome to the Official Website of DUNIA KERETA INDONESIA STUDIO. Established on February 18, 2022 under the dedication of NgebagJB, we focus on creating an immersive and enjoyable Indonesian railway world. We highly appreciate every suggestion and criticism from you to create a much better playing experience
                    </p>

                    <div class="row g-3 text-center text-lg-start">
                        <div class="col-4">
                            <h4 class="fw-bold mb-1">6M+</h4>
                            <small class="text-secondary" style="font-size: 0.8rem;">Visitors</small>
                        </div>
                        <div class="col-4">
                            <h4 class="fw-bold mb-1">6K+</h4>
                            <small class="text-secondary" style="font-size: 0.8rem;">Favorites</small>
                        </div>
                        <div class="col-4">
                            <h4 class="fw-bold mb-1">2.5K+</h4>
                            <small class="text-secondary" style="font-size: 0.8rem;">Likes</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="overflow-hidden rounded-4 shadow-lg">
                        <img src="Images/other/About.png" alt="" class="img-fluid w-100 h-100 object-fit-cover"
                            style="min-height: 350px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Announcement -->
<section class="py-5 reveal" id="announcement">
    <div class="container py-4">
        <div class="p-4 p-md-5 rounded-3 text-white text-center">

            <h2 class="fw-bold mb-2" style="font-size: 2.5rem;">Announcement</h2>
            <p class="text-white-50 mb-2" style="font-size: 1rem;">Our official announcement</p>
            <div class="mx-auto mb-5" style="width: 60px; height: 3px; background-color: #ff7b00; border-radius: 2px;"></div>

            <?php if (empty($dataPengumuman)): ?>
                <p class="text-white-50 py-4">Belum ada pengumuman saat ini.</p>
            <?php endif; ?>

            <div class="d-flex flex-column gap-3 text-start mb-4">
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

            <a href="announcement" class="text-decoration-none fw-bold" style="color: #ff7b00; font-size: 1.1rem;">
                Read More &gt;&gt;&gt;
            </a>

        </div>
    </div>
</section>

<!-- Project -->
<section class="py-5 reveal" id="project">
    <div class="container text-center text-white py-4">
        <h2 class="fw-bold display-6 mb-1">DKID Studio <span style="color: #ff7b00;">Projects</span></h2>
        <p class="text-secondary mb-4" style="color: #b0c4de !important;">Games we create</p>

        <div class="bg-white mx-auto mb-5" style="height: 1.5px; width: 80px; opacity: 0.5;"></div>

        <div class="project-carousel-wrapper" id="projectWrapper">

            <button type="button" class="project-arrow project-arrow-left" aria-label="Previous">
                <i class="bi bi-arrow-left"></i>
            </button>

            <div class="project-track" id="projectTrack">
                <div class="project-slide">
                    <div class="card h-100 border-0 text-white p-4" style="background-color: #0c1a30; border-radius: 15px;">
                        <img src="Images/other/NewEra.png" class="card-img-top rounded-3 mb-4" alt="DKID New Era">
                        <div class="card-body p-0">
                            <h4 class="card-title fw-bold mb-2">DKID New Era</h4>
                            <p class="card-text text-secondary mb-4" style="font-size: 0.9rem; line-height: 1.5; color: #a0aec0 !important;">
                                DKID or Dunia Kereta Indonesia is a train simulation game themed around Indonesia. With a wide variety of trains, you can operate and play together with friends. An attractive game appearance enhances your playing experience
                            </p>
                            <a href="https://www.roblox.com/id/games/15100402341" target="_blank" class="btn btn-outline-light rounded-pill px-5 btn-sm" style="opacity: 0.9;">Play</a>
                        </div>
                    </div>
                </div>

                <div class="project-slide">
                    <div class="card h-100 border-0 text-white p-4" style="background-color: #0c1a30; border-radius: 15px;">
                        <img src="Images/other/Nextgen.png" class="card-img-top rounded-3 mb-4" alt="DKID NEXTGEN">
                        <div class="card-body p-0">
                            <h4 class="card-title fw-bold mb-2">DKID NEXTGEN</h4>
                            <p class="card-text text-secondary mb-4" style="font-size: 0.9rem; line-height: 1.5; color: #a0aec0 !important;">
                                This game focuses on simulating travel by Indonesian trains, offering a realistic virtual experience just like the real thing
                            </p>
                            <a href="https://nextgen.duniakeretaindonesia.com/" target="_blank" class="btn btn-outline-light rounded-pill px-5 btn-sm" style="opacity: 0.9;">View Schedule</a>
                        </div>
                    </div>
                </div>

                <div class="project-slide">
                    <div class="card h-100 border-0 text-white p-4" style="background-color: #0c1a30; border-radius: 15px;">
                        <img src="Images/other/PjlSim.png" class="card-img-top rounded-3 mb-4" alt="PJL Simulator Indonesia">
                        <div class="card-body p-0">
                            <h4 class="card-title fw-bold mb-2">PJL Simulator Indonesia</h4>
                            <p class="card-text text-secondary mb-4" style="font-size: 0.9rem; line-height: 1.5; color: #a0aec0 !important;">
                                This game is intended for those who love challenges. In this game, you act as a Level Crossing Officer (PJL), and by all means, you must stop vehicles before the train passes
                            </p>
                            <a href="https://www.roblox.com/id/games/15115781158" target="_blank" class="btn btn-outline-light rounded-pill px-5 btn-sm" style="opacity: 0.9;">Play</a>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="project-arrow project-arrow-right" aria-label="Next">
                <i class="bi bi-arrow-right"></i>
            </button>

        </div>
    </div>
</section>

<!-- Gamepass -->
<section class="py-5 reveal" id="Gamepass">
    <div class="container text-center text-white py-4">
        <h2 class="fw-bold display-6 mb-1">Game<span style="color: #ff7b00;">Pass</span></h2>
        <p class="text-secondary mb-4" style="color: #b0c4de !important;">Choose a GamePass for your favorite game</p>

        <div class="bg-white mx-auto mb-5" style="height: 1.5px; width: 80px; opacity: 0.5;"></div>

        <div class="gamepass-carousel-wrapper" id="gamepassWrapper">

            <button type="button" class="gamepass-arrow gamepass-arrow-left" aria-label="Previous">
                <i class="bi bi-arrow-left"></i>
            </button>

            <div class="gamepass-track" id="gamepassTrack">

                <div class="gamepass-slide">
                    <div class="card h-100 border-0 overflow-hidden position-relative p-4 d-flex flex-column justify-content-between text-center"
                        style="border-radius: 20px; min-height: 380px;">

                        <div class="position-absolute top-0 start-50 translate-middle-x"
                            style="width: 50px; height: 26px; background-color: #031430; border-radius: 0 0 50px 50px; z-index: 4;"></div>

                        <img src="Images/other/bg.png" alt=""
                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="z-index: 1;">

                        <div class="position-absolute top-0 start-0 w-100 h-100"
                            style="background-color: rgba(3, 20, 48, 0.75); z-index: 2;"></div>

                        <div class="d-flex flex-column align-items-center justify-content-center flex-grow-1 py-4 position-relative" style="z-index: 3;">
                            <div style="height: 60px;" class="d-flex align-items-center mb-4">
                                <img src="Images/other/DKIDLOGO.png" alt="DKID" class="img-fluid" style="max-height: 100px; object-fit: contain;">
                            </div>
                            <p class="card-text text-white px-2 m-0" style="font-size: 0.9rem; line-height: 1.6;">
                                Offering GamePasses that can be used to unlock items In-Game
                            </p>
                        </div>

                        <div class="w-100 px-2 pb-2 position-relative" style="z-index: 3;">
                            <a href="https://www.roblox.com/id/games/15100402341/Dunia-Kereta-Indonesia-New-Era#!/store"
                                target="_blank" class="btn btn-light w-100 py-2 fw-semibold" style="border-radius: 8px; font-size: 0.9rem; color: #031430;">View GamePass</a>
                        </div>
                    </div>
                </div>

                <div class="gamepass-slide">
                    <div class="card h-100 border-0 overflow-hidden position-relative p-4 d-flex flex-column justify-content-between text-center"
                        style="border-radius: 20px; min-height: 380px;">

                        <div class="position-absolute top-0 start-50 translate-middle-x"
                            style="width: 50px; height: 26px; background-color: #031430; border-radius: 0 0 50px 50px; z-index: 4;"></div>

                        <img src="Images/other/bg.png" alt=""
                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="z-index: 1;">

                        <div class="position-absolute top-0 start-0 w-100 h-100"
                            style="background-color: rgba(3, 20, 48, 0.75); z-index: 2;"></div>

                        <div class="d-flex flex-column align-items-center justify-content-center flex-grow-1 py-4 position-relative" style="z-index: 3;">
                            <div style="height: 60px;" class="d-flex align-items-center mb-4">
                                <img src="Images/other/NEXTGENLOGO.png" alt="DKID NEXTGEN" class="img-fluid" style="max-height: 100px; object-fit: contain;">
                            </div>
                            <p class="card-text text-white px-2 m-0" style="font-size: 0.9rem; line-height: 1.6;">
                                Offering GamePasses/Tickets that can be used to board the train class you have purchased when the Server is open
                            </p>
                        </div>

                        <div class="w-100 px-2 pb-2 position-relative" style="z-index: 3;">
                            <a href="https://www.roblox.com/id/communities/33701671/DKID-DKID-NEXTGEN#!/store"
                                target="_blank" class="btn btn-light w-100 py-2 fw-semibold" style="border-radius: 8px; font-size: 0.9rem; color: #031430;">View Ticket GamePass</a>
                        </div>
                    </div>
                </div>

                <div class="gamepass-slide">
                    <div class="card h-100 border-0 overflow-hidden position-relative p-4 d-flex flex-column justify-content-between text-center"
                        style="border-radius: 20px; min-height: 380px;">

                        <div class="position-absolute top-0 start-50 translate-middle-x"
                            style="width: 50px; height: 26px; background-color: #031430; border-radius: 0 0 50px 50px; z-index: 4;"></div>

                        <img src="Images/other/bg.png" alt=""
                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="z-index: 1;">

                        <div class="position-absolute top-0 start-0 w-100 h-100"
                            style="background-color: rgba(3, 20, 48, 0.75); z-index: 2;"></div>

                        <div class="d-flex flex-column align-items-center justify-content-center flex-grow-1 py-4 position-relative" style="z-index: 3;">
                            <div style="height: 60px;" class="d-flex align-items-center mb-4">
                                <h4 class="fw-bold m-0 text-white" style="font-size: 1.1rem; letter-spacing: 0.5px;">PJL SIMULATOR INDONESIA</h4>
                            </div>
                            <p class="card-text text-white px-2 m-0" style="font-size: 0.9rem; line-height: 1.6;">
                                Offering GamePasses that can be used to unlock items In-Game
                            </p>
                        </div>

                        <div class="w-100 px-2 pb-2 position-relative" style="z-index: 3;">
                            <a href="https://www.roblox.com/id/games/15115781158/PJL-Simulator-Indonesia#!/store"
                                target="_blank" class="btn btn-light w-100 py-2 fw-semibold" style="border-radius: 8px; font-size: 0.9rem; color: #031430;">View GamePass</a>
                        </div>
                    </div>
                </div>

            </div>

            <button type="button" class="gamepass-arrow gamepass-arrow-right" aria-label="Next">
                <i class="bi bi-arrow-right"></i>
            </button>

        </div>
    </div>
</section>

<!-- Laporan -->
<section class="py-5 reveal">
    <div class="container text-center text-white py-4">
        <h2 class="fw-bold display-6 mb-1">Contact <span style="color: #ff7b00;">Me</span></h2>
        <p class="text-secondary mb-3" style="color: #b0c4de !important; font-size: 0.95rem;">
            Contact us, provide suggestions, criticism, or report to us
        </p>

        <div class="bg-white mx-auto mb-5" style="height: 1px; width: 120px; opacity: 0.3;"></div>

        <div class="row align-items-center g-4 text-start">
            <div class="col-lg-6">
                <div class="rounded-4 overflow-hidden" style="max-height: 350px;">
                    <img src="Images/other/jekip.png" alt="DKID Studio Team"
                        class="img-fluid w-100 h-100 object-fit-cover"
                        style="min-height: 200px; max-height: 380px;">
                </div>
            </div>

            <div class="col-lg-6 ps-lg-4">
                <h4 class="text-white mb-4" style="line-height: 1.7 !important;">
                    We are committed to creating a healthy and supportive gaming environment. Support us by providing criticism, suggestions, and reporting any bugs or problematic players. Every feedback and report from you means a lot to the development of this game
                </h4>
                <a href="contact" class="btn btn-outline-light px-4 py-2"
                    style="border-radius: 8px; font-size: 1.2rem; border-color: rgba(255,255,255,0.4);">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section class="py-5 reveal">
    <div class="container text-center text-white py-4">
        <h2 class="fw-bold display-6 mb-1">The <span style="color: #ff7b00;">Team</span></h2>
        <p class="text-secondary mb-4" style="color: #b0c4de !important;">You Are Our Priority</p>
        <div class="bg-white mx-auto mb-3" style="height: 1px; width: 120px; opacity: 0.3;"></div>

        <div class="p-4 p-md-5 rounded-4 text-start overflow-hidden">
            <div class="row align-items-center g-4">
                <div class="col-lg-5 ps-md-4 py-3">
                    <h4 class="fw-normal lh-base mb-4 fs-2" style="max-width: 90%;">
                        Behind the comfort you feel, there are great hands working tirelessly
                    </h4>
                    <a href="team" class="btn btn-outline-light px-4 py-2"
                        style="border-radius: 8px; font-size: 1.2rem; border-color: rgba(255,255,255,0.4);">
                        View Our Team
                    </a>
                </div>

                <div class="col-lg-6">
                    <div class="rounded-4 overflow-hidden" style="max-height: 350px;">
                        <img src="Images/other/Team.png" alt="DKID Studio Team"
                            class="img-fluid w-100 h-100 object-fit-cover"
                            style="min-height: 200px; max-height: 380px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Discord Join -->
<section class="reveal" style="margin-bottom: 5rem;">
    <div class="container-fluid">
        <div class="position-relative overflow-hidden p-4 p-md-5 rounded-4 text-white"
            style="background-color: #5865F2; min-height: 180px;">

            <img src="Images/other/DC.png" alt=""
                class="position-absolute top-0 end-0 h-100 object-fit-cover d-none d-md-block"
                style="width: 45%; z-index: 1; pointer-events: none; opacity: 0.9;">

            <div class="position-absolute top-0 start-0 w-100 h-100 d-none d-md-block"
                style="background: linear-gradient(to right, #5865F2 50%, rgba(88, 101, 242, 0) 100%); z-index: 2;">
            </div>

            <div class="row align-items-center position-relative" style="z-index: 3;">
                <div class="col-md-8 text-start">
                    <h4 class="fw-bold mb-1 text-uppercase" style="letter-spacing: 0.5px; font-size: 1.25rem;">
                        JOIN DISCORD
                    </h4>
                    <p class="mb-4 text-white-50" style="font-size: 0.95rem;">
                        To see more complete information
                    </p>
                    <a href="https://discord.gg/hfRD2Ej4ru" target="_blank"
                        class="btn btn-light fw-semibold px-4 py-2"
                        style="border-radius: 8px; font-size: 0.9rem; color: #5865F2;">
                        Join Discord
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>