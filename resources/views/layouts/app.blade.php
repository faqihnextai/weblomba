<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Pemenang')</title>
    <link rel="icon" href="{{ asset('flag_14009974.png') }}" type="image/x-icon">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Warna abu-abu muda */
        }
        /* Menyembunyikan elemen secara default untuk navigasi */
        .hidden-content {
            display: none;
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header dengan Hamburger Menu -->
    <header class="w-full max-w-2xl bg-white p-4 rounded-lg shadow-lg mb-8 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Aplikasi Pemenang</h1>
        <!-- Hamburger Button (Visible on small screens) -->
        <button id="hamburger-button" class="md:hidden p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <!-- Desktop Navigation (Hidden on small screens) -->
        <nav class="hidden md:flex flex-wrap justify-center gap-4">
            <a href="{{ route('form.pemenang') }}" id="nav-form-pemenang-desktop" class="px-6 py-3 rounded-lg font-semibold transition duration-300 ease-in-out transform hover:scale-105 bg-gray-200 text-gray-700 hover:bg-blue-100">
                Form Pemenang
            </a>
            <a href="{{ route('daftar.pemenang') }}" id="nav-pemenang-desktop" class="px-6 py-3 rounded-lg font-semibold transition duration-300 ease-in-out transform hover:scale-105 bg-gray-200 text-gray-700 hover:bg-blue-100">
                Daftar Pemenang
            </a>
            <a href="{{ route('kocok.klasifikasi') }}" id="nav-kocok-klasifikasi-desktop" class="px-6 py-3 rounded-lg font-semibold transition duration-300 ease-in-out transform hover:scale-105 bg-gray-200 text-gray-700 hover:bg-blue-100">
                Kocok Klasifikasi
            </a>
        </nav>
    </header>

    <!-- Mobile Menu Overlay (Hidden by default) -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

    <!-- Mobile Menu (Off-canvas, hidden by default) -->
    <div id="mobile-menu" class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg z-50 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden">
        <div class="p-4 flex justify-end">
            <button id="close-menu-button" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <nav class="flex flex-col p-4 space-y-2">
            <a href="{{ route('form.pemenang') }}" id="nav-form-pemenang-mobile" class="w-full text-left px-4 py-3 rounded-lg font-semibold transition duration-300 ease-in-out hover:bg-blue-100 text-gray-700">
                Form Pemenang
            </a>
            <a href="{{ route('daftar.pemenang') }}" id="nav-pemenang-mobile" class="w-full text-left px-4 py-3 rounded-lg font-semibold transition duration-300 ease-in-out hover:bg-blue-100 text-gray-700">
                Daftar Pemenang
            </a>
            <a href="{{ route('kocok.klasifikasi') }}" id="nav-kocok-klasifikasi-mobile" class="w-full text-left px-4 py-3 rounded-lg font-semibold transition duration-300 ease-in-out hover:bg-blue-100 text-gray-700">
                Kocok Klasifikasi
            </a>
        </nav>
    </div>

    <!-- Konten spesifik halaman akan di-inject di sini -->
    <main class="flex-grow w-full flex justify-center items-start">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-4 mt-8 text-center w-full max-w-2xl rounded-lg shadow-lg">
        <div class="container mx-auto">
            <p>&copy; 2025 Aplikasi Pemenang. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Hamburger menu elements
            const hamburgerButton = document.getElementById('hamburger-button');
            const closeMenuButton = document.getElementById('close-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

            // Function to toggle mobile menu visibility
            function toggleMobileMenu() {
                mobileMenu.classList.toggle('-translate-x-full'); // Toggles the slide-out effect
                mobileMenuOverlay.classList.toggle('hidden'); // Toggles the overlay visibility
            }

            // Event listeners for hamburger menu
            hamburgerButton.addEventListener('click', toggleMobileMenu);
            closeMenuButton.addEventListener('click', toggleMobileMenu);
            mobileMenuOverlay.addEventListener('click', toggleMobileMenu); // Close menu when clicking overlay

            // Highlight active navigation button based on current route
            const currentPath = window.location.pathname;

            const navLinks = {
                'nav-form-pemenang-desktop': '{{ route("form.pemenang", [], false) }}',
                'nav-pemenang-desktop': '{{ route("daftar.pemenang", [], false) }}',
                'nav-kocok-klasifikasi-desktop': '{{ route("kocok.klasifikasi", [], false) }}',
                'nav-form-pemenang-mobile': '{{ route("form.pemenang", [], false) }}',
                'nav-pemenang-mobile': '{{ route("daftar.pemenang", [], false) }}',
                'nav-kocok-klasifikasi-mobile': '{{ route("kocok.klasifikasi", [], false) }}',
            };

            for (const id in navLinks) {
                const element = document.getElementById(id);
                if (element) {
                    // Check if current path starts with the link's href
                    // This handles cases like '/' for form.pemenang
                    if (currentPath === navLinks[id] || (navLinks[id] === '/' && currentPath === '/')) {
                        if (id.includes('desktop')) {
                            element.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-blue-100');
                            element.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                        } else { // mobile
                            element.classList.remove('text-gray-700', 'hover:bg-blue-100');
                            element.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                        }
                    }
                }
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
