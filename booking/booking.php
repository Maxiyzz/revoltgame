<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Penyewaan – REVOLT Game</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="max-w-6xl mx-auto px-4 py-4">
        <a href="../katalog.php" class="text-gray-600 hover:text-gray-800">&larr; Kembali ke Katalog</a>
    </div>

    <div class="max-w-6xl mx-auto px-4 md:flex md:space-x-8">

        <div class="bg-white rounded-lg shadow-md p-6 md:w-2/3">
            <h2 class="text-2xl font-bold mb-6">Form Penyewaan</h2>
            <div class="space-y-4">
                <div>
                    <label class="block font-medium mb-1">Nama Lengkap</label>
                    <input type="text" id="input-name" class="w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Nama Lengkap">
                </div>
                <div>
                    <label class="block font-medium mb-1">Nomor WhatsApp</label>
                    <input type="text" id="input-phone" class="w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Contoh: 081234567890">
                </div>
                <div>
                    <label class="block font-medium mb-1">Durasi Sewa (hari)</label>
                    <input type="number" id="input-days" class="w-full border border-gray-300 rounded-md px-3 py-2" value="1" min="1">
                </div>
                <div>
                    <label class="block font-medium mb-1">Metode Pembayaran</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" class="border border-gray-300 rounded-md py-2">DANA</button>
                        <button type="button" class="border border-gray-300 rounded-md py-2">GoPay</button>
                        <button type="button" class="border border-gray-300 rounded-md py-2">OVO</button>
                        <button type="button" class="border border-gray-300 rounded-md py-2">Transfer Bank</button>
                    </div>
                </div>
            </div>
            <button id="submit-btn" class="mt-6 w-full bg-violet-600 text-white py-3 rounded-md hover:bg-violet-700 transition">
                Lanjutkan ke Pembayaran
            </button>
        </div>

        <aside class="bg-white rounded-lg shadow-md p-6 mt-8 md:mt-0 md:w-1/3">
            <div class="flex justify-between items-center mb-4">
                <button id="prev-btn" class="text-gray-500 hover:text-gray-700">&larr;</button>
                <h3 class="text-xl font-semibold">Ringkasan Pesanan</h3>
                <button id="next-btn" class="text-gray-500 hover:text-gray-700">&rarr;</button>
            </div>

            <div class="flex items-start gap-4 mb-4">
                <img id="summary-img" src="asset/img/placeholder.jpg" alt="Gambar Produk" class="w-20 h-20 object-cover rounded-md shadow-sm">
                <div>
                    <h4 id="summary-name" class="font-medium">—</h4>
                    <p id="summary-type" class="text-gray-500 text-sm">—</p>
                </div>
            </div>

            <dl class="grid grid-cols-2 gap-y-1 text-sm text-gray-700 mb-4">
                <dt>Harga per hari</dt><dd id="summary-price" class="text-right">—</dd>
                <dt>Durasi</dt><dd id="summary-days" class="text-right">—</dd>
            </dl>

            <hr class="border-gray-200 mb-4">

            <div class="flex items-baseline justify-between mb-6">
                <span class="font-medium">Total</span>
                <span id="summary-total" class="text-lg font-bold text-violet-700">—</span>
            </div>

            <div class="space-y-3">
                <div class="flex items-start gap-3 bg-gray-50 p-3 rounded-md">
                    <i class="fas fa-calendar-check text-violet-600 mt-1"></i>
                    <p class="text-sm text-gray-700">PlayStation akan dikirim setelah pembayaran dikonfirmasi.</p>
                </div>
                <div class="flex items-start gap-3 bg-gray-50 p-3 rounded-md">
                    <i class="fas fa-credit-card text-violet-600 mt-1"></i>
                    <p class="text-sm text-gray-700">Pembayaran via DANA, GoPay, OVO, atau transfer bank.</p>
                </div>
            </div>
        </aside>
    </div>

    <script>
// daftar produk & harga
        const produkList = [
            {id:'ps2-only',     nama:'PlayStation 2 only',      tipe:'PS2', harga:60000,     gambar:'../asset/img/ps2.jpg' },
            {id:'ps2-tv',       nama:'PlayStation 2 + Televisi', tipe:'PS2', harga:100000,    gambar:'../asset/img/ps2.jpg' },
            {id:'ps3-only',     nama:'PlayStation 3 only',      tipe:'PS3', harga:60000,     gambar:'../asset/img/ps3.jpg' },
            {id:'ps3-tv',       nama:'PlayStation 3 + Televisi', tipe:'PS3', harga:200000,   gambar:'../asset/img/ps3.jpg' },
            {id:'ps4-only',     nama:'PlayStation 4 only',      tipe:'PS4', harga:150000,    gambar:'../asset/img/ps4.jpg' },
            {id:'ps4-tv',       nama:'PlayStation 4 + Televisi', tipe:'PS4', harga:250000,    gambar:'../asset/img/ps4.jpg' },
        ];

        // Elemen-elemen ringkasan & form
        const imgEl     = document.getElementById('summary-img');
        const nameEl    = document.getElementById('summary-name');
        const typeEl    = document.getElementById('summary-type');
        const priceEl   = document.getElementById('summary-price');
        const daysEl    = document.getElementById('summary-days');
        const totalEl   = document.getElementById('summary-total');
        const inputDays = document.getElementById('input-days');

        const prevBtn   = document.getElementById('prev-btn');
        const nextBtn   = document.getElementById('next-btn');

        // Tentukan produk awal dari URL param atau index 0
        const params  = new URLSearchParams(location.search);
        let currentIndex = produkList.findIndex(p => p.id === params.get('product'));
        if (currentIndex < 0) currentIndex = 0;

        // Render ringkasan sesuai index & durasi
        function renderSummary(durasi = 1) {
            const produk = produkList[currentIndex];
            imgEl.src   = produk.gambar;
            nameEl.textContent  = produk.nama;
            typeEl.textContent  = produk.tipe;
            priceEl.textContent = `Rp ${produk.harga.toLocaleString('id')}`;
            daysEl.textContent  = `${durasi} hari`;
            totalEl.textContent = `Rp ${(produk.harga * durasi).toLocaleString('id')}`;
        }

        // Navigasi Prev / Next
        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + produkList.length) % produkList.length;
            renderSummary(parseInt(inputDays.value) || 1);
        });
        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % produkList.length;
            renderSummary(parseInt(inputDays.value) || 1);
        });

        // Update total saat durasi berubah
        inputDays.addEventListener('input', e => {
            const d = Math.max(1, parseInt(e.target.value) || 1);
            renderSummary(d);
        });

        // Initial render
        renderSummary(parseInt(inputDays.value) || 1);

// tombol submit
    document.getElementById('submit-btn').addEventListener('click', () => {
        const nama = document.getElementById('input-name').value.trim();
        const telp = document.getElementById('input-phone').value.trim();
        const durasi = parseInt(document.getElementById('input-days').value);
        const produk = produkList[currentIndex];
        const totalHarga = produk.harga * durasi;

        if (!nama || !telp || isNaN(durasi) || durasi < 1) {
            alert("Silakan lengkapi data terlebih dahulu!");
            return;
        }

        const bookingData = {
            nama: nama,
            telepon: telp,
            durasi: durasi,
            produk_nama: produk.nama,
            harga_per_hari: produk.harga,
            total: totalHarga
        };

        console.log('Data yang dikirim:', bookingData);

        fetch('process_booking.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(bookingData),
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                window.location.href = "konfirmasi_booking.php?booking_id=" + data.booking_id;
            } else {
                alert('Terjadi kesalahan saat memproses booking: ' + data.error);
            }
        })
        .catch((error) => {
            console.error('Error fetch:', error);
            alert('Terjadi kesalahan jaringan.');
        });
    });

    </script>
</body>
</html>