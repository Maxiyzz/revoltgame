# 🎮 Sistem Informasi Rental PlayStation - REVOLT Game

## 📬Pengembang
Muhammad Syamsul Ma'arif_237006160
Fadil Darmawan_237006164

## 📌 Deskripsi Proyek
Sistem informasi ini dirancang untuk memudahkan proses penyewaan konsol **PlayStation** oleh pengguna. 
Juga sebagai Tugas Akhir Syarat lulus Mata kuliah Sistem Informasi, Program studi Informatika Fakultas Teknik Ubiversitas Siliwangi
 Dengan sistem ini, pengguna dapat:

- Melihat katalog PlayStation yang tersedia
- Melihat detail setiap produk
- Melakukan pemesanan (booking)
- Melihat riwayat pemesanan dan pembayaran

Sistem juga mencakup fitur autentikasi pengguna serta kemungkinan fitur **manajemen pembayaran** untuk admin.

---

## 🚀 Fitur Utama

- **🗂️ Katalog Produk**  
  Menampilkan daftar PlayStation yang tersedia untuk disewa.

- **ℹ️ Detail Produk**  
  Menyajikan informasi lengkap tentang setiap konsol (seri, harga sewa, ketersediaan, dll.).

- **🛒 Pemesanan (Booking)**  
  Pengguna yang telah terdaftar dapat melakukan pemesanan penyewaan.

- **🔐 Autentikasi Pengguna**  
  Fitur registrasi dan login untuk pengguna.

- **💳 Riwayat Pembayaran**  
  Menampilkan daftar transaksi/pembayaran yang telah dilakukan oleh pengguna.

- **⚙️ (Opsional) Manajemen Pembayaran**  
  Admin dapat mengelola status pembayaran dan memverifikasi pemesanan.

---

## 🧰 Teknologi yang Digunakan

| Teknologi       | Keterangan                            |
|-----------------|----------------------------------------|
| **HTML**        | Struktur dasar antarmuka               |
| **Tailwind CSS**| Styling antarmuka secara responsif     |
| **JavaScript**  | Interaktivitas halaman (opsional)      |
| **PHP**         | Pemrosesan server-side                 |
| **MySQL**       | Database penyimpanan data              |
| **Font Awesome**| Ikon dan elemen visual tambahan        |

---

## 🛠️ Cara Menjalankan Proyek (Untuk Pengembangan)

1. **Instalasi XAMPP**  
   Pastikan Anda telah menginstal [XAMPP](https://www.apachefriends.org/index.html) atau aplikasi serupa.

2. **Pindahkan Proyek ke Direktori Web Server**  
   Salin folder proyek ini ke direktori `htdocs` (jika menggunakan XAMPP).

3. **Jalankan Server Lokal**  
   Buka **XAMPP Control Panel** dan aktifkan:
   - Apache
   - MySQL

4. **Akses Aplikasi**  
   Buka browser dan kunjungi:

5. **Impor Database**  
- Akses `phpMyAdmin` via `http://localhost/phpmyadmin`
- Buat database baru, misalnya: `revolt_db`
- Impor file `.sql` dari folder `/db` (jika tersedia)

---

## 📁 Struktur Direktori
/revolt-game/
│
├── index.php → Halaman utama
├── katalog.php → Daftar semua PlayStation
├── kontak.php → informasi kontak
├── dashboard.php → dashboard admin
├── dashboard_user.php → dashboard
├── riwayat_pembayaran.php → riwayat pembayaran user
├── hapus_riwayat_sewa.php → menghapus riwayat sewa user
│
📦admin
 ┣ 📜admin_login.php
 ┣ 📜admin_login_process.php
 ┣ 📜daftar_user.php
 ┣ 📜data_ps.php
 ┣ 📜kelola_booking.php
 ┣ 📜laporan_transaksi.php
 ┗ 📜sidebar_admin.php

 📦asset
 ┣ 📂css
 ┃ ┣ 📜animations.css
 ┃ ┗ 📜style.css
 ┣ 📂img
 ┃ ┣ 📜ade_rudi.jpg
 ┃ ┣ 📜background.jpg
 ┃ ┣ 📜cerita-kami.jpg
 ┃ ┣ 📜controler.jpg
 ┃ ┣ 📜fadil.jpg
 ┃ ┣ 📜logo.png
 ┃ ┣ 📜ps2.jpg
 ┃ ┣ 📜ps2det.jpg
 ┃ ┣ 📜ps3.jpg
 ┃ ┣ 📜ps4.jpg
 ┃ ┣ 📜revolt.jpg
 ┃ ┗ 📜syamsul.jpg
 ┣ 📂js
 ┃ ┣ 📜auth.js
 ┃ ┣ 📜booking.js
 ┃ ┗ 📜script.js
 ┗ 📂System_Information
 ┃ ┣ 📜use case diagram.png
 ┃ ┗ 📜use case revolt game.png
📦auth
 ┣ 📜login.php
 ┣ 📜logout.php
 ┣ 📜process_login.php
 ┣ 📜process_register.php
 ┗ 📜register.php
 📦booking
 ┣ 📜booking.php
 ┣ 📜konfirmasi_booking.php
 ┗ 📜process_booking.php
 📦Db
 ┗ 📜revolt-game.sql
 📦includes
 ┣ 📜footer.php
 ┣ 📜header.php
 ┗ 📜koneksi.php
 📦produk
 ┣ 📜detail1.php
 ┣ 📜detail2.php
 ┣ 📜detail3.php
 ┣ 📜detail4.php
 ┣ 📜detail5.php
 ┗ 📜detail6.php



> Proyek ini dikembangkan untuk keperluan edukasi dan dapat dikembangkan lebih lanjut untuk kebutuhan produksi.
