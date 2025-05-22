<?php
require_once 'includes/koneksi.php';

// Kode PHP lainnya yang menggunakan $pdo untuk berinteraksi dengan database
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>REVOLT Game - Beranda</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="assets/css/tailwind.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<!-- ✅ Navbar Responsive (Tailwind Only) -->
  <?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="bg-blue-600 text-white py-20 text-center">
  <h2 class="text-4xl font-bold mb-4">Sewa Playstation dengan Mudah di REVOLT Game</h2>
  <p class="text-lg">Cepat, mudah, dan terjangkau. Booking sekarang!</p>
  <a href="katalog.php" class="mt-6 inline-block bg-white text-blue-600 px-6 py-2 rounded-lg shadow hover:bg-blue-600 hover:text-white transition">Booking Sekarang</a>
</section>

<!-- Daftar PlayStation -->
<section class="py-16 px-4">
  <div class="max-w-6xl mx-auto text-center mb-10">
    <h2 class="text-3xl font-bold mb-2">PlayStation Unggulan</h2>
    <p class="text-gray-600">Pilihan PlayStation premium kami dengan kondisi terbaik dan siap untuk disewa hari ini.</p>
  </div>

  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
<!-- Card PS 1 -->
<div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
  <div class="relative overflow-hidden rounded-t-lg">
    <img src="asset/img/ps2.jpg" alt="PS2" class="w-full h-48 object-cover transform transition-transform duration-300 hover:scale-110">
    <span class="absolute top-2 right-2 bg-violet-600 text-white text-xs px-2 py-1 rounded">PS2</span>
  </div>
  <div class="mt-4">
    <h3 class="font-semibold text-lg">PlayStation 2</h3>
    <p class="text-sm text-gray-600 mt-1">PlayStation 2 dengan disk drive. Nikmati gaming next-gen dengan kecepatan loading super cepat.</p>
    <span class="text-green-600">Tersedia 2 unit</span>
    <p class="text-sm text-gray-500 mt-2">Mulai dari</p>
    <p class="text-violet-700 font-bold text-xl">Rp 60.000<span class="text-sm font-normal text-gray-600">/hari</span></p>
    <a href="produk/detail1.php" class="mt-3 inline-block bg-violet-600 text-white px-4 py-1 rounded hover:bg-violet-700">Detail</a>
  </div>
</div>

<!-- Card PS 2 -->
<div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
  <div class="relative overflow-hidden rounded-t-lg">
    <img src="asset/img/ps3.jpg" alt="PS3" class="w-full h-48 object-cover transform transition-transform duration-300 hover:scale-110">
    <span class="absolute top-2 right-2 bg-violet-600 text-white text-xs px-2 py-1 rounded">PS3</span>
  </div>
  <div class="mt-4">
    <h3 class="font-semibold text-lg">PlayStation 3</h3>
    <p class="text-sm text-gray-600 mt-1">PlayStation 3 dengan disk drive. Nikmati koleksi game fisik dan digital dengan performa maksimal.</p>
    <span class="text-green-600">Tersedia 8 unit</span>
    <p class="text-sm text-gray-500 mt-2">Mulai dari</p>
    <p class="text-violet-700 font-bold text-xl">Rp 60.000<span class="text-sm font-normal text-gray-600">/hari</span></p>
    <a href="produk/detail3.php" class="mt-3 inline-block bg-violet-600 text-white px-4 py-1 rounded hover:bg-violet-700">Detail</a>
  </div>
</div>

<!-- Card PS 3 -->
<div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
  <div class="relative overflow-hidden rounded-t-lg">
    <img src="asset/img/ps4.jpg" alt="PS4" class="w-full h-48 object-cover transform transition-transform duration-300 hover:scale-110">
    <span class="absolute top-2 right-2 bg-violet-600 text-white text-xs px-2 py-1 rounded">PS4</span>
  </div>
  <div class="mt-4">
    <h3 class="font-semibold text-lg">PlayStation 4</h3>
    <p class="text-sm text-gray-600 mt-1">PlayStation 4 dengan dukungan gaming 4K. Rasakan pengalaman gaming yang lebih halus dan detail pada TV UHD Anda.</p>
    <span class="text-green-600">Tersedia 3 unit</span>
    <p class="text-sm text-gray-500 mt-2">Mulai dari</p>
    <p class="text-violet-700 font-bold text-xl">Rp 150.000<span class="text-sm font-normal text-gray-600">/hari</span></p>
    <a href="produk/detail5.php" class="mt-3 inline-block bg-violet-600 text-white px-4 py-1 rounded hover:bg-violet-700">Detail</a>
  </div>
</div>


  <!-- Tombol Lihat Semua -->
  <div class="mt-10 text-center">
    <a href="katalog.php" class="inline-block border-2 border-violet-600 text-violet-600 px-6 py-2 rounded hover:bg-violet-600 hover:text-white transition">Lihat Semua PlayStation</a>
  </div>
</section>


<!-- Cara Booking PlayStation -->
<section class="bg-gray-50 py-16 px-4">
  <div class="max-w-6xl mx-auto text-center mb-10">
    <h3 class="text-3xl font-bold mb-2">Cara Booking PlayStation</h3>
    <p class="text-gray-600">Proses booking PlayStation di Revolt Game sangat mudah dan cepat. Ikuti langkah-langkah berikut:</p>
  </div>

  <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
    <!-- Step 1 -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
      <div class="bg-gradient-to-r from-violet-500 to-indigo-500 p-6 flex justify-center">
        <div class="bg-white bg-opacity-20 p-4 rounded-full">
          <!-- Heroicon: search -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 16l4-4-4-4m5 8l4-4-4-4"/>
          </svg>
        </div>
      </div>
      <div class="p-6 text-left">
        <div class="flex items-center mb-2">
          <span class="bg-violet-500 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">1</span>
          <h4 class="text-lg font-semibold">Pilih PlayStation</h4>
        </div>
        <p class="text-gray-600 text-sm">Pilih PlayStation yang ingin Anda sewa dan periksa ketersediaannya.</p>
      </div>
    </div>

    <!-- Step 2 -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
      <div class="bg-gradient-to-r from-violet-500 to-indigo-500 p-6 flex justify-center">
        <div class="bg-white bg-opacity-20 p-4 rounded-full">
          <!-- Heroicon: book-open -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 6v12m6-6H6"/>
          </svg>
        </div>
      </div>
      <div class="p-6 text-left">
        <div class="flex items-center mb-2">
          <span class="bg-violet-500 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">2</span>
          <h4 class="text-lg font-semibold">Isi Form Booking</h4>
        </div>
        <p class="text-gray-600 text-sm">Isi form booking dengan data diri dan detail penyewaan.</p>
      </div>
    </div>

    <!-- Step 3 -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
      <div class="bg-gradient-to-r from-violet-500 to-indigo-500 p-6 flex justify-center">
        <div class="bg-white bg-opacity-20 p-4 rounded-full">
          <!-- Heroicon: credit-card -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 10h18M3 16h18M5 6h14a2 2 0 012 2v2H3V8a2 2 0 012-2z"/>
          </svg>
        </div>
      </div>
      <div class="p-6 text-left">
        <div class="flex items-center mb-2">
          <span class="bg-violet-500 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">3</span>
          <h4 class="text-lg font-semibold">Pembayaran</h4>
        </div>
        <p class="text-gray-600 text-sm">Lakukan pembayaran melalui beberapa metode yang tersedia.</p>
      </div>
    </div>

    <!-- Step 4 --> 
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
      <div class="bg-gradient-to-r from-violet-500 to-indigo-500 p-6 flex justify-center">
        <div class="bg-white bg-opacity-20 p-4 rounded-full">
          <!-- Heroicon: truck -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 17v-6h6v6m-3-6V4m0 0L9 8m3-4l3 4"/>
          </svg>
        </div>
      </div>
      <div class="p-6 text-left">
        <div class="flex items-center mb-2">
          <span class="bg-violet-500 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">4</span>
          <h4 class="text-lg font-semibold">Ambil atau Antar</h4>
        </div>
        <p class="text-gray-600 text-sm">Ambil di toko kami atau kami antar ke lokasi Anda.</p>
      </div>
    </div>
  </div>
</section>

<!-- Mengapa Memilih Revolt Game -->
<section class="max-w-6xl mx-auto px-4 py-16 flex flex-col md:flex-row items-center gap-12">
  <!-- Gambar -->
  <div class="md:w-1/2">
    <img src="asset/img/controler.jpg" alt="Controller PlayStation" class="rounded-xl shadow-md">
  </div>

  <!-- Konten -->
  <div class="md:w-1/2">
    <h2 class="text-2xl md:text-3xl font-bold mb-6">Mengapa Memilih Revolt Game?</h2>

    <ul class="space-y-4 text-gray-700">
      <li class="flex items-start gap-3">
        <div class="text-violet-600 mt-1">
          <i class="fas fa-shield-alt"></i>
        </div>
        <div>
          <p class="font-semibold">Perangkat Berkualitas Tinggi</p>
          <p class="text-sm">Kami hanya menyediakan PlayStation dengan kondisi terbaik dan terawat.</p>
        </div>
      </li>

      <li class="flex items-start gap-3">
        <div class="text-violet-600 mt-1">
          <i class="fas fa-gamepad"></i>
        </div>
        <div>
          <p class="font-semibold">Koleksi Game Terlengkap</p>
          <p class="text-sm">Dapatkan akses ke berbagai pilihan game populer dan terbaru.</p>
        </div>
      </li>

      <li class="flex items-start gap-3">
        <div class="text-violet-600 mt-1">
          <i class="fas fa-tags"></i>
        </div>
        <div>
          <p class="font-semibold">Harga Terjangkau</p>
          <p class="text-sm">Nikmati gaming premium dengan harga sewa yang terjangkau dan transparan.</p>
        </div>
      </li>

      <li class="flex items-start gap-3">
        <div class="text-violet-600 mt-1">
          <i class="fas fa-headset"></i>
        </div>
        <div>
          <p class="font-semibold">Dukungan Pelanggan 24/7</p>
          <p class="text-sm">Tim dukungan kami siap membantu Anda 24/7 untuk memastikan pengalaman gaming lancar.</p>
        </div>
      </li>
    </ul>

    <a href="katalog.php" class="mt-8 inline-block px-6 py-2 bg-violet-600 text-white font-semibold rounded-md hover:bg-violet-700 transition">
      Mulai Sekarang →
    </a>
  </div>
</section>

<!-- CTA Section -->
<section class="bg-violet-600 text-white py-16 text-center">
  <div class="max-w-2xl mx-auto px-4">
    <h2 class="text-3xl font-bold mb-4">Siap Untuk Meningkatkan Pengalaman Gaming Anda?</h2>
    <p class="mb-6">Mulai petualangan gaming Anda dengan PlayStation premium kami. <br> Daftar sekarang dan dapatkan pengalaman sewa yang mudah dan menyenangkan.</p>
    <div class="flex justify-center space-x-4">
      <a href="katalog.php" class="bg-white text-violet-600 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition">Lihat Katalog</a>
      <a href="auth/register.php" class="bg-white text-violet-600 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition">Daftar Sekarang</a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>

</body>
</html>
