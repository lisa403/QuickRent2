<?php
// Koneksi ke database
include 'db_connect.php';

// Fungsi untuk membersihkan input
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi untuk validasi formulir
function validateForm($name, $email, $phone, $password) {
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

    if (empty($password)) {
        $errors['password'] = "Password tidak boleh kosong!";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password harus terdiri dari minimal 6 karakter!";
    }

    return $errors;
}

// Inisialisasi variabel error
$errors = [];

// Jika tombol submit ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validateForm($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['password']);

    if (empty($errors)) {
        // Menyimpan data ke database
        $name = validateInput($_POST['name']);
        $email = validateInput($_POST['email']);
        $phone = validateInput($_POST['phone']);
        $password = password_hash(validateInput($_POST['password']), PASSWORD_DEFAULT); // Hash password

        $sql = "INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green;'>Formulir berhasil dikirim dan data disimpan!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    }
}
?>