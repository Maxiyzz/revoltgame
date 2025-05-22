<?php
require_once 'includes/koneksi.php';

// Kode PHP lainnya yang menggunakan $pdo untuk berinteraksi dengan database
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>REVOLT Game - Tentang Kami</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<!-- ✅ Navbar Responsive (Tailwind Only) -->

  <?php include 'includes/header.php'; ?>

  <!-- Section Header -->
  <section class="bg-[#0B1120] text-white py-16 text-center">
    <h1 class="text-4xl font-bold mb-2">Tentang Revolt Game</h1>
    <p class="text-lg">Penyedia jasa rental PlayStation terbaik dan terpercaya di Indonesia</p>
  </section>

  <!-- Section Cerita Kami -->
  <section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
      
      <!-- Gambar -->
      <div>
        <img src="asset/img/revolt.jpg" alt="Orang main PlayStation" class="w-full h-auto rounded-xl shadow-lg object-cover transform transition-transform duration-300 hover:scale-110">
      </div>

      <!-- Teks -->
      <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Cerita Kami</h2>
        <p class="text-gray-700 mb-4">
          Revolt Game didirikan pada tahun 2008 dengan semangat untuk memberikan akses gaming berkualitas kepada semua orang.
          Kami percaya bahwa semua orang berhak menikmati pengalaman bermain PlayStation tanpa harus membeli perangkat yang mahal.
        </p>
        <p class="text-gray-700 mb-4">
          Berawal dari hobi dan passion akan gaming, kami membangun Revolt Game menjadi penyedia jasa rental PlayStation Rumahan
          yang terpercaya dengan pelayanan profesional dan harga yang terjangkau.
        </p>
        <p class="text-gray-700">
          Saat ini, Revolt Game telah melayani lebih dari 500 pelanggan puas dan terus berkembang untuk memberikan pengalaman
          gaming terbaik bagi para pelanggan kami.
        </p>
      </div>

    </div>
  </section>

  <!-- Section Nilai-Nilai Kami -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold text-gray-900 mb-4">Nilai-Nilai Kami</h2>
      <p class="text-gray-600 mb-12">
        Kami berkomitmen untuk memberikan pengalaman rental PlayStation terbaik <br />
        dengan mengedepankan nilai-nilai berikut:
      </p>
  
      <div class="grid md:grid-cols-3 gap-8">
        <!-- Kualitas Terbaik -->
        <div class="bg-gray-50 p-8 rounded-2xl shadow-sm hover:shadow-lg transition">
          <div class="mb-4 flex justify-center">
            <div class="bg-purple-100 text-purple-600 p-4 rounded-full">
              <i class="fas fa-trophy text-3xl"></i>
            </div>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Kualitas Terbaik</h3>
          <p class="text-gray-600">
            Kami selalu menyediakan PlayStation dalam kondisi terbaik dan terawat.
          </p>
        </div>
  
        <!-- Keamanan & Kenyamanan -->
        <div class="bg-gray-50 p-8 rounded-2xl shadow-sm hover:shadow-lg transition">
          <div class="mb-4 flex justify-center">
            <div class="bg-purple-100 text-purple-600 p-4 rounded-full">
              <i class="fas fa-shield-alt text-3xl"></i>
            </div>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Keamanan & Kenyamanan</h3>
          <p class="text-gray-600">
            Kami memprioritaskan keamanan dan kenyamanan pelanggan dalam setiap transaksi.
          </p>
        </div>
  
        <!-- Pelayanan Prima -->
        <div class="bg-gray-50 p-8 rounded-2xl shadow-sm hover:shadow-lg transition">
          <div class="mb-4 flex justify-center">
            <div class="bg-purple-100 text-purple-600 p-4 rounded-full">
              <i class="fas fa-heart text-3xl"></i>
            </div>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Pelayanan Prima</h3>
          <p class="text-gray-600">
            Kami berkomitmen memberikan pelayanan terbaik untuk kepuasan pelanggan.
          </p>
        </div>
      </div>
    </div>
  </section>

<!-- Section Tim Kami -->
<section class="py-16 bg-gray-50">
  <div class="max-w-7xl mx-auto px-6 text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-4">Tim Kami</h2>
    <p class="text-gray-600 mb-12">
      Kenali tim hebat di balik Revolt Game yang bekerja keras untuk memberikan <br />
      layanan terbaik untuk Anda
    </p>

    <div class="grid md:grid-cols-3 gap-8 ">
      <!-- Ade Rudi -->
      <div class="bg-white rounded-2xl overflow-hidden shadow-sm w-full max-w-sm hover:shadow-lg transition">
        <div class="overflow-hidden">
          <img src="asset/img/ade_rudi.jpg" alt="Ade Rudi" class="w-full h-80 object-cover transform transition-transform duration-300 hover:scale-110">
        </div>
        <div class="p-5">
          <h3 class="text-xl font-semibold text-gray-900">Ade Rudi</h3>
          <p class="text-purple-600 text-sm">Pemilik Revolt Game Rental</p>
        </div>
      </div>

      <!-- Syamsul -->
      <div class="bg-white rounded-2xl overflow-hidden shadow-sm w-full max-w-sm hover:shadow-lg transition">
        <div class="overflow-hidden">
          <img src="asset/img/syamsul.jpg" alt="Muhammad Syamsul Ma'arif" class="w-full h-80 object-cover transform transition-transform duration-300 hover:scale-110">
        </div>
        <div class="p-5">
          <h3 class="text-xl font-semibold text-gray-900">Muhammad Syamsul Ma'arif</h3>
          <p class="text-purple-600 text-sm">UI/UX Designer, Frontend & Backend Developer</p>
        </div>
      </div>

      <!-- Fadil -->
      <div class="bg-white rounded-2xl overflow-hidden shadow-sm w-full max-w-sm hover:shadow-lg transition">
        <div class="overflow-hidden">
          <img src="asset/img/fadil.jpg" alt="Fadil Darmawan" class="w-full h-80 object-cover transform transition-transform duration-300 hover:scale-110">
        </div>
        <div class="p-5">
          <h3 class="text-xl font-semibold text-gray-900">Fadil Darmawan</h3>
          <p class="text-purple-600 text-sm">Developer Analyst</p>
        </div>
      </div>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>

</body>
</html>
