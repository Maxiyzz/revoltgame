<?php
require_once 'includes/koneksi.php';

// Kode PHP lainnya yang menggunakan $pdo untuk berinteraksi dengan database
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>REVOLT Game - Kontak Kami</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <?php include 'includes/header.php'; ?>

  <!-- Hero Section Kontak -->
  <section class="bg-[#0B1120] text-white py-16 text-center">
    <div class="max-w-7xl mx-auto px-4">
      <h1 class="text-4xl font-bold mb-2">Kontak Kami</h1>
      <p class="text-lg">Punya pertanyaan atau butuh bantuan? Hubungi kami melalui form di bawah ini.</p>
    </div>
  </section>

  <!-- Kontak Kami Section -->
  <section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-start bg-gray- rounded-lg shadow-md p-8">
      <!-- Text Intro -->
      <div>
        <h2 class="text-3xl font-bold mb-2">Kontak Kami</h2>
        <p class="text-gray-600 mb-6">Silakan tinggalkan pesan Anda pada form di samping, kami akan segera merespons.</p>
      </div>
      <!-- Form Kontak -->
      <form onsubmit="sendMessage()" class="space-y-6">
        <div>
          <label for="nam" class="block text-gray-700 font-medium mb-1">Nama Anda:</label>
          <input type="text" id="name" name="name" placeholder="Masukkan Nama" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required/>
        </div>
        <div>
          <label for="email" class="block text-gray-700 font-medium mb-1">E-mail Anda:</label>
          <input type="email" id="email" name="email" placeholder="Masukkan Email" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required/>
        </div>
        <div>
          <label for="pesan" class="block text-gray-700 font-medium mb-1">Pesan Anda:</label>
          <textarea id="message" name="message" rows="6" placeholder="Tulis pesan Anda di sini" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 resize-none" required></textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Kirim</button>
      </form>
    </div>
  </section>

  <script>
    function sendMessage() {
      const name =document.getElementById("name").value;
      const email = document.getElementById("email").value;
      const message = document.getElementById("message").value;
    
      const url = "https://api.whatsapp.com/send?phone=6285157150404&text=Halo%20Admin%2C%0ASaya%20%22"+ name +"%22%0Aemail%20%22"+ email +"%22%0A%0A%22"+ message +"%22"
    
     window.open(url);
    }

  </script>

  <!-- Location Section -->
  <section class="bg-violet-600 text-white py-16 text-center">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-2xl font-bold mb-4 text-white-900">Our Location</h2>
      <div class="w-full h-[600px]">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.919377532506!2d108.32868217475927!3d-7.14941309285492!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f45e72bc129ff%3A0x5e76e295f6486f5f!2sRevolt%20game!5e1!3m2!1sen!2sid!4v1745658122835!5m2!1sen!2sid" 
          class="w-full h-full rounded-lg"
          style="border:0;"
          allowfullscreen=""
          loading="lazy"
        ></iframe>
      </div>
    </div>
  </section>  

<?php include 'includes/footer.php'; ?>

</body>
</html>
