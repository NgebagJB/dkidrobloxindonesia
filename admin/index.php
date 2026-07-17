<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: main.php");
    exit;
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
    <title>DKID ROBLOX</title>
</head>

<body>
    <section class="d-flex align-items-center justify-content-center" style="background-color: #031430; min-height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <div class="container" style="max-width: 400px; padding: 20px;">
            <h3 class="text-white text-center fw-bold mb-4" style="letter-spacing: 1px; font-size: 1.4rem;">LOGIN WEBSITE</h3>
            <form id="loginForm" method="POST">

                <div style="position:absolute; left:-9999px; top:-9999px;" aria-hidden="true">
                    <label for="website">Website</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="mb-3 text-start">
                    <label for="username" class="form-label text-white small mb-1" style="opacity: 0.9;">Username</label>
                    <input type="text" class="form-control custom-input px-3" id="username" name="username" required autocomplete="off">
                </div>

                <div class="mb-3 text-start">
                    <label for="password" class="form-label text-white small mb-1" style="opacity: 0.9;">Password</label>
                    <input type="password" class="form-control custom-input px-3" id="password" name="password" required>
                </div>

                <div class="mb-4 text-start">
                    <label for="kode_unik" class="form-label text-white small mb-1" style="opacity: 0.9;">Kode Unik</label>
                    <input type="text" class="form-control custom-input px-3" id="kode_unik" name="kode_unik" required autocomplete="off" maxlength="6" inputmode="numeric">
                </div>

                <div id="loginError" class="text-danger text-center small mb-3" style="display:none;"></div>

                <div class="text-center pt-2">
                    <button type="submit" id="btnLogin" class="btn btn-success">Login</button>
                </div>

                <p style="font-size: 0.7rem; color: #94a3b8; margin-top: 15px; text-align:center;">
                    This site is protected by reCAPTCHA and the Google
                    <a href="https://policies.google.com/privacy" target="_blank" style="color:#94a3b8;">Privacy Policy</a> and
                    <a href="https://policies.google.com/terms" target="_blank" style="color:#94a3b8;">Terms of Service</a> apply.
                </p>
            </form>
        </div>
    </section>

    <style>
        .grecaptcha-badge {
            visibility: hidden;
        }
    </style>

    <script src="https://www.google.com/recaptcha/api.js?render=6LeEj1YtAAAAAKqmxx_kv9hW4abpK5S2CVY4dRVV"></script>
    <script src="../script/loginscript.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>