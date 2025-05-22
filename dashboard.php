<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    // Jika bukan admin, redirect ke halaman lain (misalnya, index)
    header("Location: index.php");
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

?>

<div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Dashboard Admin</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg p-6 shadow-md">
            <h3 class="font-semibold text-gray-700 mb-2">Total User Terdaftar</h3>
            <?php
            $stmt = $pdo->query("SELECT COUNT(*) FROM users");
            $total_users = $stmt->fetchColumn();
            ?>
            <p class="text-3xl font-bold text-blue-600"><?php echo $total_users; ?></p>
        </div>

        <div class="bg-white rounded-lg p-6 shadow-md">
            <h3 class="font-semibold text-gray-700 mb-2">Stok PS Berdasarkan Tipe</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                <?php if (empty($stok_per_tipe)): ?>
                    <p class="text-gray-500">Tidak ada data stok.</p>
                <?php else: ?>
                    <?php foreach ($stok_per_tipe as $stok): ?>
                        <div class="bg-gray-100 rounded-md p-3 border">
                            <h4 class="text-sm font-semibold text-gray-600 uppercase"><?php echo htmlspecialchars($stok['tipe_ps']); ?></h4>
                            <p class="text-xl font-bold text-green-600"><?php echo $stok['total_stok']; ?></p>
                            <p class="text-xs text-gray-500">Total Stok</p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 shadow-md">
            <h3 class="font-semibold text-gray-700 mb-2">Menunggu Konfirmasi</h3>
            <?php
            $stmt_menunggu = $pdo->query("SELECT COUNT(*) FROM rentals WHERE status_pembayaran = 'pending'");
            $menunggu = $stmt_menunggu->fetchColumn();
            ?>
            <p class="text-3xl font-bold text-yellow-600"><?php echo $menunggu; ?></p>
        </div>
    </div>
</div>

    <!-- Transaksi Terakhir -->
    <div class="mt-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Transaksi Terakhir</h3>
        <div class="overflow-x-auto rounded-lg shadow-sm bg-white">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PlayStation</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Mulai</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $stmt_transaksi = $pdo->query("SELECT r.rental_id, u.username, p.nama AS nama_playstation,
                                                        r.tanggal_mulai, r.status_pembayaran, r.total_biaya
                                                        FROM rentals r
                                                        JOIN users u ON r.user_id = u.user_id
                                                        JOIN playstations p ON r.ps_id = p.ps_id
                                                        ORDER BY r.tanggal_pemesanan DESC
                                                        LIMIT 10");
                    $transaksi_terakhir = $stmt_transaksi->fetchAll(PDO::FETCH_ASSOC);

                    if (count($transaksi_terakhir) > 0) {
                        foreach ($transaksi_terakhir as $transaksi) {
                            echo "<tr>";
                            echo "<td class='px-4 py-3 whitespace-nowrap text-sm'>" . htmlspecialchars($transaksi['rental_id']) . "</td>";
                            echo "<td class='px-4 py-3 whitespace-nowrap text-sm'>" . htmlspecialchars($transaksi['username']) . "</td>";
                            echo "<td class='px-4 py-3 whitespace-nowrap text-sm'>" . htmlspecialchars($transaksi['nama_playstation']) . "</td>";
                            echo "<td class='px-4 py-3 whitespace-nowrap text-sm'>" . htmlspecialchars($transaksi['tanggal_mulai']) . "</td>";
                            echo "<td class='px-4 py-3 whitespace-nowrap text-sm'>" . htmlspecialchars($transaksi['status_pembayaran']) . "</td>";
                            echo "<td class='px-4 py-3 whitespace-nowrap text-sm'>Rp " . number_format($transaksi['total_biaya'], 0, ',', '.') . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='px-4 py-3 text-center text-sm text-gray-500'>Tidak ada transaksi terbaru.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
require_once 'includes/footer.php';
?>