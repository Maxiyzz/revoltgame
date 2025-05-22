<?php
session_start();
require_once '../includes/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING); // Bisa username atau email
    $password = $_POST['password'];

    if (empty($login) || empty($password)) {
        $_SESSION['login_error'] = "Username/Email dan password harus diisi.";
        header("Location: login.php");
        exit();
    }

    // Cari pengguna berdasarkan username atau email
    $stmt = $pdo->prepare("SELECT user_id, username, email, password, role FROM users WHERE username = :login OR email = :login");
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Login berhasil
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        

        // Redirect ke halaman beranda atau dashboard sesuai role
        if ($user['role'] === 'admin') {
            header("Location: admin/dashboard.php"); // Belum dibuat
        } else {
            header("Location: ../index.php");
        }
        exit();
    } else {
        // Login gagal
        $_SESSION['login_error'] = "Login gagal. Username/Email atau password salah.";
        header("Location: login.php");
        exit();
    }

} else {
    header("Location: login.php");
    exit();
}
?>