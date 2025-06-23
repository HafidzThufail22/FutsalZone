<?php
// Fungsi untuk cek ketersediaan lapangan
function cekKetersediaan($koneksi, $id_lapangan, $tanggal, $jam_mulai, $jam_selesai)
{
    $query = "SELECT * FROM reservasi 
              WHERE id_lapangan = '$id_lapangan' 
              AND tanggal = '$tanggal' 
              AND (
                  (jam_mulai <= '$jam_mulai' AND jam_selesai > '$jam_mulai') OR
                  (jam_mulai < '$jam_selesai' AND jam_selesai >= '$jam_selesai') OR
                  (jam_mulai >= '$jam_mulai' AND jam_selesai <= '$jam_selesai')
              )";

    $result = mysqli_query($koneksi, $query);
    return mysqli_num_rows($result) == 0;
}

// Fungsi untuk mendapatkan semua lapangan
function getLapangan($koneksi)
{
    $query = "SELECT * FROM lapangan ORDER BY nama_lapangan";
    return mysqli_query($koneksi, $query);
}

// Fungsi untuk mendapatkan riwayat reservasi
function getRiwayatReservasi($koneksi)
{
    $query = "SELECT r.*, l.nama_lapangan, l.jenis 
              FROM reservasi r 
              JOIN lapangan l ON r.id_lapangan = l.id_lapangan 
              ORDER BY r.tanggal DESC, r.jam_mulai DESC";
    return mysqli_query($koneksi, $query);
}

// Fungsi untuk format tanggal Indonesia
function formatTanggal($tanggal)
{
    $bulan = array(
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );

    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}

// Fungsi untuk format waktu
function formatWaktu($waktu)
{
    return date('H:i', strtotime($waktu));
}

// Fungsi untuk validasi input
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi untuk mendapatkan semua reservasi
function ambilReservasi($koneksi) {
    $query = "SELECT r.*, l.nama_lapangan, l.jenis 
              FROM reservasi r 
              JOIN lapangan l ON r.id_lapangan = l.id_lapangan 
              ORDER BY r.tanggal DESC, r.jam_mulai DESC";
    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        die("Query Error: " . mysqli_error($koneksi));
    }
    $reservasi = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $reservasi[] = $row;
    }
    return $reservasi;
}
