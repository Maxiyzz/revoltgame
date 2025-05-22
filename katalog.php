<?php
require_once 'includes/koneksi.php';

// Kode PHP lainnya yang menggunakan $pdo untuk berinteraksi dengan database
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>REVOLT Game - Katalog</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-[#0A0F30] to-[#0D1445]   ">

<?php include 'includes/header.php'; ?>

  <!-- Hero Section Katalog -->
  <section class="bg-gradient-to-b from-[#0A0F30] to-[#0D1445]-50 py-16 text-center">
    <div class="max-w-6xl mx-auto px-4">
      <h1 class="text-4xl text-white   font-bold mb-2">Katalog PlayStation</h1>
      <p class="text-lg text-white">Pilih PlayStation yang ingin Anda sewa dari koleksi premium kami. Dilengkapi dengan berbagai pilihan game populer.</p>
    </div>
  </section>  

  <!-- Daftar Katalog PlayStation -->
  <section class="max-w-6xl mx-auto px-4 py-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

    <!-- Card: ps 2 only -->
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-2xl transition duration-300">
      <div class="relative">
        <img src="asset/img/ps2.jpg" alt="PS2 only" class="w-full h-48 object-cover transform transition-transform duration-300 hover:scale-110">
        <span class="absolute top-2 right-2 bg-violet-600 text-white text-xs px-2 py-1 rounded">PS2</span>
      </div>
      <div class="p-4">
        <h3 class="text-lg font-semibold mb-1">PlayStation 2 only</h3>
        <div class="flex items-center text-sm mb-2">
          <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
          <span class="text-green-600">Tersedia</span>
        </div>
        <p class="text-gray-600 text-sm mb-4">PS2 only.</p>
        <p class="text-sm text-gray-500">Mulai dari</p>
        <p class="text-violet-700 font-bold text-xl mb-4">Rp 60.000<span class="text-sm font-normal text-gray-600">/hari</span></p>
        <a href="produk/detail1.php" class="block text-center bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700 transition">Detail</a>
      </div>
    </div>

    <!-- Card: PS2 + tv -->
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-2xl transition duration-300">
      <div class="relative">
        <img src="asset/img/ps2.jpg" alt="PS2 + Televisi" class="w-full h-48 object-cover transform transition-transform duration-300 hover:scale-110">
        <span class="absolute top-2 right-2 bg-violet-600 text-white text-xs px-2 py-1 rounded">PS2</span>
      </div>
      <div class="p-4">
        <h3 class="text-lg font-semibold mb-1">PlayStation 2 + Televisi</h3>
        <div class="flex items-center text-sm mb-2">
          <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
          <span class="text-green-600">Tersedia</span>
        </div>
        <p class="text-gray-600 text-sm mb-4">Disk drive & koleksi game fisik & digital.</p>
        <p class="text-sm text-gray-500">Mulai dari</p>
        <p class="text-violet-700 font-bold text-xl mb-4">Rp 100.000<span class="text-sm font-normal text-gray-600">/hari</span></p>
        <a href="produk/detail2.php" class="block text-center bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700 transition">Detail</a>
      </div>
    </div>

    <!-- Card: PS3 only -->
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-2xl transition duration-300">
      <div class="relative">
        <img src="asset/img/ps3.jpg" alt="PS3 only" class="w-full h-48 object-cover transform transition-transform duration-300 hover:scale-110">
        <span class="absolute top-2 right-2 bg-violet-600 text-white text-xs px-2 py-1 rounded">PS3</span>
      </div>
      <div class="p-4">
        <h3 class="text-lg font-semibold mb-1">PlayStation 3 only </h3>
        <div class="flex items-center text-sm mb-2">
          <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
          <span class="text-green-600">Tersedia</span>
        </div>
        <p class="text-gray-600 text-sm mb-4">4K support untuk pengalaman gaming maksimal.</p>
        <p class="text-sm text-gray-500">Mulai dari</p>
        <p class="text-violet-700 font-bold text-xl mb-4">Rp 60.000<span class="text-sm font-normal text-gray-600">/hari</span></p>
        <a href="produk/detail3.php" class="block text-center bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700 transition">Detail</a>
      </div>
    </div>

    <!-- Card: PS3 + Televisi -->
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-2xl transition duration-300">
      <div class="relative">
        <img src="asset/img/ps3.jpg" alt="PS3 only" class="w-full h-48 object-cover transform transition-transform duration-300 hover:scale-110">
        <span class="absolute top-2 right-2 bg-violet-600 text-white text-xs px-2 py-1 rounded">PS3</span>
      </div>
      <div class="p-4">
        <h3 class="text-lg font-semibold mb-1">PlayStation 3 + Televisi</h3>
        <div class="flex items-center text-sm mb-2">
          <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
          <span class="text-green-600">Tersedia</span>
        </div>
        <p class="text-gray-600 text-sm mb-4">4K support untuk pengalaman gaming maksimal.</p>
        <p class="text-sm text-gray-500">Mulai dari</p>
        <p class="text-violet-700 font-bold text-xl mb-4">Rp 200.000<span class="text-sm font-normal text-gray-600">/hari</span></p>
        <a href="produk/detail4.php" class="block text-center bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700 transition">Detail</a>
      </div>
    </div>

    <!-- Card: PS4 only -->
     <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-2xl transition duration-300">
      <div class="relative">
        <img src="asset/img/ps4.jpg" alt="PS4 only" class="w-full h-48 object-cover transform transition-transform duration-300 hover:scale-110">
        <span class="absolute top-2 right-2 bg-violet-600 text-white text-xs px-2 py-1 rounded">PS4</span>
      </div>
      <div class="p-4">
        <h3 class="text-lg font-semibold mb-1">PlayStation 4 only</h3>
        <div class="flex items-center text-sm mb-2">
          <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
          <span class="text-green-600">Tersedia</span>
        </div>
        <p class="text-gray-600 text-sm mb-4">Bundle PS4 dengan game terbaru.</p>
        <p class="text-sm text-gray-500">Mulai dari</p>
        <p class="text-violet-700 font-bold text-xl mb-4">Rp 150.000<span class="text-sm font-normal text-gray-600">/hari</span></p>
        <a href="produk/detail5.php" class="block text-center bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700 transition">Detail</a>
      </div>
    </div>

    <!-- Card: PS4 + Televisi -->
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-2xl transition duration-300">
      <div class="relative">
        <img src="asset/img/ps4.jpg" alt="PS4 + Televisi"class="w-full h-48 object-cover transform transition-transform duration-300 hover:scale-110">
        <span class="absolute top-2 right-2 bg-violet-600 text-white text-xs px-2 py-1 rounded">PS4</span>
      </div>
      <div class="p-4">
        <h3 class="text-lg font-semibold mb-1">PlayStation 4 Televisi</h3>
        <div class="flex items-center text-sm mb-2">
          <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
          <span class="text-green-600">Tersedia</span>
        </div>
        <p class="text-gray-600 text-sm mb-4">PS4 + Televisi.</p>
        <p class="text-sm text-gray-500">Mulai dari</p>
        <p class="text-violet-700 font-bold text-xl mb-4">Rp 250.000<span class="text-sm font-normal text-gray-600">/hari</span></p>
        <a href="produk/detail6.php" class="block text-center bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700 transition duration-300">Detail</a>
      </div>
    </div>

  </section>

<?php include 'includes/footer.php'; ?>

</body>
</html>
