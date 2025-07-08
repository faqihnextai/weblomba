<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pencatatan Pemenang</title>
    <link rel="icon" href="flag_14009974.png" type="image/x-icon">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Warna abu-abu muda */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md border border-gray-200">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Form Pencatatan Pemenang</h2>

        <form action="{{ route('user.submit.pemenang') }}" method="POST">
            <!-- CSRF Token untuk keamanan Laravel -->
            @csrf

            <!-- Nama Lomba (sekarang dropdown) -->
            <div class="mb-5">
                <label for="nama_lomba" class="block text-gray-700 text-sm font-semibold mb-2">Nama Lomba:</label>
                <select id="nama_lomba" name="nama_lomba"
                        class="shadow-sm appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                        required>
                    <option value="">Pilih Nama Lomba</option>
                    @foreach ($lombas as $lomba)
                        {{-- Menyimpan kategori_kelas sebagai JSON string di data attribute --}}
                        <option value="{{ $lomba->id }}" data-kategori-kelas='@json($lomba->kategori_kelas)'>
                            {{ $lomba->nama_lomba }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Pilih lomba yang sudah didaftarkan admin.</p>
            </div>

            <!-- Kelas Lomba (Rendah/Tinggi) - Akan otomatis terisi berdasarkan Nama Lomba yang dipilih -->
            <div class="mb-5">
                <label for="kelas_lomba" class="block text-gray-700 text-sm font-semibold mb-2">Kelas Lomba:</label>
                <select id="kelas_lomba" name="kelas_lomba"
                        class="shadow-sm appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                        required>
                    <option value="">Pilih Kelas Lomba</option>
                    {{-- Opsi akan ditambahkan secara dinamis oleh JavaScript --}}
                </select>
                <p class="text-xs text-gray-500 mt-1">Kelas lomba akan otomatis terisi setelah memilih Nama Lomba.</p>
            </div>

            <!-- Nama Pemenang -->
            <div class="mb-5">
                <label for="nama_pemenang" class="block text-gray-700 text-sm font-semibold mb-2">Nama Pemenang:</label>
                <input type="text" id="nama_pemenang" name="nama_pemenang"
                       class="shadow-sm appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                       placeholder="Nama lengkap pemenang" required>
            </div>

            <!-- Kelas Pemenang -->
            <div class="mb-5">
                <label for="kelas_pemenang" class="block text-gray-700 text-sm font-semibold mb-2">Kelas Pemenang:</label>
                <input type="text" id="kelas_pemenang" name="kelas_pemenang"
                       class="shadow-sm appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                       placeholder="Contoh: SD Kelas 3" required>
            </div>

            <!-- Point Pemenang -->
            <div class="mb-6">
                <label for="point_pemenang" class="block text-gray-700 text-sm font-semibold mb-2">Point Pemenang:</label>
                <input type="number" id="point_pemenang" name="point_pemenang"
                       class="shadow-sm appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                       placeholder="Masukkan point pemenang (angka)" min="0" required>
            </div>

            <!-- Tombol Submit -->
            <div class="flex items-center justify-center">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:scale-105">
                    Catat Pemenang
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const namaLombaSelect = document.getElementById('nama_lomba');
            const kelasLombaSelect = document.getElementById('kelas_lomba');

            function updateKelasLombaOptions() {
                // Bersihkan opsi yang ada
                kelasLombaSelect.innerHTML = '<option value="">Pilih Kelas Lomba</option>';

                const selectedOption = namaLombaSelect.options[namaLombaSelect.selectedIndex];
                const kategoriKelasJson = selectedOption.dataset.kategoriKelas;

                if (kategoriKelasJson) {
                    try {
                        const kategoriKelasArray = JSON.parse(kategoriKelasJson);

                        // Tambahkan opsi berdasarkan kategori yang tersedia
                        kategoriKelasArray.forEach(kategori => {
                            const option = document.createElement('option');
                            option.value = kategori;
                            option.textContent = kategori.charAt(0).toUpperCase() + kategori.slice(1); // Uppercase first letter
                            kelasLombaSelect.appendChild(option);
                        });

                        // Jika hanya ada satu opsi, pilih otomatis
                        if (kategoriKelasArray.length === 1) {
                            kelasLombaSelect.value = kategoriKelasArray[0];
                        }

                        kelasLombaSelect.removeAttribute('disabled');
                        kelasLombaSelect.classList.remove('bg-gray-100', 'cursor-not-allowed');
                        kelasLombaSelect.classList.add('bg-white', 'cursor-pointer');
                    } catch (e) {
                        console.error("Error parsing JSON for kategori_kelas:", e);
                        kelasLombaSelect.setAttribute('disabled', 'disabled');
                        kelasLombaSelect.classList.add('bg-gray-100', 'cursor-not-allowed');
                        kelasLombaSelect.classList.remove('bg-white', 'cursor-pointer');
                    }
                } else {
                    // Jika tidak ada lomba yang dipilih, atau tidak ada kategori
                    kelasLombaSelect.setAttribute('disabled', 'disabled');
                    kelasLombaSelect.classList.add('bg-gray-100', 'cursor-not-allowed');
                    kelasLombaSelect.classList.remove('bg-white', 'cursor-pointer');
                }
            }

            // Panggil saat halaman dimuat untuk inisialisasi
            updateKelasLombaOptions();

            // Panggil setiap kali pilihan nama lomba berubah
            namaLombaSelect.addEventListener('change', updateKelasLombaOptions);
        });
    </script>
</body>
</html>
