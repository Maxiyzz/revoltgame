<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin | Revolt Game</title>
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
            <h1 class="text-white text-2xl font-bold">Revolt Game Admin</h1>
        </div>


        <div class="mt-4 text-center">
            <a href="../auth/login.php" class="inline-block text-sm text-white-300 font-semibold py-2 px-4 rounded-md bg-yellow-100 border border-yellow-300 hover:bg-yellow-200">
                Login sebagai User
            </a>
        </div>

        <h2 class="text-white text-xl font-bold mb-4">Selamat Datang Admin</h2>

        <form action="admin_login_process.php" method="post">
            <div class="mb-4">
                <input type="text" name="username" placeholder="Username *" class="w-full p-3 rounded bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4 relative">
                <input type="password" name="password" placeholder="Password *" class="w-full p-3 rounded bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-center justify-between mb-4">
                <label class="text-gray-400 flex items-center">
                    <input type="checkbox" class="mr-2"> Remember me
                </label>
                <a href="#" class="text-blue-400 text-sm hover:underline">Lupa password?</a>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 py-3 rounded text-white font-semibold">Login</button>
        </form>

        <p class="text-gray-500 text-center text-xs mt-4">
            Revolt Game — Premium PlayStation Rental Service
        </p>

        <a href="../index.php" class="text-violet-500 hover:underline text-sm">
            ← Kembali ke Beranda
        </a>
    </div>

</body>
</html>