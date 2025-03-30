<?php
// (1) Sertakan koneksi database
require "connect.php";

// (2) Periksa apakah parameter "id" ada di URL
if (isset($_GET['id'])) {
    $id = $_GET["id"];

    // (3) Validasi ID (hanya angka yang diperbolehkan)
    if (!is_numeric($id)) {
        echo "
        <script>
            alert('ID tidak valid!');
            document.location.href = 'list_buku.php';
        </script>
        ";
        exit;
    }

    // (4) Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("DELETE FROM buku WHERE id = ?");
    $stmt->bind_param("i", $id);

    // (5) Eksekusi query
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "
        <script>
            alert('Data berhasil dihapus!');
            document.location.href = 'list_buku.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Gagal menghapus data!');
            document.location.href = 'list_buku.php';
        </script>
        ";
    }

    // (6) Tutup statement
    $stmt->close();
} else {
    // Jika tidak ada ID di URL, redirect ke halaman utama
    header("Location: list_buku.php");
    exit;
}

// (7) Tutup koneksi database
$conn->close();
?>
