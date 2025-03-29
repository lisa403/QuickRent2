<?php
// functions.php

function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Contoh validasi sederhana untuk form pemesanan
function validatePemesanan($pengguna_id, $vehicle_id, $tanggal_sewa, $tanggal_dikembalikan, $total_harga, $status) {
    $errors = [];

    // Validasi pengguna_id (harus angka dan tidak boleh kosong)
    if (empty($pengguna_id)) {
        $errors['pengguna_id'] = "Pengguna ID tidak boleh kosong!";
    } elseif (!ctype_digit($pengguna_id)) {
        $errors['pengguna_id'] = "Pengguna ID harus berupa angka!";
    }

    // Validasi vehicle_id
    if (empty($vehicle_id)) {
        $errors['vehicle_id'] = "Vehicle ID tidak boleh kosong!";
    } elseif (!ctype_digit($vehicle_id)) {
        $errors['vehicle_id'] = "Vehicle ID harus berupa angka!";
    }

    // Validasi tanggal_sewa
    if (empty($tanggal_sewa)) {
        $errors['tanggal_sewa'] = "Tanggal sewa tidak boleh kosong!";
    }

    // Validasi tanggal_dikembalikan
    if (empty($tanggal_dikembalikan)) {
        $errors['tanggal_dikembalikan'] = "Tanggal dikembalikan tidak boleh kosong!";
    }

    // Validasi total_harga
    if (empty($total_harga)) {
        $errors['total_harga'] = "Total harga tidak boleh kosong!";
    } elseif (!ctype_digit($total_harga)) {
        $errors['total_harga'] = "Total harga harus berupa angka!";
    }

    // Validasi status
    if (empty($status)) {
        $errors['status'] = "Status tidak boleh kosong!";
    }

    return $errors;
}

// Fungsi untuk menyimpan data ke tabel pemesanan
function savePemesanan($pengguna_id, $vehicle_id, $tanggal_sewa, $tanggal_dikembalikan, $total_harga, $status) {
    global $conn; // gunakan koneksi dari config.php

  
    $stmt = $conn->prepare("INSERT INTO pemesanan 
        (pengguna_id, vehicle_id, tanggal_sewa, tanggal_dikembalikan, total_harga, status) 
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissis", 
        $pengguna_id, 
        $vehicle_id, 
        $tanggal_sewa, 
        $tanggal_dikembalikan, 
        $total_harga,
        $status
    );

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Tambahkan fungsi validasi untuk form pemesanan
function validateForm($name, $email, $phone) {
    $errors = [];

    if (empty($name)) {
        $errors['name'] = "Nama tidak boleh kosong!";
    }

    if (empty($email)) {
        $errors['email'] = "Email tidak boleh kosong!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format email tidak valid!";
    }

    if (empty($phone)) {
        $errors['phone'] = "Nomor telepon tidak boleh kosong!";
    } elseif (!preg_match("/^[0-9]+$/", $phone)) {
        $errors['phone'] = "Nomor telepon hanya boleh berisi angka!";
    }

    return $errors;
}
?>
