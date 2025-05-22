<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'koneksi.php';

// Tentukan halaman aktif untuk styling
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>REVOLT Game - Beranda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleProfileMenu() {
            document.getElementById('profile-dropdown').classList.toggle('hidden');
        }
        function toggleMobileProfileMenu() {
            document.getElementById('mobile-profile-dropdown').classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-100 text-gray-800">

<header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-600">REVOLT Game</h1>

        <button
            class="md:hidden text-gray-700"
            onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
            aria-label="Toggle navigation"
            title="Toggle navigation"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <nav class="hidden md:flex space-x-6 items-center">
            <a href="index.php" class="px-1 border-b-2 <?= $currentPage == 'index.php' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-700 hover:text-blue-600 hover:border-blue-600' ?>">Beranda</a>
            <a href="katalog.php" class="px-1 border-b-2 <?= $currentPage == 'katalog.php' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-700 hover:text-blue-600 hover:border-blue-600' ?>">Katalog</a>
            <a href="tentang.php" class="px-1 border-b-2 <?= $currentPage == 'tentang.php' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-700 hover:text-blue-600 hover:border-blue-600' ?>">Tentang Kami</a>
            <a href="kontak.php" class="px-1 border-b-2 <?= $currentPage == 'kontak.php' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-700 hover:text-blue-600 hover:border-blue-600' ?>">Kontak Kami</a>

            <?php
            if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
                ?>
                <div class="relative">
                    <button onclick="toggleProfileMenu()" class="flex items-center space-x-2">
                        <div class="rounded-full bg-gray-300 w-8 h-8 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>
                        <span class="text-gray-700"><?php echo $_SESSION['username'] ?? 'Admin'; ?></span>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                            <span class="ml-1 bg-violet-500 text-white text-xs font-semibold px-2 py-0.5 rounded">Admin</span>
                        <?php endif; ?>
                    </button>

                    <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl origin-top-right hidden">
                        <div class="py-1">
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                                <a href="dashboard.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <a href="admin/data_ps.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Data Playstation</a>
                                <a href="admin/daftar_user.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Daftar User</a>
                                <a href="admin/laporan_transaksi.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Laporan Transaksi</a>
                                <a href="admin/kelola_booking.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Kelola Booking</a>
                            <?php else : ?>
                                <a href="dashboard_user.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <a href="riwayat_sewa.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Riwayat Sewa</a>
                                <a href="riwayat_pembayaran.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Riwayat Pembayaran</a>    
                            <?php endif; ?>
                            <a href="auth/logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="flex space-x-2">
                    <a href="auth/login.php" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100">Masuk</a>
                    <a href="auth/register.php" class="px-4 py-2 bg-violet-600 text-white rounded hover:bg-violet-700">Daftar</a>
                </div>
                <?php
            }
            ?>
        </nav>

        <div id="mobile-menu" class="md:hidden px-4 pb-4 hidden">
            <nav class="flex flex-col space-y-2">
                <a href="index.php" class="text-gray-700 hover:text-blue-600">Beranda</a>
                <a href="katalog.php" class="text-gray-700 hover:text-blue-600">Katalog</a>
                <a href="tentang.php" class="text-gray-700 hover:text-blue-600">Tentang Kami</a>
                <a href="kontak.php" class="text-gray-700 hover:text-blue-600">Kontak Kami</a>
            </nav>
            <div class="mt-4 flex flex-col space-y-2">
                <?php
                if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
                    ?>
                    <div class="relative">
                        <button onclick="toggleMobileProfileMenu()" class="flex items-center space-x-2">
                            <div class="rounded-full bg-gray-300 w-8 h-8 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                            </div>
                            <span class="text-gray-700"><?php echo $_SESSION['username'] ?? 'Admin'; ?></span>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                                <span class="ml-1 bg-violet-500 text-white text-xs font-semibold px-2 py-0.5 rounded">Admin</span>
                            <?php endif; ?>
                        </button>

                        <div id="mobile-profile-dropdown" class="mt-2 w-48 bg-white rounded-md shadow-xl origin-top-right hidden">
                            <div class="py-1">
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                                    <a href="dashboard.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    <a href="admin/data_ps.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Data Playstation</a>
                                    <a href="admin/daftar_user.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Daftar User</a>
                                    <a href="admin/laporan_transaksi.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Laporan Transaksi</a>
                                    <a href="admin/kelola_booking.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Kelola Booking</a>
                                <?php else : ?>
                                    <a href="dashboard_user.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    <a href="riwayat_sewa.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Riwayat Sewa</a>
                                <?php endif; ?>
                                <a href="auth/logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <a href="auth/login.php" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100">Masuk</a>
                    <a href="auth/register.php" class="px-4 py-2 bg-violet-600 text-white rounded hover:bg-violet-700">Daftar</a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</header>

</body>
</html>