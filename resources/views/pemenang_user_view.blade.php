@extends('layouts.app')

@section('title', 'Daftar Pemenang')

@section('content')
    <div id="content-pemenang" class="bg-white p-8 rounded-lg shadow-xl w-full max-w-2xl border border-gray-200">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Daftar Pemenang</h2>
        <p class="text-gray-600 mb-4 text-center">Berikut adalah daftar pemenang yang telah dicatat.</p>

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
                    {{-- Loop melalui data pemenang --}}
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
                        {{-- Pesan jika tidak ada data pemenang --}}
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
@endsection
