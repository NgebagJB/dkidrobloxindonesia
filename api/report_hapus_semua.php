<?php
require "cek_session.php";
require "koneksi.php";
header('Content-Type: application/json');

$response = ["status" => "error", "message" => "Terjadi kesalahan."];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $response["message"] = "Metode tidak diizinkan.";
    echo json_encode($response);
    exit;
}

if ($conn->query("TRUNCATE TABLE contact_messages")) {
    $response["status"] = "success";
    $response["message"] = "Semua laporan berhasil dihapus!";
} else {
    $response["message"] = "Gagal menghapus semua data: " . $conn->error;
}

$conn->close();
echo json_encode($response);