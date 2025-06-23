<?php
require_once '../includes/koneksi_db.php';

// Generate hash baru untuk password 'admin123'
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

// Update password admin di database
$query = "UPDATE admin SET password = ? WHERE username = 'admin'";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "s", $hash);

if (mysqli_stmt_execute($stmt)) {
    echo "Password berhasil diupdate!<br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";
    echo "Hash baru: " . $hash;
} else {
    echo "Error: " . mysqli_error($koneksi);
}
