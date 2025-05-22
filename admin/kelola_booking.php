<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

require_once '../includes/koneksi.php';

// Proses pembatalan booking
if (isset($_POST['batalkan_booking']) && isset($_POST['rental_id_batal'])) {
    $rental_id_batal = $_POST['rental_id_batal'];
    $stmt_batal = $pdo->prepare("UPDATE rentals SET status_penyewaan = 'dibatalkan' WHERE rental_id = :rental_id");
    $stmt_batal->bindParam(':rental_id', $rental_id_batal);
    if ($stmt_batal->execute()) {
        $batal_sukses = true;
    } else {
        $batal_gagal = true;
    }
}

// Proses konfirmasi booking
if (isset($_POST['konfirmasi_booking']) && isset($_POST['rental_id_konfirmasi'])) {
    $rental_id_konfirmasi = $_POST['rental_id_konfirmasi'];

    $stmt_get_rental = $pdo->prepare("SELECT ps_id FROM rentals WHERE rental_id = :rental_id");
    $stmt_get_rental->bindParam(':rental_id', $rental_id_konfirmasi);
    $stmt_get_rental->execute();
    $rental = $stmt_get_rental->fetch(PDO::FETCH_ASSOC);

    if ($rental && isset($rental['ps_id'])) {
        $ps_id = $rental['ps_id'];

        $pdo->beginTransaction();
        try {
            $stmt_konfirmasi = $pdo->prepare("UPDATE rentals SET status_penyewaan = 'disewakan' WHERE rental_id = :rental_id");
            $stmt_konfirmasi->bindParam(':rental_id', $rental_id_konfirmasi);
            $stmt_konfirmasi->execute();

            $stmt_kurangi_stok = $pdo->prepare("UPDATE playstations SET stok = stok - 1 WHERE ps_id = :ps_id AND stok > 0");
            $stmt_kurangi_stok->bindParam(':ps_id', $ps_id);
            $stmt_kurangi_stok->execute();

            $pdo->commit();
            $konfirmasi_sukses = true;
        } catch (Exception $e) {
            $pdo->rollBack();
            $konfirmasi_gagal = true;
        }
    } else {
        $konfirmasi_gagal = true;
    }
}

/// Proses klaim pengembalian dan update status pembayaran
if (isset($_POST['klaim_booking']) && isset($_POST['rental_id_klaim'])) {
    $rental_id_klaim = $_POST['rental_id_klaim'];

    $stmt_get_rental = $pdo->prepare("SELECT ps_id FROM rentals WHERE rental_id = :rental_id");
    $stmt_get_rental->bindParam(':rental_id', $rental_id_klaim);
    $stmt_get_rental->execute();
    $rental = $stmt_get_rental->fetch(PDO::FETCH_ASSOC);

    if ($rental && isset($rental['ps_id'])) {
        $ps_id = $rental['ps_id'];

        $pdo->beginTransaction();
        try {
            $stmt_klaim_sewa = $pdo->prepare("UPDATE rentals SET status_penyewaan = 'selesai' WHERE rental_id = :rental_id");
            $stmt_klaim_sewa->bindParam(':rental_id', $rental_id_klaim);
            $stmt_klaim_sewa->execute();

            $stmt_tambah_stok = $pdo->prepare("UPDATE playstations SET stok = stok + 1 WHERE ps_id = :ps_id");
            $stmt_tambah_stok->bindParam(':ps_id', $ps_id);
            $stmt_tambah_stok->execute();

            // Update status pembayaran menjadi 'sukses'
            $stmt_klaim_sewa = $pdo->prepare("UPDATE rentals SET status_pembayaran = 'Sukses' WHERE rental_id = :rental_id");
            $stmt_klaim_sewa->bindParam(':rental_id', $rental_id_klaim);
            $stmt_klaim_sewa->execute();

            $pdo->commit();
            $klaim_sukses = true;
        } catch (Exception $e) {
            $pdo->rollBack();
            $klaim_gagal = true;
        }
    } else {
        $klaim_gagal = true;
    }
}

// Ambil data booking yang menunggu konfirmasi
$stmt_pending = $pdo->prepare("
    SELECT r.rental_id, u.username, p.nama AS nama_ps, r.tanggal_mulai, r.tanggal_selesai, r.durasi_sewa, r.status_pembayaran
    FROM rentals r
    JOIN users u ON r.user_id = u.user_id
    JOIN playstations p ON r.ps_id = p.ps_id
    WHERE r.status_penyewaan = 'menunggu konfirmasi'
    ORDER BY r.tanggal_mulai ASC
");
$stmt_pending->execute();
$pending_bookings = $stmt_pending->fetchAll(PDO::FETCH_ASSOC);

// Ambil data booking yang sedang disewakan
$stmt_disewakan = $pdo->prepare("
    SELECT r.rental_id, u.username, p.nama AS nama_ps, r.tanggal_mulai, r.tanggal_selesai, r.durasi_sewa, r.status_pembayaran
    FROM rentals r
    JOIN users u ON r.user_id = u.user_id
    JOIN playstations p ON r.ps_id = p.ps_id
    WHERE r.status_penyewaan = 'disewakan' AND r.tanggal_selesai >= DATE_SUB(NOW(), INTERVAL 1 DAY)
    ORDER BY r.tanggal_mulai ASC
");
$stmt_disewakan->execute();
$disewakan_bookings = $stmt_disewakan->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Kelola Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">

    <button id="toggleSidebar" class="sm:hidden fixed top-4 left-4 z-30 bg-gray-800 text-white p-2 rounded-md">
        <i class="fas fa-bars"></i>
    </button>

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
            <li class="p-2 hover:bg-gray-700">
                <a href="daftar_user.php" class="block text-sm"><i class="fas fa-users mr-2"></i> Daftar User</a>
            </li>
            <li class="p-2 hover:bg-gray-700">
                <a href="laporan_transaksi.php" class="block text-sm"><i class="fas fa-chart-bar mr-2"></i> Laporan Transaksi</a>
            </li>
            <li class="p-2 bg-gray-700">
                <a href="kelola_booking.php" class="block text-sm"><i class="fas fa-calendar-alt mr-2"></i> Kelola Booking</a>
            </li>
            <li class="p-2 hover:bg-gray-700">
                <a href="../auth/logout.php" class="block text-sm"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
            </li>
        </ul>
    </div>

<div class="px-6 py-8 sm:ml-64 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Kelola Booking</h2>

        <?php if (isset($batal_sukses)) : ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">Booking berhasil dibatalkan.</div>
        <?php endif; ?>

        <?php if (isset($batal_gagal)) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Gagal membatalkan booking.</div>
        <?php endif; ?>

        <?php if (isset($konfirmasi_sukses)) : ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">Booking dikonfirmasi dan stok dikurangi.</div>
        <?php endif; ?>

        <?php if (isset($konfirmasi_gagal)) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Gagal konfirmasi booking.</div>
        <?php endif; ?>

        <?php if (isset($klaim_sukses)) : ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">Booking berhasil diklaim dan status pembayaran diupdate menjadi sukses.</div>
        <?php endif; ?>

        <?php if (isset($klaim_gagal)) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Gagal klaim booking.</div>
        <?php endif; ?>

        <section class="mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-3">Menunggu Konfirmasi</h3>
            <div class="overflow-x-auto rounded-md">
                <table class="min-w-full bg-white divide-y divide-gray-200 border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID Rental</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Penyewa</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">PlayStation</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mulai</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Selesai</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Durasi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pembayaran</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($pending_bookings as $booking) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $booking['rental_id']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo htmlspecialchars($booking['username']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo htmlspecialchars($booking['nama_ps']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo date('d-m-Y H:i', strtotime($booking['tanggal_mulai'])); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo date('d-m-Y H:i', strtotime($booking['tanggal_selesai'])); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $booking['durasi_sewa']; ?> Hari</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo htmlspecialchars(ucfirst($booking['status_pembayaran'])); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <form method="post" class="inline-block">
                                        <input type="hidden" name="rental_id_konfirmasi" value="<?php echo $booking['rental_id']; ?>">
                                        <button type="submit" name="konfirmasi_booking" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md focus:outline-none focus:ring focus:ring-indigo-200 text-xs">Konfirmasi</button>
                                    </form>
                                    <form method="post" class="inline-block">
                                        <input type="hidden" name="rental_id_batal" value="<?php echo $booking['rental_id']; ?>">
                                        <button type="submit" name="batalkan_booking" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md focus:outline-none focus:ring focus:ring-red-200 text-xs">Batalkan</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($pending_bookings)) : ?>
                            <tr><td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada pesanan menunggu konfirmasi.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-3">Sedang Disewakan</h3>
            <div class="overflow-x-auto rounded-md">
                <table class="min-w-full bg-white divide-y divide-gray-200 border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID Rental</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Penyewa</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">PlayStation</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mulai</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Selesai</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Durasi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pembayaran</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($disewakan_bookings as $booking) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $booking['rental_id']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo htmlspecialchars($booking['username']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo htmlspecialchars($booking['nama_ps']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo date('d-m-Y H:i', strtotime($booking['tanggal_mulai'])); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo date('d-m-Y H:i', strtotime($booking['tanggal_selesai'])); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $booking['durasi_sewa']; ?> Hari</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo htmlspecialchars(ucfirst($booking['status_pembayaran'])); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <?php if (strtotime($booking['tanggal_selesai']) <= time()) : ?>
                                        <form method="post" class="inline-block">
                                            <input type="hidden" name="rental_id_klaim" value="<?php echo $booking['rental_id']; ?>">
                                            <button type="submit" name="klaim_booking" class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md focus:outline-none focus:ring focus:ring-green-200 text-xs">Klaim</button>
                                        </form>
                                    <?php else : ?>
                                        <span class="text-gray-500 italic text-xs">Belum Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($disewakan_bookings)) : ?>
                            <tr><td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada PlayStation yang sedang disewakan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
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