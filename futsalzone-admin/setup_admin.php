<?php
require_once '../includes/koneksi_db.php';

// Buat tabel admin jika belum ada
$create_table = "CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

mysqli_query($koneksi, $create_table);

// Cek apakah sudah ada admin
$check_admin = "SELECT * FROM admin WHERE username = 'admin'";
$result = mysqli_query($koneksi, $check_admin);

if (mysqli_num_rows($result) == 0) {
    // Buat admin default jika belum ada
    $username = 'admin';
    $password = 'admin123';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert_admin = "INSERT INTO admin (username, password) VALUES ('$username', '$hashed_password')";
    if (mysqli_query($koneksi, $insert_admin)) {
        echo "Admin default berhasil dibuat!<br>";
        echo "Username: admin<br>";
        echo "Password: admin123";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "Admin sudah ada dalam database.";
}
