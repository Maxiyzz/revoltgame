<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

require_once '../includes/koneksi.php';

// Proses update stok dengan distribusi stok ganjil
if (isset($_POST['update_stok_tipe'])) {
    $tipe_ps = $_POST['tipe_ps'];
    $stok_baru = (int) $_POST['stok_baru'];

    if ($stok_baru < 0) {
        $update_gagal = true;
    } else {
        // Ambil semua ps_id berdasarkan tipe
        $stmt_ambil = $pdo->prepare("SELECT ps_id FROM playstations WHERE tipe_ps = :tipe_ps");
        $stmt_ambil->execute([':tipe_ps' => $tipe_ps]);
        $ps_ids = $stmt_ambil->fetchAll(PDO::FETCH_COLUMN);

        $jumlah_data = count($ps_ids);
        if ($jumlah_data > 0) {
            $stok_per_item = intdiv($stok_baru, $jumlah_data);
            $sisa = $stok_baru % $jumlah_data;

            $pdo->beginTransaction();
            try {
                foreach ($ps_ids as $index => $ps_id) {
                    $stok_individu = $stok_per_item + ($index < $sisa ? 1 : 0);
                    $stmt_update = $pdo->prepare("UPDATE playstations SET stok = :stok WHERE ps_id = :ps_id");
                    $stmt_update->execute([
                        ':stok' => $stok_individu,
                        ':ps_id' => $ps_id
                    ]);
                }
                $pdo->commit();
                $update_sukses = true;
            } catch (Exception $e) {
                $pdo->rollBack();
                $update_gagal = true;
            }
        } else {
            $update_gagal = true;
        }
    }
}

// Ambil data tipe PS dan total stoknya
$stmt_tipe = $pdo->query("
        SELECT tipe_ps, SUM(stok) AS total_stok
        FROM playstations
        GROUP BY tipe_ps
        ORDER BY tipe_ps
    ");
$daftar_tipe_ps = $stmt_tipe->fetchAll(PDO::FETCH_ASSOC);

// Ambil semua data playstation untuk detail
$stmt_detail = $pdo->prepare("SELECT ps_id, nama, stok, status_ketersediaan FROM playstations WHERE tipe_ps = :tipe_ps ORDER BY nama");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data PlayStation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script>
        function toggleEditStokTipeForm(tipePs) {
            const stokSpan = document.getElementById(`stok-tipe-${tipePs}`);
            const editForm = document.getElementById(`form-edit-tipe-${tipePs}`);
            stokSpan.classList.toggle('hidden');
            editForm.classList.toggle('hidden');
        }

        function toggleDetail(tipePs) {
            const detailTable = document.getElementById(`detail-${tipePs}`);
            detailTable.classList.toggle('hidden');
        }
    </script>
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
        <li class="p-2 <?php if (basename($_SERVER['PHP_SELF']) == 'data_ps.php') echo 'bg-gray-700'; else echo 'hover:bg-gray-700'; ?>">
            <a href="data_ps.php" class="block text-sm"><i class="fas fa-gamepad mr-2"></i> Data PlayStation</a>
        </li>
        <li class="p-2 <?php if (basename($_SERVER['PHP_SELF']) == 'daftar_user.php') echo 'bg-gray-700'; else echo 'hover:bg-gray-700'; ?>">
            <a href="daftar_user.php" class="block text-sm"><i class="fas fa-users mr-2"></i> Daftar User</a>
        </li>
        <li class="p-2 <?php if (basename($_SERVER['PHP_SELF']) == 'laporan_transaksi.php') echo 'bg-gray-700'; else echo 'hover:bg-gray-700'; ?>">
            <a href="laporan_transaksi.php" class="block text-sm"><i class="fas fa-chart-bar mr-2"></i> Laporan Transaksi</a>
        </li>
        <li class="p-2 <?php if (basename($_SERVER['PHP_SELF']) == 'kelola_booking.php') echo 'bg-gray-700'; else echo 'hover:bg-gray-700'; ?>">
            <a href="kelola_booking.php" class="block text-sm"><i class="fas fa-calendar-alt mr-2"></i> Kelola Booking</a>
        </li>
        <li class="p-2 hover:bg-gray-700">
            <a href="../auth/logout.php" class="block text-sm"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
        </li>
    </ul>
</div>

    <div class="px-6 py-8 sm:ml-64 bg-gray-100 min-h-screen">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Data PlayStation</h2>

            <?php if (isset($update_sukses)) : ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">Stok berhasil diperbarui.</span>
                </div>
            <?php endif; ?>

            <?php if (isset($update_gagal)) : ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline">Terjadi kesalahan saat memperbarui stok.</span>
                </div>
            <?php endif; ?>

            <div class="overflow-x-auto rounded-md">
                <table class="min-w-full bg-white divide-y divide-gray-200 border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe PlayStation</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Stok</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($daftar_tipe_ps as $tipe) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($tipe['tipe_ps']); ?>
                                    <button onclick="toggleDetail('<?php echo $tipe['tipe_ps']; ?>')" class="ml-2 text-xs bg-gray-200 hover:bg-gray-300 text-gray-800 px-2 py-1 rounded">
                                        Lihat Detail
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span id="stok-tipe-<?php echo $tipe['tipe_ps']; ?>"><?php echo $tipe['total_stok']; ?> unit</span>
                                    <form id="form-edit-tipe-<?php echo $tipe['tipe_ps']; ?>" method="post" class="hidden mt-2">
                                        <input type="hidden" name="tipe_ps" value="<?php echo $tipe['tipe_ps']; ?>">
                                        <input type="number" name="stok_baru" class="w-20 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" value="<?php echo $tipe['total_stok']; ?>">
                                        <button type="submit" name="update_stok_tipe" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Simpan</button>
                                        <button type="button" onclick="toggleEditStokTipeForm('<?php echo $tipe['tipe_ps']; ?>')" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs font-medium rounded shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-2">Batal</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="toggleEditStokTipeForm('<?php echo $tipe['tipe_ps']; ?>')" class="text-indigo-600 hover:text-indigo-900 text-xs">Edit Stok</button>
                                </td>
                            </tr>
                            <tr id="detail-<?php echo $tipe['tipe_ps']; ?>" class="hidden">
                                <td colspan="3" class="px-6 py-4 whitespace-normal text-sm text-gray-900">
                                    <strong class="block mb-2">Detail <?php echo htmlspecialchars($tipe['tipe_ps']); ?>:</strong>
                                    <div class="overflow-x-auto rounded-md">
                                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <?php
                                                $stmt_detail->bindParam(':tipe_ps', $tipe['tipe_ps']);
                                                $stmt_detail->execute();
                                                $detail_ps = $stmt_detail->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($detail_ps as $dp) : ?>
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($dp['nama']); ?></td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $dp['stok']; ?></td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($dp['status_ketersediaan']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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