<?php
session_start();

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

require_once '../includes/koneksi_db.php';
require_once '../includes/fungsi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];

    // Debug: Cek input yang diterima
    // echo "Username: " . $username . "<br>";
    // echo "Password: " . $password . "<br>";

    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        $error = "Error database: " . mysqli_error($koneksi);
    } else {
        $admin = mysqli_fetch_assoc($result);
        if ($admin) {
            // Simpan hash yang tersimpan untuk debugging
            $stored_hash = $admin['password'];

            // Cek apakah password sesuai
            $password_match = password_verify($password, $stored_hash);

            if ($password_match) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $admin['username'];
                header('Location: index.php');
                exit;
            } else {
                // Debug info dalam komentar
                // echo "Input password: " . $password . "<br>";
                // echo "Stored hash: " . $stored_hash . "<br>";
                // echo "Password verify result: " . ($password_match ? "true" : "false") . "<br>";
                $error = "Password tidak cocok";
            }
        } else {
            $error = "Username tidak ditemukan";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - FutsalZone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-indigo-950 to-sky-500 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <i class="fas fa-lock text-4xl text-sky-600 mb-4"></i>
                <h1 class="text-2xl font-bold text-gray-800">Login Admin</h1>
                <p class="text-gray-600">Masuk ke panel admin FutsalZone</p>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
                </div>

                <button type="submit"
                    class="w-full bg-sky-600 hover:bg-sky-700 text-white py-2 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login
                </button>
            </form>
            <div class="mt-6 text-center space-y-2">
                <div>
                    <a href="register.php" class="text-sky-600 hover:text-sky-800 text-sm">
                        Belum punya akun? Daftar disini
                    </a>
                </div>
                <div>
                    <a href="../" class="text-gray-600 hover:text-gray-900 text-sm">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>