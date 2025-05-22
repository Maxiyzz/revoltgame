// tombol submit
    document.getElementById('submit-btn').addEventListener('click', () => {
        const nama = document.getElementById('input-name').value.trim();
        const telp = document.getElementById('input-phone').value.trim();
        const durasi = parseInt(document.getElementById('input-days').value);
        const produk = produkList[currentIndex]; // Menggunakan produk dari currentIndex
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

        fetch('process_booking.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(bookingData),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect ke halaman pembayaran atau booking berhasil
                window.location.href = "konfirmasi_pesanan.php?booking_id=" + data.booking_id;
                // Atau window.location.href = "booking_berhasil.php?booking_id=" + data.booking_id;
            } else {
                alert('Terjadi kesalahan saat memproses booking: ' + data.error);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Terjadi kesalahan jaringan.');
        });
    });