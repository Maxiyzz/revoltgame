<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

require_once '../includes/koneksi.php';

$mulai_tanggal = $_GET['mulai_tanggal'] ?? date('Y-m-d');
$sampai_tanggal = $_GET['sampai_tanggal'] ?? date('Y-m-d');

$sql = "SELECT rental_id, DATE_FORMAT(tanggal_pemesanan, '%M %Y') AS bulan, status_penyewaan, total_biaya, status_pembayaran FROM rentals";
if (isset($_GET['mulai_tanggal']) && isset($_GET['sampai_tanggal'])) {
    $sql .= " WHERE tanggal_pemesanan >= :mulai AND tanggal_pemesanan <= :sampai";
}
$sql .= " ORDER BY tanggal_pemesanan DESC";

$stmt = $pdo->prepare($sql);
if (isset($_GET['mulai_tanggal']) && isset($_GET['sampai_tanggal'])) {
    $stmt->bindParam(':mulai', $_GET['mulai_tanggal']);
    $stmt->bindParam(':sampai', $_GET['sampai_tanggal']);
}
$stmt->execute();
$laporan_pesanan = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style type="text/css" media="print">
        #sidebar {
            display: none;
        }

        .sm\:ml-64 { /* Kelas untuk main content saat sidebar ada */
            margin-left: 0 !important; /* Override margin saat cetak */
            padding-left: 20px !important; /* Berikan sedikit padding kiri */
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <button id="toggleSidebar" class="sm:hidden fixed top-4 left-4 z-30 bg-gray-800 text-white p-2 rounded-md">
        <i class="fas fa-bars"></i>
    </button>

    <div id="sidebar" class="bg-gray-800 text-white w-60 flex-shrink-0 transform -translate-x-full sm:translate-x-0 transition-transform duration-300 ease-in-out fixed top-0 left-0 h-full z-20">
        <div class="p-4">
            <h1 class="text-xl font-semibold">Admin Panel</h1>
        </div>
        <ul>
            <li class="p-2 <?php if (basename($_SERVER['PHP_SELF']) == 'dashboard.php') echo 'bg-gray-700'; else echo 'hover:bg-gray-700'; ?>">
                <a href="../dashboard.php" class="block text-sm"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a>
            </li>
            <li class="p-2 <?php if (basename($_SERVER['PHP_SELF']) == 'data_ps.php') echo 'hover:bg-gray-700'; else echo 'hover:bg-gray-700'; ?>">
                <a href="data_ps.php" class="block text-sm"><i class="fas fa-gamepad mr-2"></i> Data PlayStation</a>
            </li>
            <li class="p-2 <?php if (basename($_SERVER['PHP_SELF']) == 'daftar_user.php') echo 'hover:bg-gray-700'; else echo 'hover:bg-gray-700'; ?>">
                <a href="daftar_user.php" class="block text-sm"><i class="fas fa-users mr-2"></i> Daftar User</a>
            </li>
            <li class="p-2 <?php if (basename($_SERVER['PHP_SELF']) == 'laporan_transaksi.php') echo 'bg-gray-700'; else echo 'hover:bg-gray-700'; ?>">
                <a href="laporan_transaksi.php" class="block text-sm"><i class="fas fa-chart-bar mr-2"></i> Laporan Transaksi</a>
            </li>
            <li class="p-2 <?php if (basename($_SERVER['PHP_SELF']) == 'kelola_booking.php') echo 'hover:bg-gray-700'; else echo 'hover:bg-gray-700'; ?>">
                <a href="kelola_booking.php" class="block text-sm"><i class="fas fa-calendar-alt mr-2"></i> Kelola Booking</a>
            </li>
            <li class="p-2 hover:bg-gray-700">
                <a href="../auth/logout.php" class="block text-sm"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
            </li>
        </ul>
    </div>

<div class="px-6 py-8 sm:ml-64 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Laporan Transaksi</h2>

            <form method="get" class="mb-4 flex items-center gap-4">
                <div class="flex items-center">
                    <label for="mulai_tanggal" class="block text-gray-700 text-sm font-bold mr-2">Mulai Tanggal:</label>
                    <input type="date" id="mulai_tanggal" name="mulai_tanggal" value="<?php echo htmlspecialchars($mulai_tanggal); ?>" class="shadow appearance-none border rounded w-full sm:w-40 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-sm">
                </div>
                <div class="flex items-center">
                    <label for="sampai_tanggal" class="block text-gray-700 text-sm font-bold mr-2">Sampai Tanggal:</label>
                    <input type="date" id="sampai_tanggal" name="sampai_tanggal" value="<?php echo htmlspecialchars($sampai_tanggal); ?>" class="shadow appearance-none border rounded w-full sm:w-40 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-sm">
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-sm">Cari Data</button>
                </div>
                <div>
                    <a href="laporan_transaksi.php" class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-sm">Refresh</a>
                </div>
            </form>

        <div class="mb-4">
            <p class="text-sm">Berikut ini adalah Pencarian Mulai Tanggal <?php echo date('d F Y', strtotime($mulai_tanggal)); ?> hingga <?php echo date('d F Y', strtotime($sampai_tanggal)); ?>, <a href="#" class="text-blue-500 hover:underline" onclick="window.print(); return false;">Cetak Data Halaman Ini</a></p>
        </div>

<div class="overflow-x-auto rounded-md">
    <table class="min-w-full bg-white divide-y divide-gray-200 border border-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kode Pemesanan</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Bulan</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total Harga</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status Pembayaran</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status Sewa</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if (empty($laporan_pesanan)): ?>
                <tr class="hover:bg-gray-50"><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center" colspan="7">Tidak ada data laporan.</td></tr>
            <?php else: ?>
                <?php $no = 1; foreach ($laporan_pesanan as $laporan): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $no++; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo htmlspecialchars($laporan['rental_id']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo htmlspecialchars($laporan['bulan']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Rp <?php echo number_format($laporan['total_biaya'], 0, ',', '.'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo htmlspecialchars(ucfirst($laporan['status_pembayaran'])); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo htmlspecialchars($laporan['status_penyewaan']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                            <a href="../riwayat_sewa.php?rental_id=<?php echo htmlspecialchars($laporan['rental_id']); ?>" class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs">Lihat</a>
                            <a href="../booking/konfirmasi_booking.php?rental_id=<?php echo htmlspecialchars($laporan['rental_id']); ?>" target="_blank" class="text-green-600 hover:text-green-900 ml-2 font-semibold text-xs">Cetak</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

        <div class="mt-4 flex justify-between items-center text-sm">
            <div class="text-gray-700">
                Showing 1 to <?php echo count($laporan_pesanan); ?> of <?php // Perlu perhitungan total data ?> entries
            </div>
            <div>
                <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded disabled text-xs">Previous</button>
                <button class="bg-blue-300 hover:bg-blue-400 text-blue-800 font-bold py-2 px-4 rounded text-xs">Next</button>
            </div>
        </div>
    </div>
</div>

    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }
    </script>
</body>
</html>