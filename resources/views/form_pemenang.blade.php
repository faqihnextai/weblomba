@extends('layouts.app')

@section('title', 'Form Pencatatan Pemenang')

@section('content')
    <div id="content-form-pemenang" class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md border border-gray-200">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Form Pencatatan Pemenang</h2>

        {{-- Pesan sukses/error --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const namaLombaSelect = document.getElementById('nama_lomba');
        const kelasLombaSelect = document.getElementById('kelas_lomba');

        function updateKelasLombaOptions() {
            kelasLombaSelect.innerHTML = '<option value="">Pilih Kelas Lomba</option>';

            const selectedOption = namaLombaSelect.options[namaLombaSelect.selectedIndex];
            const kategoriKelasJson = selectedOption ? selectedOption.dataset.kategoriKelas : null;

            if (kategoriKelasJson) {
                try {
                    const kategoriKelasArray = JSON.parse(kategoriKelasJson);
                    kategoriKelasArray.forEach(kategori => {
                        const option = document.createElement('option');
                        option.value = kategori;
                        option.textContent = kategori.charAt(0).toUpperCase() + kategori.slice(1);
                        kelasLombaSelect.appendChild(option);
                    });

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
                kelasLombaSelect.setAttribute('disabled', 'disabled');
                kelasLombaSelect.classList.add('bg-gray-100', 'cursor-not-allowed');
                kelasLombaSelect.classList.remove('bg-white', 'cursor-pointer');
            }
        }

        // Panggil saat halaman dimuat untuk inisialisasi form
        updateKelasLombaOptions();

        // Panggil setiap kali pilihan nama lomba berubah
        namaLombaSelect.addEventListener('change', updateKelasLombaOptions);
    });
</script>
@endsection
