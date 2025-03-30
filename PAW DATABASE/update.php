<?php
require 'config.php'; // Menghubungkan ke database
require 'functions.php'; // Menghubungkan ke fungsi yang diperlukan

$message = '';
$errors = [];

// Cek apakah ID pengguna ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data pengguna berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        die("User  tidak ditemukan!");
    }
}

// Proses data ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Validasi data
    $errors = validateForm($name, $email, $phone);

    // Jika tidak ada error, simpan data ke database
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $phone, $id);

        if ($stmt->execute()) {
            $message = "<p style='color: green;'>Data berhasil diperbarui!</p>";
        } else {
            $message = "<p style='color: red;'>Gagal memperbarui data!</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User - QuickRent</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>Quick<span>Rent</span></h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="#kami.php">Tentang Kami</a></li>
                <li><a href="#">Ulasan</a></li>
                <li><a href="#">Kontak</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="form-pemesanan">
            <div class="form-container">
                <h2>Update Data Pengguna</h2>
                <?php echo $message; ?>
                <form method="post" action="">
                    <div class="input-group">
                        <label for="name">Nama</label>
                        <div class="input-field">
                            <input type="text" name="name" placeholder="Masukkan Nama Anda" 
                                value="<?php echo isset($user['name']) ? htmlspecialchars($user['name']) : ''; ?>"
                                class="<?php echo isset($errors['name']) ? 'invalid' : ''; ?>">
                        </div>
                        <?php if (isset($errors['name'])) echo "<p class='error'>{$errors['name']}</p>"; ?>
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <div class="input-field">
                            <input type="email" name="email" placeholder="Masukkan Email Anda" 
                                value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>"
                                class="<?php echo isset($errors['email']) ? 'invalid' : ''; ?>">
                        </div>
                        <?php if (isset($errors['email'])) echo "<p class='error'>{$errors['email']}</p>"; ?>
                    </div>
                    <div class="input-group">
                        <label for="phone">Nomor Telepon</label>
                        <div class="input-field">
                            <input type="text" name="phone" placeholder="Masukkan Nomor Telepon" 
                                value="<?php echo isset($user['phone']) ? htmlspecialchars($user['phone']) : ''; ?>"
                                class="<?php echo isset($errors['phone']) ? 'invalid' : ''; ?>">
                        </div>
                        <?php if (isset($errors['phone'])) echo "<p class='error'>{$errors['phone']}</p>"; ?>
                    </div>
                    <button type="submit" name="submit" class="submit-btn">💾 Simpan Perubahan</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>QuickRent</h3>
                <p>Kami melayani sewa sesuai dengan opsi kebutuhan Anda yaitu per 12 jam, 24 jam, harian, mingguan, dan bulanan.</p>
            </div>
            <div class="footer-section">
                <h3>Kontak Kami</h3>
                <p>Alamat: Jl. Kauman Lama No.26, Purwokerto Barat, Jawa Tengah</p>
                <p>Telp: 0812-9283-9982</p>
                <p>Email: vionasptrsduasa@quickrent.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 QuickRent. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
