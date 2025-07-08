<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../flag_14009974.png" type="image/x-icon">
    <title>Daftarkan Lomba Baru</title>
    
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
<body class="flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-blue-700 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/admin" class="text-white text-2xl font-bold">Admin Panel</a>

            <!-- Hamburger menu button for mobile -->
            <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Desktop menu -->
            <ul class="hidden md:flex space-x-6">
                <li><a href="/admin" class="text-white hover:text-blue-200 transition duration-200">Dashboard</a></li>
                <li><a href="/admin/lomba/buat" class="text-white hover:text-blue-200 transition duration-200">Daftarkan Lomba</a></li>
                <li><a href="/admin/pemenang" class="text-white hover:text-blue-200 transition duration-200">Pemenang</a></li>
            </ul>
        </div>

        <!-- Mobile menu content (hidden by default) -->
        <div id="mobile-menu" class="hidden md:hidden px-4 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="/admin" class="block text-white hover:bg-blue-600 px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
            <a href="/admin/lomba/buat" class="block text-white hover:bg-blue-600 px-3 py-2 rounded-md text-base font-medium">Daftarkan Lomba</a>
            <a href="/admin/pemenang" class="block text-white hover:bg-blue-600 px-3 py-2 rounded-md text-base font-medium">Pemenang</a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="flex-grow flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md border border-gray-200">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Daftarkan Lomba Baru</h2>

            <form action="{{ route('admin.lomba.store') }}" method="POST">
                @csrf

                <!-- Nama Lomba -->
                <div class="mb-5">
                    <label for="nama_lomba" class="block text-gray-700 text-sm font-semibold mb-2">Nama Lomba:</label>
                    <input type="text" id="nama_lomba" name="nama_lomba"
                           class="shadow-sm appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                           placeholder="Masukkan nama lomba (contoh: Lomba Mewarnai)" required>
                </div>

                <!-- Kategori Kelas Lomba (Multi-select Checkboxes) -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Kategori Kelas Lomba:</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="kategori_kelas[]" value="rendah" class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Rendah</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="kategori_kelas[]" value="tinggi" class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Tinggi</span>
                        </label>
                    </div>
                    @error('kategori_kelas')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="flex items-center justify-center">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:scale-105">
                        Simpan Lomba
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-4 mt-8 text-center">
        <div class="container mx-auto">
            <p>&copy; 2025 Admin Lomba. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>
