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

?>