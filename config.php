<?php

$host = 'localhost'; // Server database
$user = 'root'; // Username MySQL
$password = ''; // Password MySQL (kosongkan jika tidak ada password)
$database = 'db_quickrent'; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    echo "Koneksi berhasil";
}

// config.php
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Koneksi berhasil"; // Hanya untuk debugging, bisa dihapus setelah selesai
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
    exit; // Keluar dari script jika koneksi gagal
}
?>
