<?php

function validateInput($data) {
    $data = trim($data); 
    $data = stripslashes($data); 
    $data = htmlspecialchars($data); 
    return $data;
}

function validateForm($name, $email, $phone) {
    $errors = [];

    if (empty($name)) {
        $errors['name'] = "Nama tidak boleh kosong!";
    } else {
        $name = validateInput($name);
    }

    if (empty($email)) {
        $errors['email'] = "Email tidak boleh kosong!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format email tidak valid!";
    } else {
        $email = validateInput($email);
    }

    if (empty($phone)) {
        $errors['phone'] = "Nomor telepon tidak boleh kosong!";
    } elseif (!preg_match("/^[0-9]+$/", $phone)) {
        $errors['phone'] = "Nomor telepon hanya boleh berisi angka!";
    } else {
        $phone = validateInput($phone);
    }

    return $errors;
}

$errors = [];

// Array kendaraan
$vehicles = [
    [
        'name' => 'Rush GR Sport',
        'image' => 'images/1 White.png',
        'price' => 950000,
        'rating' => 4.5,
        'reviews' => 196
    ],
    [
        'name' => 'Yamaha Fazzio',
        'image' => 'images/faz-pink.png',
        'price' => 120000,
        'rating' => 4.5,
        'reviews' => 131
    ],
    [
        'name' => 'Wuling Air EV',
        'image' => 'images/wulingpink.png',
        'price' => 800000,
        'rating' => 4.5,
        'reviews' => 326
    ],
    [
        'name' => 'Toyota Avanza',
        'image' => 'images/avanza.jpg',
        'price' => 600000,
        'rating' => 4.2,
        'reviews' => 150
    ],
    [
        'name' => 'Honda CR-V',
        'image' => 'images/crv.jpg',
        'price' => 1200000,
        'rating' => 4.8,
        'reviews' => 200
    ]
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $errors = validateForm($_POST['name'], $_POST['email'], $_POST['phone']);

    if (empty($errors)) {
        echo "<p style='color: green;'>Formulir berhasil dikirim!</p>";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rent_now'])) {
    $vehicleName = validateInput($_POST['vehicle_name']);
    $fullName = validateInput($_POST['full_name']);
    $email = validateInput($_POST['email']);
    $phone = validateInput($_POST['phone']);
    $vehicleType = validateInput($_POST['vehicle_type']);
    $vehicleModel = validateInput($_POST['vehicle_model']);
    $rentalDate = validateInput($_POST['rental_date']);
    $returnDate = validateInput($_POST['return_date']);
    $additionalNotes = validateInput($_POST['additional_notes']);

    echo "<p style='color: green;'>Penyewaan berhasil untuk: $vehicleName</p>";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}
// Jika tombol kirim ulasan ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])) {
    $reviewText = validateInput($_POST['review_text']);
    echo "<p style='color: green;'>Ulasan berhasil dikirim: $reviewText</p>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickRent - Rental Mobil & Motor Purwokerto</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-section:target .auth-content {
            animation: fadeInUp 0.5s;
        }
        
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            z-index: 1000;
        }
        .popup button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>Quick<span>Rent</span></h1>
            </div>
            <ul class="nav-links">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="#reviews">Ulasan</a></li>
                <li><a href="#contact">Kontak</a></li>
                <li><a href="#login-section" class="auth-link">Masuk</a></li>
                <li><a href="#register-section" class="auth-link">Daftar</a></li>
            </ul>
        </nav>
    </header>

    <section id="home" class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Temukan solusi transportasi terbaik untuk kebutuhan Anda di Purwokerto dengan harga terjangkau dan pelayanan prima</h1>
            <div class="filter-box">
                <div class="filter-tabs">
                    <button class="tab-button active" onclick="showFilter('mobil')">🚗 Rental Mobil</button>
                    <button class="tab-button" onclick="showFilter('motor')">🛵 Rental Motor</button>
                </div>
                <div id="filter-mobil" class="filter-content active">
                    <!-- Isi filter untuk Rental Mobil -->
                </div>
                
                <div id="filter-motor" class="filter-content">
                    <!-- Isi filter untuk Rental Motor -->
                </div>
                <div class="filter-options">
                    <select><option>🚗 Semua Brand</option></select>
                    <select><option>⚙ Semua Transmisi</option></select>
                    <select><option>📆 2025</option></select>
                    <select><option>🧑‍✈ Dengan pengemudi</option></select>
                </div>
                <button class="search-button">Cari sekarang</button>
            </div>
        </div>
    </section>

    <section class="about-section" id="about">
        <h2>Rental Mobil dan Motor Terbaik di Purwokerto - QuickRent</h2>
        <p>Selamat datang di QuickRent, aplikasi penyewaan mobil dan motor terdepan di Purwokerto yang dirancang untuk memberikan kemudahan dan 
            fleksibilitas dalam memenuhi kebutuhan transportasi Anda. Dengan QuickRent, Anda dapat dengan mudah menemukan dan menyewa berbagai jenis kendaraan, 
            mulai dari mobil keluarga yang nyaman, SUV tangguh, hingga motor lincah untuk mobilitas perkotaan. </p>
        <p>Kami memahami bahwa setiap perjalanan memiliki kebutuhan yang berbeda. Oleh karena itu, QuickRent menawarkan beragam 
            pilihan kendaraan terbaru dengan kondisi prima, yang selalu kami jaga melalui perawatan berkala. Baik Anda membutuhkan kendaraan 
            untuk perjalanan wisata, urusan bisnis, atau sekadar mobilitas sehari-hari, QuickRent hadir dengan solusi yang tepat.</p>
    </section>

    <section id="search" class="search-section">
        <div class="section-title">
            <h2>Kendaraan Populer 🔥</h2>
        </div>
        <center>
        <div class="team-buttons">
            <button onclick="showPopup('popup1')">Lihat Identitas Pembuat 1</button>
            <button onclick="showPopup('popup2')">Lihat Identitas Pembuat 2</button>
            <button onclick="showPopup('popup3')">Lihat Identitas Pembuat 3</button>
            <button onclick="showPopup('popup4')">Lihat Identitas Pembuat 4</button>
        </div>

      
        <div id="popup1" class="popup">
            <p><strong>Nama:</strong> Aqilah Azzahra Khoirunnisa</p>
            <p><strong>NIM:</strong> 2311103129</p>
            <p><strong>Jobs:</strong> Back End</p>
            <button onclick="closePopup('popup1')">Tutup</button>
        </div>

        <div id="popup2" class="popup">
            <p><strong>Nama:</strong> Halimah Ummulizah</p>
            <p><strong>NIM:</strong> 2311103150</p>
            <p><strong>Jobs:</strong> Database & Testing</p>
            <button onclick="closePopup('popup2')">Tutup</button>
        </div>
        
        <div id="popup3" class="popup">
            <p><strong>Nama:</strong> Made Putri Viona</p>
            <p><strong>NIM:</strong> 2311103109</p>
            <p><strong>Jobs:</strong> Front End</p>
            <button onclick="closePopup('popup3')">Tutup</button>
        </div>
        
        <div id="popup4" class="popup">
            <p><strong>Nama:</strong> Timora Lestenia</p>
            <p><strong>NIM:</strong> 2311103040</p>
            <p><strong>Jobs:</strong> Server & Testing</p>
            <button onclick="closePopup('popup4')">Tutup</button>
        </div>
    </section>
    </center>
    
    <div class="vehicle-grid" id="vehicle-list">
        <?php foreach ($vehicles as $vehicle): ?>
            <div class="vehicle-card">
                <img src="<?php echo $vehicle['image']; ?>" alt="<?php echo $vehicle['name']; ?>">
                <div class="vehicle-info">
                    <div class="rating">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <span class="star <?php echo $i < floor($vehicle['rating']) ? 'filled' : 'half-filled'; ?>">★</span>
                        <?php endfor; ?>
                        <span class="review-count">(<?php echo $vehicle['reviews']; ?>)</span>
                    </div>
                    <h3><?php echo $vehicle['name']; ?></h3>
                    <hr>
                    <p class="price">Rp<?php echo number_format($vehicle['price'], 0, ',', '.'); ?> <span class="per-day">/Per Hari</span></p>
                    <form method="post" action="">
                        <input type="hidden" name="vehicle_name" value="<?php echo $vehicle['name']; ?>">
                        <input type="hidden" name="vehicle_type" value="mobil"> 
                        <button type="submit" name="rent_now" class="sewa-sekarang">Sewa Sekarang <span class="arrow">›</span></button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    </section>

    <section class="form-pemesanan">
        <div class="form-container">
            <h2>Formulir Pemesanan 🚗</h2>
            <form method="post" action="">
                <div class="input-group">
                    <label for="full_name">Nama Lengkap</label>
                    <input type="text" name="full_name" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" name="phone" required>
                </div>
                <div class="input-group">
                    <label for="vehicle_type">Jenis Kendaraan</label>
                    <select name="vehicle_type" required>
                        <option value="">Pilih Jenis Kendaraan</option>
                        <option value="mobil">Mobil</option>
                        <option value="motor">Motor</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="vehicle_model">Model Kendaraan</label>
                    <input type="text" name="vehicle_model" required>
                </div>
                <div class="input-group">
                    <label for="rental_date">Tanggal Sewa</label>
                    <input type="date" name="rental_date" required>
                </div>
                <div class="input-group">
                    <label for="return_date">Tanggal Kembali</label>
                    <input type="date" name="return_date" required>
                </div>
                <div class="input-group">
                    <label for="additional_notes">Catatan Tambahan</label>
                    <textarea name="additional_notes" placeholder="Keterangan tambahan (opsional)"></textarea>
                </div>
                <button type="submit" name="submit_rent" class="submit-btn">Sewa Sekarang</button>
            </form>
        </div>
    </section>

<section id="reviews" class="reviews-section">
    <div class="section-title">
        <h2>Testimoni Pelanggan Kami💖</h2>
    </div>
    <div class="reviews-container">
        <div class="review-card">
            <div class="rating">★★★★★</div>
            <p class="review-text">Pelayanan sangat memuaskan, kendaraan bersih dan terawat. Proses pemesanan juga mudah dan cepat.</p>
            <p class="reviewer">Timora L. <span>- Mahasiswa</span></p>
        </div>
        <div class="review-card">
            <div class="rating">★★★★☆</div>
            <p class="review-text">Mobil yang disewakan dalam kondisi prima, harga sewa juga terjangkau. Recommended!</p>
            <p class="reviewer">Dalila N. <span>- Pengusaha</span></p>
        </div>
    </div>
    <form class="review-form" method="post" action="">
        <h3>Berikan Ulasan Anda</h3>
        <div class="rating-input">
            <input type="radio" name="rating" value="5" id="star5"><label for="star5" onclick="setRating(5)">★</label>
            <input type="radio" name="rating" value="4" id="star4"><label for="star4" onclick="setRating(4)">★</label>
            <input type="radio" name="rating" value="3" id="star3"><label for="star3" onclick="setRating(3)">★</label>
            <input type="radio" name="rating" value="2" id="star2"><label for="star2" onclick="setRating(2)">★</label>
            <input type="radio" name="rating" value="1" id="star1"><label for="star1" onclick="setRating(1)">★</label>
        </div>
        <textarea name="review_text" placeholder="Tulis ulasan Anda di sini"></textarea>
        <button type="submit" name="submit_review" class="form-submit">Kirim Ulasan</button>
    </form>
</section>

    <section id="login-section" class="auth-section">
        <div class="auth-container">
            <div class="auth-content">
                <a href="#" class="close-button">&times;</a>
                <h2>Masuk</h2>
                <form class="auth-form" action="popup.php" method="POST">
                    <div class="form-group">
                        <label for="login-email">Email</label>
                        <input type="email" id="login-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" id="login-password" name="password" required>
                    </div>
                    <div class="form-group remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat Saya</label>
                    </div>
                    <button type="submit" class="auth-button">Masuk</button>
                    <p class="forgot-password"><a href="#forgot-section">Lupa password?</a></p>
                    <p class="switch-form">Belum punya akun? <a href="#register-section">Daftar disini</a></p>
                </form>
            </div>
        </div>
    </section>

    <section id="register-section" class="auth-section">
        <div class="auth-container">
            <div class="auth-content">
                <a href="#" class="close-button">&times;</a>
                <h2>Daftar</h2>
                <form class="auth-form" action="#" method="POST">
                    <div class="form-group">
                        <label for="register-name">Nama Lengkap</label>
                        <input type="text" id="register-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="register-email">Email</label>
                        <input type="email" id="register-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="register-phone">No. HP</label>
                        <input type="tel" id="register-phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="register-password">Password</label>
                        <input type="password" id="register-password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="register-confirm-password">Konfirmasi Password</label>
                        <input type="password" id="register-confirm-password" name="confirm_password" required>
                    </div>
                    <div class="form-group terms">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">Saya menyetujui <a href="#">Syarat dan Ketentuan</a></label>
                    </div>
                    <button type ="submit" class="auth-button">Daftar</button>
                    <p class="switch-form">Sudah punya akun? <a href="#login-section">Masuk disini</a></p>
                </form>
            </div>
        </div>
    </section>

    <section id="forgot-section" class="auth-section">
        <div class="auth-container">
            <div class="auth-content">
                <a href="#" class="close-button">&times;</a>
                <h2>Lupa Password</h2>
                <form class="auth-form" action="#" method="POST">
                    <div class="form-group">
                        <label for="forgot-email">Email</label>
                        <input type="email" id="forgot-email" name="email" required>
                    </div>
                    <button type="submit" class="auth-button">Reset Password</button>
                    <p class="switch-form"><a href="#login-section">Kembali ke halaman login</a></p>
                </form>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>QuickRent</h3>
                <p>Kami melayani sewa sesuai dengan opsi kebutuhan Anda yaitu per 12 jam, 24 jam, harian, mingguan, dan bulanan.</p>
                <p>Menyediakan layanan rental mobil dan motor berkualitas dengan pilihan kendaraan terlengkap, harga terjangkau, dan proses pemesanan yang mudah untuk memenuhi kebutuhan transportasi Anda selama di kota ini, kami ahlinya.</p>
            </div>
            <div class="footer-section">
                <h3>Kontak Kami</h3>
                <p>Alamat: Jl. Kauman Lama No.26, Purwokerto Barat, Jawa Tengah</p>
                <p>Telp: 0812-9283-9982</p>
                <p>Email: vionasptrsduasa@quickrent.com</p>
                <h4>Jam Operasional</h4>
                <p>Senin - Minggu: 08.00 - 22.00</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 QuickRent. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function showPopup(id) {
            document.getElementById(id).style.display = "block";
        }
        function closePopup(id) {
            document.getElementById(id).style.display = "none";
        }
        
        function showFilter(type) {
            const contents = document.getElementsByClassName('filter-content');
            for (let i = 0; i < contents.length; i++) {
                contents[i].classList.remove('active');
            }
            
            const buttons = document.getElementsByClassName('tab-button');
            for (let i = 0; i < buttons.length; i++) {
                buttons[i].classList.remove('active');
            }
            
            document.getElementById('filter-' + type).classList.add('active');
            event.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>
