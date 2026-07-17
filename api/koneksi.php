<?php
date_default_timezone_set('UTC');

$host = "localhost";
$user = "root";
$pass = "";
$db   = "dkidrobloxindonesia";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$conn->query("SET time_zone = '+00:00'");