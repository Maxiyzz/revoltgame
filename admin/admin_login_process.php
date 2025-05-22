<?php
session_start();
require_once '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header("Location: admin_login.php?error=1");
        exit();
    }

    $stmt = $pdo->prepare("SELECT admin_id, password FROM admin WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['role'] = 'admin'; // Set role admin
        header("Location: ../index.php"); // Redirect ke dashboard umum
        exit();
    } else {
        header("Location: admin_login.php?error=1"); // Redirect kembali dengan pesan error
        exit();
    }
} else {
    // Jika bukan metode POST
    header("Location: admin_login.php");
    exit();
}
?>