<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PlayStation 4 + TV - REVOLT Game</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-gradient-to-b from-[#0A0F30] to-[#0D1445]">

    <div class="max-w-6xl mx-auto px-4 py-4">
        <a href="../katalog.php" class="flex items-center text-white hover:text-yellow-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Katalog
        </a>
    </div>

    <section class="max-w-6xl mx-auto bg-white rounded-lg shadow-md overflow-hidden flex flex-col md:flex-row">
        <div class="md:w-1/2 h-96">
            <img src="../asset/img/ps4.jpg" alt="PS4 + Televisi" class="w-full h-full object-cover">
        </div>
        <div class="md:w-1/2 p-8 space-y-6">
            <div class="flex justify-between items-start">
                <h2 class="text-3xl font-bold">PlayStation 4+ Televisi</h2>
                <span class="bg-violet-600 text-white text-xs px-3 py-1 rounded-md">4</span>
            </div>
            <div class="flex items-center text-green-600">
                <i class="fas fa-circle-check mr-2"></i>
                <span class="font-medium">Tersedia</span>
            </div>
            <p class="text-gray-700">
                Bundle PS4 dengan game terbaru.
            </p>

            <div>
                <h3 class="font-semibold mb-2">Fitur:</h3>
                <ul class="grid grid-cols-2 gap-2 text-gray-700">
                    <li class="flex items-center"><i class="fas fa-circle-check text-violet-600 mr-2"></i>SSD Ultra-Cepat</li>
                    <li class="flex items-center"><i class="fas fa-circle-check text-violet-600 mr-2"></i>Ray Tracing</li>
                    <li class="flex items-center"><i class="fas fa-circle-check text-violet-600 mr-2"></i>Haptic Feedback</li>
                    <li class="flex items-center"><i class="fas fa-circle-check text-violet-600 mr-2"></i>4K Gaming</li>
                    <li class="flex items-center"><i class="fas fa-circle-check text-violet-600 mr-2"></i>Backward Compatibility</li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold mb-2">Game Populer:</h3>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">God of War Ragnarök</span>
                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">Horizon Forbidden West</span>
                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">Spider-Man: Miles Morales</span>
                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">Demon's Souls</span>
                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">Ratchet &amp; Clank: Rift Apart</span>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Harga Sewa</p>
                    <p class="text-2xl font-bold text-violet-700">Rp 60.000<span class="text-sm font-normal text-gray-600">/hari</span></p>
                </div>
                <a href="#" onclick="
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        alert('Silakan daftar atau login untuk melakukan pemesanan.');
                        window.location.href = '../auth/login.php';
                        return false;
                    <?php else: ?>
                        window.location.href = '../booking/booking.php';
                        return true;
                    <?php endif; ?>
                " class="bg-violet-600 text-white px-6 py-3 rounded-md hover:bg-violet-700 transition">Sewa Sekarang</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg flex flex-col items-center text-gray-700">
                    <i class="fas fa-calendar-check text-violet-600 text-2xl mb-2"></i>
                    <p class="font-semibold">Booking Mudah</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg flex flex-col items-center text-gray-700">
                    <i class="fas fa-clock text-violet-600 text-2xl mb-2"></i>
                    <p class="font-semibold">Sewa Fleksibel</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg flex flex-col items-center text-gray-700">
                    <i class="fas fa-gamepad text-violet-600 text-2xl mb-2"></i>
                    <p class="font-semibold">Kondisi Premium</p>
                </div>
            </div>
        </div>
    </section>

</body>
</html>