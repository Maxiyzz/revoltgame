<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex">

  <!-- Toggle Button (visible on small screens) -->
  <button id="toggleSidebar" class="sm:hidden fixed top-4 left-4 z-30 bg-gray-800 text-white p-2 rounded-md">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Sidebar -->
  <div id="sidebar" class="bg-gray-800 text-white w-60 flex-shrink-0 transform -translate-x-full sm:translate-x-0 transition-transform duration-300 ease-in-out fixed top-0 left-0 h-full z-20">
    <div class="p-4">
      <h1 class="text-xl font-semibold">Admin Panel</h1>
    </div>
    <ul>
      <li class="p-2 hover:bg-gray-700">
        <a href="../dashboard.php" class="block text-sm"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a>
      </li>
      <li class="p-2 hover:bg-gray-700">
        <a href="data_ps.php" class="block text-sm"><i class="fas fa-gamepad mr-2"></i> Data PlayStation</a>
      </li>
      <li class="p-2 hover:bg-gray-700">
        <a href="daftar_user.php" class="block text-sm"><i class="fas fa-users mr-2"></i> Daftar User</a>
      </li>
      <li class="p-2 bg-gray-700">
        <a href="laporan_transaksi.php" class="block text-sm"><i class="fas fa-chart-bar mr-2"></i> Laporan Transaksi</a>
      </li>
      <li class="p-2 hover:bg-gray-700">
        <a href="kelola_booking.php" class="block text-sm"><i class="fas fa-calendar-alt mr-2"></i> Kelola Booking</a>
      </li>
      <li class="p-2 hover:bg-gray-700">
        <a href="../auth/logout.php" class="block text-sm"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
      </li>
    </ul>
  </div>

  <!-- Main Content Placeholder -->
  <div class="flex-1 p-4 sm:ml-60">
    <h2 class="text-2xl font-semibold">Selamat datang di Admin Panel</h2>
    <!-- Konten lainnya di sini -->
  </div>

  <!-- Script toggle -->
  <script>
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleButton.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });
  </script>
</body>
</html>
    