<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'quickrent_db';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil Data yang Akan Diupdate
$id = $_GET['id']; 
$query = "SELECT * FROM pemesanan WHERE id = $id";
$result = $conn->query($query);
$data = $result->fetch_assoc();

//Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Validasi sederhana
    $errors = [];
    if (empty($name)) $errors[] = "Nama wajib diisi!";
    if (empty($email)) $errors[] = "Email wajib diisi!";
    if (empty($phone)) $errors[] = "Nomor telepon wajib diisi!";

    // Jika tidak ada error, simpan ke database
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE pemesanan SET name=?, email=?, phone=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $phone, $id);
        
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Data berhasil diupdate!</p>";
            // Update data yang ditampilkan
            $data['name'] = $name;
            $data['email'] = $email;
            $data['phone'] = $phone;
        } else {
            echo "<p style='color: red;'>Gagal update: " . $conn->error . "</p>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
?>

<!-- Form HTML untuk Edit Data -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit Pemesanan</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 20px; }
        input { width: 100%; padding: 8px; margin: 5px 0; }
        button { background: #2C3E50; color: white; border: none; padding: 10px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Edit Data Pemesanan</h1>
    <form method="POST">
        <label>Nama:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($data['name'] ?? '') ?>" required>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>" required>
        
        <label>Nomor Telepon:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($data['phone'] ?? '') ?>" required>
        
        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>