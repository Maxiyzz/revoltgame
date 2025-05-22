<?php
require_once '../includes/koneksi.php';

// Kode PHP lainnya yang menggunakan $pdo untuk berinteraksi dengan database
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | Revolt Game</title>
  <link href="../assets/css/style.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../asset/js/auth.js"></script>
</head>
<body 
  class="bg-cover bg-center flex items-center justify-center min-h-screen"
  style="background-image: url('../asset/img/background.jpg');"
>

<div class="bg-[rgba(15,23,58,0.8)] p-8 rounded-lg shadow-lg w-full max-w-md">
    <div class="text-center mb-6">
      <img src="../asset/img/logo.png" alt="Revolt Game" class="mx-auto w-24 mb-2">
      <h1 class="text-white text-2xl font-bold">Revolt Game</h1>
    </div>
    
    <div class="flex justify-center mb-6">
      <a href="login.php" class="w-1/2 bg-gray-700 text-gray-300 py-2 text-center rounded-l-lg hover:bg-blue-600 hover:text-white transition">Login</a>
      <button class="w-1/2 bg-blue-600 text-white py-2 font-semibold rounded-r-lg">Sign Up</button>
    </div>

    <h2 class="text-white text-xl font-bold mb-4">Create Account</h2>

    <form action="process_register.php" method="post">
        <div class="mb-4">
            <input type="text" name="username" placeholder="Username *" class="w-full p-3 rounded bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <input type="email" name="email" placeholder="Email Address *" class="w-full p-3 rounded bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <input type="password" name="password" placeholder="Password *" class="w-full p-3 rounded bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex items-center mb-4">
            <input type="checkbox" class="mr-2">
            <p class="text-gray-400 text-sm">I agree to the <a href="#" class="text-blue-400 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-400 hover:underline">Privacy Policy</a>.</p>
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 py-3 rounded text-white font-semibold">Create Account</button>
    </form> 

    <p class="text-gray-400 text-center text-sm mt-6">
      Already have an account? 
      <a href="login.php" class="text-blue-400 hover:underline">Login instead</a>
    </p>

    <p class="text-gray-500 text-center text-xs mt-4">
      Revolt Game — Premium PlayStation Rental Service
    </p>

    <a href="../index.php" class="text-violet-500 hover:underline text-sm">
      ← Kembali ke Beranda
    </a>
  </div>

</body>
</html>
