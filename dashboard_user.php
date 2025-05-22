<?php
session_start();
require_once 'includes/koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

require_once 'includes/header.php';

// Ambil data stok PlayStation per tipe
$stmt_stok_tipe = $pdo->query("
    SELECT tipe_ps, SUM(stok) AS total_stok
    FROM playstations
    GROUP BY tipe_ps
    ORDER BY tipe_ps
");
$stok_per_tipe = $stmt_stok_tipe->fetchAll(PDO::FETCH_ASSOC);

$user_id = $_SESSION['user_id'];

// Ambil data riwayat penyewaan dari database
$stmt = $pdo->prepare("
    SELECT
        r.rental_id,
        p.nama AS nama_ps,
        r.tanggal_mulai,
        r.tanggal_selesai,
        r.total_biaya,
        r.status_penyewaan
    FROM rentals r
    JOIN playstations p ON r.ps_id = p.ps_id
    WHERE r.user_id = :user_id
    ORDER BY r.tanggal_pemesanan DESC
");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$riwayat_sewa = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Dashboard User</h2>

    <!-- Stok PlayStation -->
    <div class="mb-10">
        <h3 class="font-semibold text-gray-700 mb-4">Stok PlayStation Berdasarkan Tipe</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php if (empty($stok_per_tipe)): ?>
                <p class="text-gray-500">Tidak ada data stok PlayStation.</p>
            <?php else: ?>
                <?php foreach ($stok_per_tipe as $stok): ?>
                    <div class="bg-gray-100 rounded-lg p-4 shadow-sm">
                        <h4 class="text-sm font-semibold text-gray-600 uppercase"><?php echo htmlspecialchars($stok['tipe_ps']); ?></h4>
                        <p class="text-2xl font-bold text-green-600"><?php echo $stok['total_stok']; ?></p>
                        <p class="text-xs text-gray-500">Total Stok</p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Riwayat Penyewaan -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 mb-4">Riwayat Sewa</h1>

        <?php if (empty($riwayat_sewa)) : ?>
            <p class="text-gray-600">Anda belum memiliki riwayat penyewaan.</p>
        <?php else : ?>
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mulai Sewa</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Selesai Sewa</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($riwayat_sewa as $sewa) : ?>
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo $sewa['nama_ps']; ?>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo $sewa['tanggal_mulai']; ?>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo $sewa['tanggal_selesai']; ?>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp <?php echo number_format($sewa['total_biaya'], 0, ',', '.'); ?>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php
                                        switch ($sewa['status_penyewaan']) {
                                            case 'selesai': echo 'bg-green-100 text-green-800'; break;
                                            case 'dibatalkan': echo 'bg-red-100 text-red-800'; break;
                                            case 'disewakan': echo 'bg-blue-100 text-blue-800'; break;
                                            case 'menunggu konfirmasi': echo 'bg-yellow-100 text-yellow-800'; break;
                                            default: echo 'bg-gray-100 text-gray-800'; break;
                                        }
                                    ?>">
                                        <?php echo $sewa['status_penyewaan']; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>