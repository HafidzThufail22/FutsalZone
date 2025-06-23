<?php
// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'futsalzone';

// Membuat koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($koneksi, "utf8");
