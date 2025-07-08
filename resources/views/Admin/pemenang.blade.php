<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemenang - Admin</title>
    <link rel="icon" href="../flag_14009974.png" type="image/x-icon">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Light gray background */
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <!-- Navbar (sama seperti dashboard admin) -->
    <nav class="bg-blue-700 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/admin" class="text-white text-2xl font-bold">Admin Panel</a>
            <ul class="flex space-x-6">
                <li><a href="/admin" class="text-white hover:text-blue-200 transition duration-200">Dashboard</a></li>
                <li><a href="/admin/lomba/buat" class="text-white hover:text-blue-200 transition duration-200">Daftarkan Lomba</a></li>
                <li><a href="/admin/pemenang" class="text-white hover:text-blue-200 transition duration-200">Pemenang</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="flex-grow container mx-auto mt-8 p-6 bg-white rounded-lg shadow-xl border border-gray-200">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Daftar Pemenang</h2>
        <p class="text-gray-600 mb-4">Berikut adalah daftar pemenang yang telah dicatat.</p>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-8">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Nama Lomba
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Kategori Lomba
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Nama Pemenang
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Kelas Pemenang
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Point Pemenang
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemenangs as $pemenang)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $pemenang->lomba->nama_lomba ?? 'Lomba Tidak Ditemukan' }}
                            </th>
                            <td class="py-4 px-6">
                                {{ ucfirst($pemenang->kelas_lomba) }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $pemenang->nama_pemenang }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $pemenang->kelas_pemenang }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $pemenang->point_pemenang }}
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td colspan="5" class="py-4 px-6 text-center text-gray-500">
                                Belum ada data pemenang yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-4 mt-8 text-center">
        <div class="container mx-auto">
            <p>&copy; 2025 Admin Lomba. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
