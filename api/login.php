<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

header('Content-Type: application/json');
require "koneksi.php";

// ==== KONFIGURASI ====
$RECAPTCHA_SECRET     = "6LeEj1YtAAAAACf9caNW4Enld1HTB3TS1_ytS1ac";
$RECAPTCHA_MIN_SCORE  = 0.5;
$COOLDOWN_SECONDS     = 30;
$MAX_ATTEMPT_PER_HOUR = 5;
$DISCORD_WEBHOOK_URL  = "https://discord.com/api/webhooks/1527509735107199018/V5gE907wuUe0HgNnR7yAzmjug5Wtu68AU60ZQFUEz4LGYrYTd38y5_BpBIPqiWeWRoep";

function getClientIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }
    return $_SERVER['REMOTE_ADDR'];
}

function generateKodeUnik() {
    return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

function kirimKodeUnikDiscord($webhookUrl, $kodeBaru, $oldMessageId, $conn) {
    if (!empty($oldMessageId)) {
        $deleteUrl = $webhookUrl . "/messages/" . $oldMessageId;
        $ch = curl_init($deleteUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_exec($ch);
        curl_close($ch);
    }

    $payload = [
        "embeds" => [[
            "title"       => "Kode Unik",
            "description" => "Seseorang telah login ke website!!\nJangan sebarkan kode ini!!",
            "color"       => 3447003,
            "fields"      => [
                ["name" => "Kode Unik", "value" => "```{$kodeBaru}```", "inline" => false],
            ],
            "footer"    => ["text" => "Berlaku 1x pakai"],
            "timestamp" => date('c'),
        ]]
    ];

    $ch = curl_init($webhookUrl . "?wait=true");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $result = curl_exec($ch);
    curl_close($ch);

    $resultData = json_decode($result, true);
    $newMessageId = $resultData['id'] ?? null;

    if ($newMessageId) {
        $stmt = $conn->prepare("UPDATE admin SET discord_message_id = ? WHERE username = 'dkidrobloxindonesia'");
        $stmt->bind_param("s", $newMessageId);
        $stmt->execute();
        $stmt->close();
    }
}

$response = ["status" => "error", "message" => "Terjadi kesalahan."];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $response["message"] = "Metode tidak diizinkan.";
    echo json_encode($response);
    exit;
}

if (!empty($_POST['website'])) {
    $response["message"] = "Username atau password salah.";
    echo json_encode($response);
    exit;
}

$recaptchaToken = $_POST['recaptcha_token'] ?? '';

if (empty($recaptchaToken)) {
    $response["message"] = "Verifikasi captcha gagal, silakan coba lagi.";
    echo json_encode($response);
    exit;
}

$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$RECAPTCHA_SECRET}&response={$recaptchaToken}");
$captchaResult = json_decode($verify, true);

if (!$captchaResult['success'] || $captchaResult['score'] < $RECAPTCHA_MIN_SCORE) {
    $response["message"] = "Terdeteksi aktivitas mencurigakan. Silakan coba lagi.";
    echo json_encode($response);
    exit;
}

$ip = getClientIP();

$stmtCheck = $conn->prepare("SELECT last_attempt, attempt_count FROM admin_rate_limit WHERE ip_address = ?");
$stmtCheck->bind_param("s", $ip);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($row = $resultCheck->fetch_assoc()) {
    $lastAttemptTime = strtotime($row['last_attempt']);
    $secondsSinceLastAttempt = time() - $lastAttemptTime;

    if ($secondsSinceLastAttempt < $COOLDOWN_SECONDS) {
        $waitTime = $COOLDOWN_SECONDS - $secondsSinceLastAttempt;
        $response["message"] = "Terlalu cepat mencoba login! Tunggu {$waitTime} detik lagi.";
        echo json_encode($response);
        exit;
    }

    if ($secondsSinceLastAttempt < 3600 && $row['attempt_count'] >= $MAX_ATTEMPT_PER_HOUR) {
        $response["message"] = "Terlalu banyak percobaan login gagal. Coba lagi nanti.";
        echo json_encode($response);
        exit;
    }

    $newCount = ($secondsSinceLastAttempt < 3600) ? $row['attempt_count'] + 1 : 1;
    $stmtUpdate = $conn->prepare("UPDATE admin_rate_limit SET last_attempt = NOW(), attempt_count = ? WHERE ip_address = ?");
    $stmtUpdate->bind_param("is", $newCount, $ip);
    $stmtUpdate->execute();
    $stmtUpdate->close();
} else {
    $stmtInsert = $conn->prepare("INSERT INTO admin_rate_limit (ip_address, last_attempt, attempt_count) VALUES (?, NOW(), 1)");
    $stmtInsert->bind_param("s", $ip);
    $stmtInsert->execute();
    $stmtInsert->close();
}
$stmtCheck->close();

$username  = trim($_POST['username'] ?? '');
$password  = trim($_POST['password'] ?? '');
$kode_unik = trim($_POST['kode_unik'] ?? '');

if (empty($username) || empty($password) || empty($kode_unik)) {
    $response["message"] = "Semua field wajib diisi.";
    echo json_encode($response);
    exit;
}

$stmt = $conn->prepare("SELECT id, username, password, kode_unik, discord_message_id FROM admin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

if (!$admin) {
    $response["message"] = "Username atau password salah.";
    echo json_encode($response);
    exit;
}

if (!password_verify($password, $admin['password'])) {
    $response["message"] = "Username atau password salah.";
    echo json_encode($response);
    exit;
}

if ($kode_unik !== $admin['kode_unik']) {
    $response["message"] = "Kode unik salah atau sudah kedaluwarsa.";
    echo json_encode($response);
    exit;
}

$stmtReset = $conn->prepare("DELETE FROM admin_rate_limit WHERE ip_address = ?");
$stmtReset->bind_param("s", $ip);
$stmtReset->execute();
$stmtReset->close();

$kodeBaru = generateKodeUnik();

$stmtUpdate = $conn->prepare("UPDATE admin SET kode_unik = ? WHERE id = ?");
$stmtUpdate->bind_param("si", $kodeBaru, $admin['id']);
$stmtUpdate->execute();
$stmtUpdate->close();

kirimKodeUnikDiscord($DISCORD_WEBHOOK_URL, $kodeBaru, $admin['discord_message_id'], $conn);

$_SESSION['admin_id']       = $admin['id'];
$_SESSION['admin_username'] = $admin['username'];
$_SESSION['login_time']     = time();

$response["status"]   = "success";
$response["message"]  = "Login berhasil!";
$response["redirect"] = "main.php";

$conn->close();
echo json_encode($response);