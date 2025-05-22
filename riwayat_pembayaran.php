<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

require_once 'includes/koneksi.php';
require_once 'includes/header.php'; // Sesuaikan dengan header pengguna

$user_id = $_SESSION['user_id'];

$sql_riwayat_pembayaran = "SELECT
                                    r.rental_id,
                                    r.tanggal_pemesanan,
                                    r.total_biaya,
                                    r.status_pembayaran
                               FROM rentals r
                               WHERE r.user_id = :user_id
                               ORDER BY r.tanggal_pemesanan DESC";

$stmt_riwayat_pembayaran = $pdo->prepare($sql_riwayat_pembayaran);
$stmt_riwayat_pembayaran->bindParam(':user_id', $user_id);
$stmt_riwayat_pembayaran->execute();
$riwayat_pembayaran = $stmt_riwayat_pembayaran->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Riwayat Pembayaran</h2>

    <?php if (empty($riwayat_pembayaran)): ?>
        <p class="text-gray-600">Belum ada riwayat pembayaran.</p>
    <?php else: ?>
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pemesanan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pemesanan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pembayaran</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($riwayat_pembayaran as $pembayaran): ?>
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($pembayaran['rental_id']); ?></td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars(date('d-m-Y H:i:s', strtotime($pembayaran['tanggal_pemesanan']))); ?></td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">Rp <?php echo number_format($pembayaran['total_biaya'], 0, ',', '.'); ?></td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php
                                    switch ($pembayaran['status_pembayaran']) {
                                        case 'pending': echo 'bg-yellow-100 text-yellow-800'; break;
                                        case 'Sukses': echo 'bg-green-100 text-green-800'; break;
                                        case 'ditolak': echo 'bg-red-100 text-red-800'; break;
                                        default: echo 'bg-gray-100 text-gray-800'; break;
                                    }
                                ?>">
                                    <?php echo htmlspecialchars(ucfirst($pembayaran['status_pembayaran'])); ?>
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-center">
                                <a href="booking/konfirmasi_booking.php?booking_id=<?php echo htmlspecialchars($pembayaran['rental_id']); ?>" class="text-blue-500 hover:underline">Lihat</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>