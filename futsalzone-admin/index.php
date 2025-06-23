<?php
require_once '../includes/cek_login.php';
include '../includes/koneksi_db.php';
include '../includes/fungsi.php';

// Hitung statistik
$total_lapangan = mysqli_num_rows(getLapangan($koneksi));
$total_reservasi = mysqli_num_rows(getRiwayatReservasi($koneksi));

// Reservasi hari ini
$today = date('Y-m-d');
$query_today = "SELECT COUNT(*) as reservasi_today FROM reservasi WHERE tanggal = '$today'";
$result_today = mysqli_query($koneksi, $query_today);
$reservasi_today = mysqli_fetch_assoc($result_today)['reservasi_today'];

// Reservasi minggu ini
$week_start = date('Y-m-d', strtotime('monday this week'));
$week_end = date('Y-m-d', strtotime('sunday this week'));
$query_week = "SELECT COUNT(*) as reservasi_week FROM reservasi WHERE tanggal BETWEEN '$week_start' AND '$week_end'";
$result_week = mysqli_query($koneksi, $query_week);
$reservasi_week = mysqli_fetch_assoc($result_week)['reservasi_week'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - FutsalZone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-futbol text-2xl text-black-800"></i>
                    <h1 class="text-2xl font-bold text-gray-800">FutsalZone Admin</h1>
                </div>
                <nav class="space-x-4">
                    <a href="riwayat.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        <i class="fas fa-history mr-2"></i>
                        Riwayat
                    </a>
                    <a href="tambah_lapangan.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Lapangan
                    </a>
                    <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">
        <!-- Statistics Cards -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Lapangan</p>
                        <p class="text-3xl font-bold text-blue-600"><?= $total_lapangan ?></p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Reservasi</p>
                        <p class="text-3xl font-bold text-green-600"><?= $total_reservasi ?></p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Reservasi Hari Ini</p>
                        <p class="text-3xl font-bold text-purple-600"><?= $reservasi_today ?></p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-clock text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Reservasi Minggu Ini</p>
                        <p class="text-3xl font-bold text-orange-600"><?= $reservasi_week ?></p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-full">
                        <i class="fas fa-chart-line text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Admin -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Kelola Lapangan -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-plus-circle text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Tambah Lapangan</h3>
                    <p class="text-gray-600 mb-6">Tambahkan lapangan futsal baru ke dalam sistem</p>
                    <a href="tambah_lapangan.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-300 font-semibold">
                        <i class="fas fa-arrow-right mr-2"></i>
                        Kelola Lapangan
                    </a>
                </div>
            </div>

            <!-- Lihat Riwayat -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-history text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Riwayat Reservasi</h3>
                    <p class="text-gray-600 mb-6">Lihat dan kelola semua data reservasi yang masuk</p>
                    <a href="riwayat.php" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition duration-300 font-semibold">
                        <i class="fas fa-arrow-right mr-2"></i>
                        Lihat Riwayat
                    </a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-bar mr-3 text-purple-600"></i>
                    Statistik Cepat
                </h3>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Lapangan Aktif</span>
                        <span class="font-bold text-blue-600"><?= $total_lapangan ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Booking</span>
                        <span class="font-bold text-green-600"><?= $total_reservasi ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Booking Hari Ini</span>
                        <span class="font-bold text-purple-600"><?= $reservasi_today ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Booking Minggu Ini</span>
                        <span class="font-bold text-orange-600"><?= $reservasi_week ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-clock mr-3 text-indigo-600"></i>
                Aktivitas Terbaru
            </h3>

            <?php
            $recent_query = "SELECT r.*, l.nama_lapangan 
                           FROM reservasi r 
                           JOIN lapangan l ON r.id_lapangan = l.id_lapangan 
                           ORDER BY r.id_reservasi DESC 
                           LIMIT 5";
            $recent_result = mysqli_query($koneksi, $recent_query);
            ?>

            <div class="space-y-3">
                <?php if (mysqli_num_rows($recent_result) > 0): ?>
                    <?php while ($recent = mysqli_fetch_assoc($recent_result)): ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="bg-indigo-100 p-2 rounded-full">
                                    <i class="fas fa-calendar text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800"><?= $recent['nama_pemesan'] ?></p>
                                    <p class="text-sm text-gray-600">
                                        <?= $recent['nama_lapangan'] ?> -
                                        <?= formatTanggal($recent['tanggal']) ?>
                                        (<?= formatWaktu($recent['jam_mulai']) ?> - <?= formatWaktu($recent['jam_selesai']) ?>)
                                    </p>
                                </div>
                            </div>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                Terkonfirmasi
                            </span>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-4"></i>
                        <p>Belum ada aktivitas reservasi</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400">&copy; 2025 FutsalZone. Admin Panel.</p>
        </div>
    </footer>
</body>

</html>