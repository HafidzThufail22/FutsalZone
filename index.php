<?php
include 'includes/koneksi_db.php';
include 'includes/fungsi.php';

$lapangan_result = getLapangan($koneksi);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutsalZone - Sistem Reservasi Lapangan Futsal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-50 to-sky-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-futbol text-3xl text-black-800"></i>
                    <h1 class="text-3xl font-bold text-gray-800">FutsalZone</h1>
                </div>
                <nav>
                    <div class="flex space-x-4">
                        <a href="reservasi.php" class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-2 rounded-lg transition duration-300">
                            <i class="fas fa-calendar-plus mr-2"></i>
                            Buat Reservasi
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <!-- Landing Page -->
    <section class="bg-cover bg-center h-96" style="background-image: url('asset/Lapangan.jpg');">
        <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
            <div class="text-center text-white">
                <h2 class="text-4xl font-bold mb-4">Selamat Datang di FutsalZone</h2>
                <p class="text-lg mb-6">Nikmati pengalaman bermain futsal terbaik di FutsalZone!
                    Kami menghadirkan lapangan futsal berstandar FIFA,<br> lengkap dengan fasilitas modern dan super nyaman untuk bermain</p>
                <a href="reservasi.php" class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-lg transition duration-300">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Buat Reservasi Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Daftar Lapangan -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-center mb-8">Lapangan Tersedia</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ($lapangan = mysqli_fetch_assoc($lapangan_result)): ?>
                    <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                        <div class="text-black-900 text-4xl mb-4">
                            <i class="fas fa-futbol"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-3"><?php echo htmlspecialchars($lapangan['nama_lapangan']); ?></h3>
                        <p class="text-gray-600 mb-4">Jenis: <?php echo htmlspecialchars($lapangan['jenis']); ?></p>
                        <a href="reservasi.php?lapangan=<?php echo $lapangan['id_lapangan']; ?>"
                            class="block w-full bg-sky-600 hover:bg-sky-700 text-white text-center py-2 px-4 rounded-lg transition duration-300">
                            <i class="fas fa-calendar-plus mr-2"></i>
                            Reservasi Sekarang
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Panduan Reservasi -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-12">
            <h2 class="text-3xl font-bold text-center mb-8">Cara Reservasi</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-blue-600 text-4xl mb-4">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">1. Pilih Lapangan</h3>
                    <p class="text-gray-600">Pilih lapangan yang sesuai dengan kebutuhan Anda</p>
                </div>
                <div class="text-center">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">2. Pilih Jadwal</h3>
                    <p class="text-gray-600">Tentukan tanggal dan waktu bermain</p>
                </div>
                <div class="text-center">
                    <div class="text-purple-600 text-4xl mb-4">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">3. Konfirmasi</h3>
                    <p class="text-gray-600">Isi data diri dan konfirmasi reservasi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <div class="flex items-center justify-center space-x-3 mb-4">
                <i class="fas fa-futbol text-2xl text-white-400"></i>
                <h3 class="text-2xl font-bold">FutsalZone</h3>
            </div>
            <p class="text-gray-400">&copy; 2025 FutsalZone.</p>
            <div class="mt-4">
                <a href="futsalzone-admin/login.php" class="text-gray-400 hover:text-gray-300 text-sm">
                    <i class="fas fa-lock mr-1"></i>
                    Admin Login
                </a>
            </div>
        </div>
    </footer>
</body>

</html>