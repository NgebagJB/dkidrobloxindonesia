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

$id               = trim($_POST['id'] ?? '');
$judul            = trim($_POST['judul'] ?? '');
$jenis            = trim($_POST['jenis'] ?? '');
$tanggal_mulai    = trim($_POST['tanggal_mulai'] ?? '');
$waktu_mulai      = trim($_POST['waktu_mulai'] ?? '');
$tanggal_berakhir = trim($_POST['tanggal_berakhir'] ?? '');
$waktu_berakhir   = trim($_POST['waktu_berakhir'] ?? '');
$persyaratan      = trim($_POST['persyaratan'] ?? '');
$catatan          = trim($_POST['catatan'] ?? '');
$link_google_form = trim($_POST['link_google_form'] ?? '');

if (empty($judul) || empty($jenis) || empty($tanggal_mulai) || empty($tanggal_berakhir) || empty($persyaratan) || empty($link_google_form)) {
    $response["message"] = "Mohon isi semua field yang wajib diisi.";
    echo json_encode($response);
    exit;
}

if (empty($id)) {
    // ==== CREATE ====
    $stmt = $conn->prepare("INSERT INTO rekrutmen (judul, jenis, tanggal_mulai, waktu_mulai, tanggal_berakhir, waktu_berakhir, persyaratan, catatan, link_google_form) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $judul, $jenis, $tanggal_mulai, $waktu_mulai, $tanggal_berakhir, $waktu_berakhir, $persyaratan, $catatan, $link_google_form);

    if ($stmt->execute()) {
        $response["status"] = "success";
        $response["message"] = "Rekrutmen berhasil dibuat!";
    } else {
        $response["message"] = "Gagal menyimpan: " . $stmt->error;
    }
    $stmt->close();

} else {
    // ==== UPDATE ====
    $stmt = $conn->prepare("UPDATE rekrutmen SET judul=?, jenis=?, tanggal_mulai=?, waktu_mulai=?, tanggal_berakhir=?, waktu_berakhir=?, persyaratan=?, catatan=?, link_google_form=? WHERE id=?");
    $stmt->bind_param("sssssssssi", $judul, $jenis, $tanggal_mulai, $waktu_mulai, $tanggal_berakhir, $waktu_berakhir, $persyaratan, $catatan, $link_google_form, $id);

    if ($stmt->execute()) {
        $response["status"] = "success";
        $response["message"] = "Rekrutmen berhasil diupdate!";
    } else {
        $response["message"] = "Gagal update: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
echo json_encode($response);