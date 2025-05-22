<?php
session_start();
require_once 'includes/koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['rental_id'])) {
    $rental_id = $_GET['rental_id'];
    $user_id = $_SESSION['user_id'];

    // Verifikasi bahwa riwayat sewa ini milik pengguna yang login
    $stmt_check = $pdo->prepare("SELECT rental_id FROM rentals WHERE rental_id = :rental_id AND user_id = :user_id");
    $stmt_check->bindParam(':rental_id', $rental_id);
    $stmt_check->bindParam(':user_id', $user_id);
    $stmt_check->execute();

    if ($stmt_check->rowCount() > 0) {
        // Hapus riwayat sewa
        $stmt_delete = $pdo->prepare("DELETE FROM rentals WHERE rental_id = :rental_id");
        $stmt_delete->bindParam(':rental_id', $rental_id);
        if ($stmt_delete->execute()) {
            $_SESSION['hapus_berhasil'] = "Riwayat sewa berhasil dihapus.";
            header("Location: dashboard_user.php");
            exit();
        } else {
            $_SESSION['hapus_gagal'] = "Terjadi kesalahan saat menghapus riwayat sewa.";
            header("Location: dashboard_user.php");
            exit();
        }
    } else {
        $_SESSION['hapus_gagal'] = "Anda tidak memiliki izin untuk menghapus riwayat sewa ini.";
        header("Location: dashboard_user.php");
        exit();
    }
} else {
    header("Location: riwayat_sewa.php");
    exit();
}
?>