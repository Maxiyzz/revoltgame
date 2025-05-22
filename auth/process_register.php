<?php
session_start();
require_once '../includes/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Tidak perlu di-sanitize di sini karena akan di-hash

    $errors = [];

    if (empty($username)) {
        $errors[] = "Username harus diisi.";
    }
    if (empty($email)) {
        $errors[] = "Email harus diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    }
    if (empty($password)) {
        $errors[] = "Password harus diisi.";
    }

    if (empty($errors)) {
        // Cek apakah username atau email sudah ada
        $stmt_check = $pdo->prepare("SELECT user_id FROM users WHERE username = :username OR email = :email");
        $stmt_check->bindParam(':username', $username);
        $stmt_check->bindParam(':email', $email);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            $errors[] = "Username atau email sudah terdaftar.";
        } else {
            // Enkripsi password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Simpan ke database
            $stmt_insert = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt_insert->bindParam(':username', $username);
            $stmt_insert->bindParam(':email', $email);
            $stmt_insert->bindParam(':password', $hashed_password);

            if ($stmt_insert->execute()) {
                $_SESSION['register_success'] = "Registrasi berhasil. Silakan login.";
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['register_error'] = "Terjadi kesalahan saat mendaftar.";
                header("Location: register.php");
                exit();
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['register_errors'] = $errors;
        header("Location: register.php");
        exit();
    }

} else {
    header("Location: register.php");
    exit();
}
?>