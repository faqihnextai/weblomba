<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../flag_14009974.png" type="image/x-icon">
    <title>Admin Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Light gray background */
        }
        /* Custom styles for the FAB animation */
        .fab-container {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 50; /* Ensure it's above other content */
        }
        .fab-button {
            width: 64px; /* Larger button */
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem; /* Large plus sign */
            line-height: 1; /* Adjust line height for centering */
            transition: transform 0.3s ease-in-out;
        }
        .fab-button:hover {
            transform: scale(1.1);
        }
        .fab-tooltip {
            position: absolute;
            bottom: calc(100% + 0.75rem); /* Position above the button with some space */
            right: 0;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out, visibility 0.3s ease-in-out;
            pointer-events: none; /* Allow clicks to pass through when hidden */
        }
        .fab-container:hover .fab-tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
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
    <div class="flex-grow container mx-auto mt-8 p-6 bg-white rounded-lg shadow-xl border border-gray-200">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Selamat Datang di Dashboard Admin!</h2>
        <p class="text-gray-600 mb-4">Di sini Anda dapat mengelola data lomba dan pemenang.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <!-- Card 1: Total Pemenang -->
            <div class="bg-blue-100 p-6 rounded-lg shadow-md border border-blue-200">
                <h3 class="text-xl font-semibold text-blue-800 mb-2">Total Pemenang</h3>
                <p class="text-4xl font-bold text-blue-700">{{ $totalPemenang }}</p>
                <p class="text-sm text-blue-600 mt-2">Pemenang yang tercatat</p>
            </div>

            <!-- Card 2: Total Lomba -->
            <div class="bg-green-100 p-6 rounded-lg shadow-md border border-green-200">
                <h3 class="text-xl font-semibold text-green-800 mb-2">Total Lomba</h3>
                <p class="text-4xl font-bold text-green-700">{{ $totalLomba }}</p>
                <p class="text-sm text-green-600 mt-2">Lomba yang terdaftar</p>
            </div>
        </div>
    </div>

    <!-- Floating Action Button (FAB) for "Daftarkan Lomba" -->
    <div class="fab-container group">
        <a href="/admin/lomba/buat"
           class="fab-button bg-red-600 text-white rounded-full shadow-lg shadow-black hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
            +
        </a>
        <div class="fab-tooltip bg-red-600 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow-lg shadow-black">
            Daftarkan Lomba
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
