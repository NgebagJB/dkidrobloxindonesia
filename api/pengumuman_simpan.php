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

$id        = trim($_POST['id'] ?? '');
$judul     = trim($_POST['judul'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');

if (empty($judul) || empty($deskripsi)) {
    $response["message"] = "Judul dan Catatan wajib diisi.";
    echo json_encode($response);
    exit;
}

if (empty($id)) {
    // ==== CREATE ====
    $stmt = $conn->prepare("INSERT INTO pengumuman (judul, deskripsi) VALUES (?, ?)");
    $stmt->bind_param("ss", $judul, $deskripsi);

    if ($stmt->execute()) {
        $response["status"] = "success";
        $response["message"] = "Pengumuman berhasil dibuat!";
    } else {
        $response["message"] = "Gagal menyimpan: " . $stmt->error;
    }
    $stmt->close();

} else {
    // ==== UPDATE ====
    $stmt = $conn->prepare("UPDATE pengumuman SET judul=?, deskripsi=? WHERE id=?");
    $stmt->bind_param("ssi", $judul, $deskripsi, $id);

    if ($stmt->execute()) {
        $response["status"] = "success";
        $response["message"] = "Pengumuman berhasil diupdate!";
    } else {
        $response["message"] = "Gagal update: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
echo json_encode($response);