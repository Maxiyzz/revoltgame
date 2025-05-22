<?php
$password = 'admin123'; // Ganti dengan password yang Anda inginkan untuk admin
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed Password: " . $hashedPassword;
?>