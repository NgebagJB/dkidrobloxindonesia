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

$id = trim($_POST['id'] ?? '');

if (empty($id)) {
    $response["message"] = "ID tidak valid.";
    echo json_encode($response);
    exit;
}

$stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $response["status"] = "success";
    $response["message"] = "Laporan berhasil dihapus!";
} else {
    $response["message"] = "Gagal menghapus: " . $stmt->error;
}

$stmt->close();
$conn->close();
echo json_encode($response);