<?php
include '../includes/koneksi_db.php';
include '../includes/fungsi.php';

$message = '';
$message_type = '';

// Proses form tambah lapangan
if ($_POST) {
    $nama_lapangan = sanitizeInput($_POST['nama_lapangan']);
    $jenis = sanitizeInput($_POST['jenis']);

    if (empty($nama_lapangan) || empty($jenis)) {
        $message = 'Semua field harus diisi!';
        $message_type = 'error';
    } else {
        // Cek apakah nama lapangan sudah ada
        $check_query = "SELECT * FROM lapangan WHERE nama_lapangan = '$nama_lapangan'";
        $check_result = mysqli_query($koneksi, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $message = 'Nama lapangan sudah ada!';
            $message_type = 'error';
        } else {
            $query = "INSERT INTO lapangan (nama_lapangan, jenis) VALUES ('$nama_lapangan', '$jenis')";

            if (mysqli_query($koneksi, $query)) {
                $message = 'Lapangan berhasil ditambahkan!';
                $message_type = 'success';
            } else {
                $message = 'Gagal menambahkan lapangan: ' . mysqli_error($koneksi);
                $message_type = 'error';
            }
        }
    }
}

// Proses hapus lapangan
if (isset($_GET['hapus'])) {
    $id_lapangan = $_GET['hapus'];

    // Cek apakah lapangan memiliki reservasi
    $check_reservasi = "SELECT * FROM reservasi WHERE id_lapangan = '$id_lapangan'";
    $result_check = mysqli_query($koneksi, $check_reservasi);

    if (mysqli_num_rows($result_check) > 0) {
        $message = 'Tidak dapat menghapus lapangan yang memiliki riwayat reservasi!';
        $message_type = 'error';
    } else {
        $delete_query = "DELETE FROM lapangan WHERE id_lapangan = '$id_lapangan'";
        if (mysqli_query($koneksi, $delete_query)) {
            $message = 'Lapangan berhasil dihapus!';
            $message_type = 'success';
        } else {
            $message = 'Gagal menghapus lapangan!';
            $message_type = 'error';
        }
    }
}

$lapangan_result = getLapangan($koneksi);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Lapangan - FutsalZone Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-plus-circle text-2xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Kelola Lapangan</h1>
                </div>
                <nav class="space-x-2">
                    <a href="./" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    <a href="../" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        <i class="fas fa-home mr-2"></i>
                        Beranda
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">
        <!-- Alert Message -->
        <?php if ($message): ?>
            <div class="mb-6 p-4 rounded-lg <?= $message_type == 'success' ? 'bg-green-100 text-green-700 border-green-500' : 'bg-red-100 text-red-700 border-red-500' ?> border">
                <div class="flex items-center">
                    <i class="fas <?= $message_type == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?> mr-2"></i>
                    <?= $message ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Form Tambah Lapangan -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-plus mr-3 text-blue-600"></i>
                    Tambah Lapangan Baru
                </h2>

                <form method="POST" class="space-y-6">
                    <!-- Nama Lapangan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Nama Lapangan
                        </label>
                        <input type="text" name="nama_lapangan" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Contoh: Lapangan A">
                    </div>

                    <!-- Jenis Lapangan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag mr-2"></i>
                            Jenis Lapangan
                        </label>
                        <select name="jenis" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Futsal Indoor">Futsal Indoor</option>
                            <option value="Futsal Outdoor">Futsal Outdoor</option>
                            <option value="Futsal Indoor VIP">Futsal Indoor VIP</option>
                            <option value="Futsal Outdoor Premium">Futsal Outdoor Premium</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 shadow-lg">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Lapangan
                    </button>
                </form>
            </div>

            <!-- Daftar Lapangan -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-list mr-3 text-green-600"></i>
                    Daftar Lapangan
                </h2>

                <div class="space-y-4">
                    <?php if (mysqli_num_rows($lapangan_result) > 0): ?>
                        <?php while ($lapangan = mysqli_fetch_assoc($lapangan_result)): ?>
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-300">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="font-semibold text-lg text-gray-800 flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                                            <?= $lapangan['nama_lapangan'] ?>
                                        </h3>
                                        <p class="text-gray-600 flex items-center mt-1">
                                            <i class="fas fa-tag mr-2 text-green-600"></i>
                                            <?= $lapangan['jenis'] ?>
                                        </p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            <i class="fas fa-key mr-1"></i>
                                            ID: <?= $lapangan['id_lapangan'] ?>
                                        </p>
                                    </div>
                                    <div class="flex flex-col space-y-2">
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm text-center">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Aktif
                                        </span>
                                        <button onclick="confirmDelete(<?= $lapangan['id_lapangan'] ?>, '<?= $lapangan['nama_lapangan'] ?>')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition duration-300">
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-4"></i>
                            <p>Belum ada lapangan yang terdaftar</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Statistik Lapangan -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-chart-bar mr-3 text-purple-600"></i>
                Statistik Lapangan
            </h3>

            <?php
            $stats_query = "SELECT jenis, COUNT(*) as jumlah FROM lapangan GROUP BY jenis";
            $stats_result = mysqli_query($koneksi, $stats_query);
            ?>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php while ($stat = mysqli_fetch_assoc($stats_result)): ?>
                    <div class="bg-gradient-to-r from-blue-100 to-purple-100 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600"><?= $stat['jenis'] ?></p>
                                <p class="text-2xl font-bold text-blue-600"><?= $stat['jumlah'] ?></p>
                            </div>
                            <i class="fas fa-futbol text-blue-500 text-xl"></i>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400">&copy; 2025 FutsalZone. Admin Panel.</p>
        </div>
    </footer>

    <script>
        function confirmDelete(id, nama) {
            if (confirm('Apakah Anda yakin ingin menghapus lapangan "' + nama + '"?\n\nPerhatian: Lapangan tidak dapat dihapus jika memiliki riwayat reservasi.')) {
                window.location.href = '?hapus=' + id;
            }
        }
    </script>
</body>

</html>