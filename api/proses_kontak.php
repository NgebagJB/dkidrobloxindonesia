<?php
header('Content-Type: application/json');
session_start();
require "koneksi.php";

$response = ["status" => "error", "message" => "Terjadi kesalahan."];

// ==== KONFIGURASI ====
$RECAPTCHA_SECRET   = "6LeEj1YtAAAAACf9caNW4Enld1HTB3TS1_ytS1ac";
$RECAPTCHA_MIN_SCORE = 0.5;   // makin tinggi makin ketat (0.0 - 1.0)
$COOLDOWN_SECONDS    = 60;    // jeda minimal antar submit per IP (detik)
$MAX_SUBMIT_PER_HOUR = 5;     // maksimal submit per IP per jam
$DISCORD_WEBHOOK_URL  = "https://discord.com/api/webhooks/1527237793095487578/ay0w02V5DHzZ4DJ-s4FTk_Erd45rH8wmLgS_7jFZcB1PZu_ds-q02XyAW3b2eh1P4i9S";

function getClientIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }
    return $_SERVER['REMOTE_ADDR'];
}

function kirimDiscordWebhook($webhookUrl, $nama, $email, $topik, $penjelasan, $ip) {
    $topikMap = [
        'bug'     => ['label' => 'LAPORAN BUG',                     'color' => 15158332], // merah
        'cheat'   => ['label' => 'LAPORAN PEMAIN BERMASALAH',       'color' => 15105570], // orange
        'staff'   => ['label' => 'LAPORAN STAFF DKID BERMASALAH',   'color' => 10181046], // ungu
        'saran'   => ['label' => 'LAPORAN KRITIK & SARAN',          'color' => 3066993],  // hijau
        'banned'  => ['label' => 'LAPORAN AJUKAN BANDING',          'color' => 15158332], // merah
        'lainnya' => ['label' => 'LAPORAN LAINNYA',                 'color' => 9807270],  // abu
    ];

    $topikInfo = $topikMap[$topik] ?? ['label' => strtoupper($topik), 'color' => 9807270];

    $payload = [
        "embeds" => [[
            "title"  => $topikInfo['label'],
            "color"  => $topikInfo['color'],
            "fields" => [
                ["name" => "Nama :",       "value" => $nama ?: "-", "inline" => false],
                ["name" => "Email :",      "value" => $email, "inline" => false],
                ["name" => "Penjelasan :", "value" => mb_substr($penjelasan, 0, 1000), "inline" => false],
            ],
            "footer"    => ["text" => "DKID Roblox Indonesia - Contact Form"],
            "timestamp" => date('c'),
        ]]
    ];

    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    curl_close($ch);
}

function hapusPesanLama($conn) {
    if (mt_rand(1, 20) === 1) {
        $conn->query("DELETE FROM contact_messages WHERE created_at < NOW() - INTERVAL 30 DAY");
    }
}

$response = ["status" => "error", "message" => "Terjadi kesalahan."];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $response["message"] = "Metode tidak diizinkan.";
    echo json_encode($response);
    exit;
}

// ==== 1. HONEYPOT ====
if (!empty($_POST['website'])) {
    $response["status"]  = "success";
    $response["message"] = "Pesan berhasil dikirim, terima kasih!";
    echo json_encode($response);
    exit;
}

hapusPesanLama($conn);

// ==== 2. VALIDASI reCAPTCHA v3 ====
$recaptchaToken = $_POST['recaptcha_token'] ?? '';

if (empty($recaptchaToken)) {
    $response["message"] = "Verifikasi captcha gagal, silakan coba lagi.";
    echo json_encode($response);
    exit;
}

$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$RECAPTCHA_SECRET}&response={$recaptchaToken}");
$captchaResult = json_decode($verify, true);

if (!$captchaResult['success'] || $captchaResult['score'] < $RECAPTCHA_MIN_SCORE) {
    $response["message"] = "Terdeteksi aktivitas mencurigakan (bot). Silakan coba lagi.";
    echo json_encode($response);
    exit;
}

// ==== 3. RATE LIMITING ====
$ip = getClientIP();

$stmtCheck = $conn->prepare("SELECT last_submit, submit_count FROM contact_rate_limit WHERE ip_address = ?");
$stmtCheck->bind_param("s", $ip);
$stmtCheck->execute();
$result = $stmtCheck->get_result();

if ($row = $result->fetch_assoc()) {
    $lastSubmitTime = strtotime($row['last_submit']);
    $secondsSinceLastSubmit = time() - $lastSubmitTime;

    if ($secondsSinceLastSubmit < $COOLDOWN_SECONDS) {
        $waitTime = $COOLDOWN_SECONDS - $secondsSinceLastSubmit;
        $response["message"] = "Terlalu cepat mengirim! Tunggu {$waitTime} detik lagi.";
        echo json_encode($response);
        exit;
    }

    if ($secondsSinceLastSubmit < 3600 && $row['submit_count'] >= $MAX_SUBMIT_PER_HOUR) {
        $response["message"] = "Anda telah mencapai batas maksimal pengiriman. Coba lagi nanti.";
        echo json_encode($response);
        exit;
    }

    $newCount = ($secondsSinceLastSubmit < 3600) ? $row['submit_count'] + 1 : 1;
    $stmtUpdate = $conn->prepare("UPDATE contact_rate_limit SET last_submit = NOW(), submit_count = ? WHERE ip_address = ?");
    $stmtUpdate->bind_param("is", $newCount, $ip);
    $stmtUpdate->execute();
    $stmtUpdate->close();
} else {
    $stmtInsert = $conn->prepare("INSERT INTO contact_rate_limit (ip_address, last_submit, submit_count) VALUES (?, NOW(), 1)");
    $stmtInsert->bind_param("s", $ip);
    $stmtInsert->execute();
    $stmtInsert->close();
}
$stmtCheck->close();

// ==== 4. VALIDASI INPUT ====
$nama       = trim($_POST['nama'] ?? '');
$email      = trim($_POST['email'] ?? '');
$topik      = trim($_POST['topik'] ?? '');
$penjelasan = trim($_POST['penjelasan'] ?? '');

if (empty($email) || empty($topik) || empty($penjelasan)) {
    $response["message"] = "Mohon isi semua field yang wajib diisi.";
    echo json_encode($response);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response["message"] = "Format email tidak valid.";
    echo json_encode($response);
    exit;
}

// ==== 5. SIMPAN KE DATABASE ====
$stmt = $conn->prepare("INSERT INTO contact_messages (nama, email, topik, penjelasan, ip_address) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nama, $email, $topik, $penjelasan, $ip);

if ($stmt->execute()) {
    $response["status"]  = "success";
    $response["message"] = "Pesan berhasil dikirim, terima kasih!";

    // ==== 6. KIRIM NOTIFIKASI KE DISCORD ====
    try {
        kirimDiscordWebhook($DISCORD_WEBHOOK_URL, $nama, $email, $topik, $penjelasan, $ip);
    } catch (Exception $e) {
    }

} else {
    $response["message"] = "Gagal menyimpan data: " . $stmt->error;
}

$stmt->close();
$conn->close();

echo json_encode($response);