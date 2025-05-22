<?php
session_start();
require_once 'includes/koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;
$admin_id = $_SESSION['admin_id'] ?? null;
$rental_id_dari_admin = $_GET['rental_id'] ?? null;

$where_clause = '';
$params = [];

if ($admin_id && $rental_id_dari_admin) {
    $where_clause = 'WHERE r.rental_id = :rental_id';
    $params[':rental_id'] = $rental_id_dari_admin;
} elseif ($user_id) {
    $where_clause = 'WHERE r.user_id = :user_id';
    $params[':user_id'] = $user_id;
} else {
    // Jika tidak ada user_id atau rental_id dari admin, mungkin redirect atau tampilkan pesan
    echo "<p>Akses tidak valid.</p>";
    exit();
}

// Ambil data riwayat penyewaan dari database
$sql = "
    SELECT
        r.rental_id,
        p.nama AS nama_ps,
        r.tanggal_mulai,
        r.tanggal_selesai,
        r.total_biaya,
        r.status_penyewaan
    FROM rentals r
    JOIN playstations p ON r.ps_id = p.ps_id
    $where_clause
    ORDER BY r.tanggal_pemesanan DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$riwayat_sewa = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include 'includes/header.php'; ?>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-900 mb-4">Riwayat Sewa</h1>

    <?php if (empty($riwayat_sewa)) : ?>
        <p class="text-gray-600">
            <?php if ($admin_id && $rental_id_dari_admin): ?>
                Tidak ada riwayat sewa untuk kode pemesanan ini.
            <?php else: ?>
                Anda belum memiliki riwayat penyewaan.
            <?php endif; ?>
        </p>
    <?php else : ?>
        <div class="overflow-x-auto shadow border border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Pesanan</th> <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mulai Sewa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Selesai Sewa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($riwayat_sewa as $sewa) : ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo htmlspecialchars($sewa['rental_id']); ?></td> <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?php echo htmlspecialchars($sewa['nama_ps']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($sewa['tanggal_mulai']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($sewa['tanggal_selesai']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Rp <?php echo number_format($sewa['total_biaya'], 0, ',', '.'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    <?php
                                        switch ($sewa['status_penyewaan']) {
                                            case 'selesai': echo 'bg-green-100 text-green-800'; break;
                                            case 'dibatalkan': echo 'bg-red-100 text-red-800'; break;
                                            case 'disewakan': echo 'bg-blue-100 text-blue-800'; break;
                                            case 'menunggu konfirmasi': echo 'bg-yellow-100 text-yellow-800'; break;
                                            default: echo 'bg-gray-100 text-gray-800'; break;
                                        }
                                    ?>">
                                    <?php echo htmlspecialchars($sewa['status_penyewaan']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="hapus_riwayat_sewa.php?rental_id=<?php echo $sewa['rental_id']; ?>"
                                    class="text-red-600 hover:text-red-900">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>