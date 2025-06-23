<?php
include 'includes/koneksi_db.php';
include 'includes/fungsi.php';

$message = '';
$message_type = '';
$selected_lapangan = isset($_GET['lapangan']) ? (int)$_GET['lapangan'] : null;

// Ambil data lapangan
$lapangan_query = $selected_lapangan
    ? "SELECT * FROM lapangan WHERE id_lapangan = $selected_lapangan"
    : "SELECT * FROM lapangan";
$lapangan_result = mysqli_query($koneksi, $lapangan_query);

// Proses form reservasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lapangan = sanitizeInput($_POST['id_lapangan']);
    $nama_pemesan = sanitizeInput($_POST['nama_pemesan']);
    $tanggal = sanitizeInput($_POST['tanggal']);
    $jam_mulai = sanitizeInput($_POST['jam_mulai']);
    $jam_selesai = sanitizeInput($_POST['jam_selesai']);

    // Validasi input
    if (
        empty($id_lapangan) || empty($nama_pemesan) || empty($tanggal) ||
        empty($jam_mulai) || empty($jam_selesai)
    ) {
        $message = 'Semua field harus diisi!';
        $message_type = 'error';
    } elseif (strtotime($jam_mulai) >= strtotime($jam_selesai)) {
        $message = 'Jam selesai harus lebih besar dari jam mulai!';
        $message_type = 'error';
    } elseif (strtotime($tanggal) < strtotime(date('Y-m-d'))) {
        $message = 'Tidak dapat reservasi untuk tanggal yang sudah lewat!';
        $message_type = 'error';
    } else {
        // Cek ketersediaan
        if (cekKetersediaan($koneksi, $id_lapangan, $tanggal, $jam_mulai, $jam_selesai)) {
            // Insert reservasi
            $query = "INSERT INTO reservasi (id_lapangan, nama_pemesan, tanggal, jam_mulai, jam_selesai) 
                     VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($koneksi, $query);
            mysqli_stmt_bind_param($stmt, "issss", $id_lapangan, $nama_pemesan, $tanggal, $jam_mulai, $jam_selesai);

            if (mysqli_stmt_execute($stmt)) {
                $message = 'Reservasi berhasil dibuat!';
                $message_type = 'success';
                // Reset form
                $_POST = array();
            } else {
                $message = 'Gagal membuat reservasi: ' . mysqli_error($koneksi);
                $message_type = 'error';
            }
        } else {
            $message = 'Lapangan tidak tersedia pada waktu yang dipilih!';
            $message_type = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Lapangan - FutsalZone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-50 to-sky-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-futbol text-2xl text-black-800"></i>
                    <h1 class="text-2xl font-bold text-gray-800">FutsalZone</h1>
                </div>
                <nav>
                    <a href="index.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">
        <?php if ($message): ?>
            <div class="mb-6 p-4 rounded-lg <?php echo $message_type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Form Reservasi -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Reservasi</h2>
                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Lapangan</label>
                        <select name="id_lapangan" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
                            <?php while ($lapangan = mysqli_fetch_assoc($lapangan_result)): ?>
                                <option value="<?php echo $lapangan['id_lapangan']; ?>"
                                    <?php echo $selected_lapangan == $lapangan['id_lapangan'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($lapangan['nama_lapangan']); ?> (<?php echo htmlspecialchars($lapangan['jenis']); ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemesan</label>
                        <input type="text" name="nama_pemesan" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500"
                            value="<?php echo isset($_POST['nama_pemesan']) ? htmlspecialchars($_POST['nama_pemesan']) : ''; ?>">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                        <input type="date" name="tanggal" required min="<?php echo date('Y-m-d'); ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500"
                            value="<?php echo isset($_POST['tanggal']) ? htmlspecialchars($_POST['tanggal']) : ''; ?>">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai</label>
                            <input type="time" name="jam_mulai" required min="08:00" max="22:00"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500"
                                value="<?php echo isset($_POST['jam_mulai']) ? htmlspecialchars($_POST['jam_mulai']) : ''; ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jam Selesai</label>
                            <input type="time" name="jam_selesai" required min="09:00" max="23:00"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500"
                                value="<?php echo isset($_POST['jam_selesai']) ? htmlspecialchars($_POST['jam_selesai']) : ''; ?>">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Buat Reservasi
                    </button>
                </form>
            </div>

            <!-- Informasi -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Reservasi</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            Reservasi dapat dilakukan minimal 1 hari sebelum penggunaan
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock text-blue-500 mr-2"></i>
                            Jam operasional: 08:00 - 23:00
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-calendar text-blue-500 mr-2"></i>
                            Durasi minimal reservasi adalah 1 jam
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Ketentuan</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Datang 15 menit sebelum jadwal
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Membawa sepatu futsal
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Menjaga kebersihan lapangan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400">&copy; 2025 FutsalZone. Sistem Reservasi Lapangan Futsal.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Validasi jam operasional
            const jamMulai = document.querySelector('input[name="jam_mulai"]');
            const jamSelesai = document.querySelector('input[name="jam_selesai"]');

            function validateTime() {
                const mulai = jamMulai.value;
                const selesai = jamSelesai.value;

                if (mulai && selesai) {
                    const jamMulaiDate = new Date(`2025-01-01 ${mulai}`);
                    const jamSelesaiDate = new Date(`2025-01-01 ${selesai}`);

                    if (jamMulaiDate >= jamSelesaiDate) {
                        alert('Jam selesai harus lebih besar dari jam mulai!');
                        jamSelesai.value = '';
                    }
                }
            }

            jamMulai.addEventListener('change', validateTime);
            jamSelesai.addEventListener('change', validateTime);
        });
    </script>
</body>

</html>