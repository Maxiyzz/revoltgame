<?php
session_start();
require_once '../includes/koneksi.php';

// Ambil ID booking dari URL, prioritaskan 'rental_id' (dari admin), lalu coba 'booking_id' (dari user)
$booking_id = $_GET['rental_id'] ?? $_GET['booking_id'] ?? null;

if (!$booking_id) {
    header("Location: ../booking/booking.php");
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;
$admin_id = $_SESSION['admin_id'] ?? null;

$where_clause = 'WHERE r.rental_id = :booking_id';
$params = [':booking_id' => $booking_id];

// Jika bukan admin, batasi berdasarkan user_id
if (!$admin_id && $user_id) {
    $where_clause .= ' AND r.user_id = :user_id';
    $params[':user_id'] = $user_id;
} elseif (!$admin_id && !$user_id) {
    // Jika bukan admin dan tidak ada user_id, redirect
    header("Location: ../auth/login.php");
    exit();
}

// Proses konfirmasi pembayaran oleh admin
if ($admin_id && isset($_POST['konfirmasi_bayar']) && $_POST['konfirmasi_bayar'] == $booking_id) {
    $stmt_update_pembayaran = $pdo->prepare("UPDATE rentals SET status_pembayaran = 'Sukses' WHERE rental_id = :booking_id");
    $stmt_update_pembayaran->bindParam(':booking_id', $booking_id);
    if ($stmt_update_pembayaran->execute()) {
        $konfirmasi_pembayaran_sukses = true;
    } else {
        $konfirmasi_pembayaran_gagal = true;
        // Tambahkan ini untuk melihat pesan error SQL
        echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-2'>Gagal mengkonfirmasi pembayaran karena kesalahan database: " . $stmt_update_pembayaran->errorInfo()[2] . "</div>";
    }
}

// Ambil data booking dari database
$stmt = $pdo->prepare("SELECT r.rental_id, r.nama_kontak, r.nomor_kontak, r.durasi_sewa, r.total_biaya, r.status_pembayaran,
                            p.ps_id, p.nama AS nama_playstation, p.harga_sewa_per_hari AS harga_per_hari
                        FROM rentals r
                        JOIN playstations p ON r.ps_id = p.ps_id
                        $where_clause");
$stmt->execute($params);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    $redirect_location = $admin_id ? 'laporan_transaksi.php' : '../riwayat_sewa.php';
    header("Location: " . $redirect_location);
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Konfirmasi Booking – REVOLT Game</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-green-600">Konfirmasi Pembayaran!</h1>
            <p class="text-sm text-gray-600 mt-1">
                Pembayaran anda berstatus <strong class="<?php echo ($booking['status_pembayaran'] == 'Sukses') ? 'text-green-600' : 'text-yellow-600'; ?>"><?php echo htmlspecialchars(ucfirst($booking['status_pembayaran'])); ?></strong> dengan rincian berikut ini:
            </p>
            <p class="text-xs text-gray-500">Tanggal: <?php echo date('Y-m-d'); ?></p>
            <?php if (isset($konfirmasi_pembayaran_sukses)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-2">Pembayaran berhasil dikonfirmasi!</div>
            <?php elseif (isset($konfirmasi_pembayaran_gagal)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-2">Gagal mengkonfirmasi pembayaran.</div>
            <?php endif; ?>
        </div>

        <div class="bg-gray-50 rounded-md p-4 mb-4 text-sm">
            <p><strong>Kode Pesanan:</strong> <?php echo htmlspecialchars($booking['rental_id']); ?></p>
            <p><strong>ID PS:</strong> <?php echo htmlspecialchars($booking['ps_id']); ?></p>
            <p><strong>Nama:</strong> <?php echo htmlspecialchars($booking['nama_kontak']); ?></p>
            <p><strong>Nomor WhatsApp:</strong> <?php echo htmlspecialchars($booking['nomor_kontak']); ?></p>
            <p><strong>Nama PS:</strong> <?php echo htmlspecialchars($booking['nama_playstation']); ?></p>
            <p><strong>Estimasi:</strong> <?php echo htmlspecialchars($booking['durasi_sewa']); ?> Hari</p>
            <p><strong>Total biaya:</strong> <span class="font-bold text-violet-700">Rp <?php echo number_format($booking['total_biaya'], 0, ',', '.'); ?></span></p>
            <p><strong>Status:</strong> <span class="<?php echo ($booking['status_pembayaran'] == 'Sukses') ? 'text-green-600 font-semibold' : 'text-yellow-600 font-semibold'; ?>"><?php echo htmlspecialchars(ucfirst($booking['status_pembayaran'])); ?></span></p>
        </div>

        <div class="bg-gray-100 p-4 rounded-md text-sm mb-4">
            <p>Silakan lakukan pembayaran ke salah satu rekening berikut:</p>
            <ul class="list-disc list-inside mt-2">
                <li><strong>DANA:</strong> 085157150404 (REVOLT GAME)</li>
                <li><strong>GoPay:</strong> 085157150404 (REVOLT GAME)</li>
            </ul>
            <p>atau bisa hubungi langsung ke WhatsApp Kami:</p>
            <ul class="list-disc list-inside mt-2">
                <li><strong>Ade Rudi</strong> 085861727314</li>
                <li><strong>Syamsul:</strong> 085157150404</li>
            </ul>
            <p class="mt-2">Setelah melakukan pembayaran, kirim bukti transfer ke nomor WhatsApp kami diatas.</p>
            <p>Tim kami akan memproses pesanan Anda setelah pembayaran dikonfirmasi.</p>
        </div>

        <div class="flex justify-end gap-2 mt-6">
            <?php if ($admin_id): ?>
                <form method="POST" class="inline-block">
                    <input type="hidden" name="konfirmasi_bayar" value="<?php echo htmlspecialchars($booking['rental_id']); ?>">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-sm">Konfirmasi Pembayaran</button>
                </form>
                <button onclick="window.location.href = '../admin/laporan_transaksi.php';" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 text-sm">Kembali</button>
            <?php else: ?>
                <button onclick="window.history.back()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 text-sm">Kembali</button>
                <form method="POST" action="../riwayat_sewa.php" class="inline">
                    <input type="hidden" name="rental_id" value="<?php echo htmlspecialchars($booking['rental_id']); ?>">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Lihat Riwayat Sewa</button>
                </form>
            <?php endif; ?>
            <button onclick="window.print()" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm">Cetak</button>
        </div>

        <p class="text-xs text-center text-gray-500 mt-4">
            Keterangan: Jika pesanan Anda belum dikonfirmasi, segera hubungi melalui WhatsApp 085157150404
        </p>
    </div>

</body>
</html>