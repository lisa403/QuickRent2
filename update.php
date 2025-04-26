<?php
require 'config.php';

$message = '';
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID tidak ditemukan.");
}

// Ambil data pemesanan berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM pemesanan WHERE id = ?");
$stmt->execute([$id]);
$pemesanan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pemesanan) {
    die("Data tidak ditemukan.");
}

// Proses update jika form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pengguna_id = $_POST['pengguna_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $tanggal_penyewa = $_POST['tanggal_penyewa'];
    $tanggal_dikembalikan = $_POST['tanggal_dikembalikan'];
    $total_harga = $_POST['total_harga'];
    $status = $_POST['status'];

    $update = $pdo->prepare("UPDATE pemesanan SET 
        pengguna_id = ?, 
        vehicle_id = ?, 
        tanggal_penyewa = ?, 
        tanggal_dikembalikan = ?, 
        total_harga = ?, 
        status = ?
        WHERE id = ?");

    if ($update->execute([$pengguna_id, $vehicle_id, $tanggal_penyewa, $tanggal_dikembalikan, $total_harga, $status, $id])) {
        $message = "Data berhasil diperbarui!";
        // Refresh data dari database
        $stmt->execute([$id]);
        $pemesanan = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $message = "Terjadi kesalahan saat memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Pemesanan</title>
</head>
<body>
    <h1>Edit Pemesanan</h1>
    <?php if ($message): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>ID Pengguna:</label><br>
        <input type="number" name="pengguna_id" value="<?= $pemesanan['pengguna_id'] ?>" required><br>

        <label>ID Kendaraan:</label><br>
        <input type="number" name="vehicle_id" value="<?= $pemesanan['vehicle_id'] ?>" required><br>

        <label>Tanggal Sewa:</label><br>
        <input type="date" name="tanggal_penyewa" value="<?= $pemesanan['tanggal_penyewa'] ?>" required><br>

        <label>Tanggal Kembali:</label><br>
        <input type="date" name="tanggal_dikembalikan" value="<?= $pemesanan['tanggal_dikembalikan'] ?>" required><br>

        <label>Total Harga:</label><br>
        <input type="number" name="total_harga" value="<?= $pemesanan['total_harga'] ?>" required><br>

        <label>Status:</label><br>
        <select name="status" required>
            <option value="pending" <?= $pemesanan['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="confirmed" <?= $pemesanan['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
            <option value="cancelled" <?= $pemesanan['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            <option value="completed" <?= $pemesanan['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
        </select><br><br>

        <button type="submit">Update</button>
    </form>

    <p><a href="index.php">← Kembali ke Daftar Pemesanan</a></p>
</body>
</html>
