<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

require_once '../includes/koneksi.php';

// Proses penghapusan user
if (isset($_POST['hapus_user']) && isset($_POST['user_id_hapus'])) {
    $user_id_hapus = $_POST['user_id_hapus'];
    $stmt_hapus = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
    $stmt_hapus->bindParam(':user_id', $user_id_hapus);
    if ($stmt_hapus->execute()) {
        $hapus_sukses = true;
    } else {
        $hapus_gagal = true;
    }
}

$stmt = $pdo->query("SELECT user_id, username, email, created_at FROM users ORDER BY user_id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Daftar User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Toggle Sidebar Button (mobile only) -->
    <button id="toggleSidebar" class="sm:hidden fixed top-4 left-4 z-30 bg-gray-800 text-white p-2 rounded-md">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div id="sidebar" class="bg-gray-800 text-white w-60 flex-shrink-0 transform -translate-x-full sm:translate-x-0 transition-transform duration-300 ease-in-out fixed top-0 left-0 h-full z-20">
        <div class="p-4">
            <h1 class="text-xl font-semibold">Admin Panel</h1>
        </div>
        <ul>
            <li class="p-2 hover:bg-gray-700">
                <a href="../dashboard.php" class="block text-sm"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a>
            </li>
            <li class="p-2 hover:bg-gray-700">
                <a href="data_ps.php" class="block text-sm"><i class="fas fa-gamepad mr-2"></i> Data PlayStation</a>
            </li>
            <li class="p-2 bg-gray-700">
                <a href="daftar_user.php" class="block text-sm"><i class="fas fa-users mr-2"></i> Daftar User</a>
            </li>
            <li class="p-2 hover:bg-gray-700">
                <a href="laporan_transaksi.php" class="block text-sm"><i class="fas fa-chart-bar mr-2"></i> Laporan Transaksi</a>
            </li>
            <li class="p-2 hover:bg-gray-700">
                <a href="kelola_booking.php" class="block text-sm"><i class="fas fa-calendar-alt mr-2"></i> Kelola Booking</a>
            </li>
            <li class="p-2 hover:bg-gray-700">
                <a href="../auth/logout.php" class="block text-sm"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
            </li>
        </ul>
    </div>

    <!-- Konten Utama -->
<div class="px-6 py-8 sm:ml-64 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar User</h2>

        <?php if (isset($hapus_sukses)) : ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4">
                <strong class="font-semibold">Sukses!</strong> User berhasil dihapus.
            </div>
        <?php endif; ?>

        <?php if (isset($hapus_gagal)) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
                <strong class="font-semibold">Gagal!</strong> Terjadi kesalahan saat menghapus user.
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto rounded-md">
            <table class="min-w-full bg-white divide-y divide-gray-200 border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal Registrasi</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($users as $user) : ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-800"><?php echo $user['user_id']; ?></td>
                            <td class="px-6 py-4 text-sm text-gray-800"><?php echo htmlspecialchars($user['username']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-800"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-800"><?php echo date('d-m-Y H:i:s', strtotime($user['created_at'])); ?></td>
                            <td class="px-6 py-4 text-sm text-right">
                                <form method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')" class="inline-block">
                                    <input type="hidden" name="user_id_hapus" value="<?php echo $user['user_id']; ?>">
                                    <button type="submit" name="hapus_user" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- Script Sidebar Toggle -->
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>
