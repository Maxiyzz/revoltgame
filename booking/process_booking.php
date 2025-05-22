<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../includes/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    http_response_code(403); // Forbidden
    echo json_encode(['success' => false, 'error' => 'Pengguna belum login.']);
    exit();
}

// Terima data booking dari POST request
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if ($data === null) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'error' => 'Data booking tidak valid.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$nama_kontak = $data['nama'];
$nomor_kontak = $data['telepon'];
$durasi_sewa = $data['durasi'];
$produk_nama = $data['produk_nama'];
$total_biaya = $data['total'];
$tanggal_mulai = date('Y-m-d'); // Tanggal mulai adalah hari ini
$tanggal_selesai = date('Y-m-d', strtotime("+" . $durasi_sewa . " days", strtotime($tanggal_mulai)));
$status_penyewaan = 'menunggu konfirmasi';

// Cari ps_id berdasarkan nama produk
$stmt_ps = $pdo->prepare("SELECT ps_id FROM playstations WHERE nama = :nama");
$stmt_ps->bindParam(':nama', $produk_nama);
$stmt_ps->execute();
$playstation = $stmt_ps->fetch(PDO::FETCH_ASSOC);

if (!$playstation) {
    echo json_encode(['success' => false, 'error' => 'Produk tidak ditemukan.']);
    exit();
}

$ps_id = $playstation['ps_id'];

// Simpan data ke tabel rentals
$stmt_insert = $pdo->prepare("INSERT INTO rentals (user_id, ps_id, tanggal_mulai, durasi_sewa, tanggal_selesai, total_biaya, status_penyewaan, nama_kontak, nomor_kontak) VALUES (:user_id, :ps_id, :tanggal_mulai, :durasi_sewa, :tanggal_selesai, :total_biaya, :status_penyewaan, :nama_kontak, :nomor_kontak)");
$stmt_insert->bindParam(':user_id', $user_id);
$stmt_insert->bindParam(':ps_id', $ps_id);
$stmt_insert->bindParam(':tanggal_mulai', $tanggal_mulai);
$stmt_insert->bindParam(':durasi_sewa', $durasi_sewa);
$stmt_insert->bindParam(':tanggal_selesai', $tanggal_selesai);
$stmt_insert->bindParam(':total_biaya', $total_biaya);
$stmt_insert->bindParam(':status_penyewaan', $status_penyewaan);
$stmt_insert->bindParam(':nama_kontak', $nama_kontak);
$stmt_insert->bindParam(':nomor_kontak', $nomor_kontak);

if ($stmt_insert->execute()) {
    $rental_id = $pdo->lastInsertId();
    echo json_encode(['success' => true, 'booking_id' => $rental_id]);
} else {
    echo json_encode(['success' => false, 'error' => 'Gagal menyimpan data booking.']);
}
?>