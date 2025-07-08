@extends('layouts.app')

@section('title', 'Kocok Klasifikasi')

@section('content')
    <div id="content-kocok-klasifikasi" class="bg-white p-8 rounded-lg shadow-xl w-full max-w-2xl border border-gray-200 text-center flex flex-col items-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Kocok Klasifikasi</h2>
        <p class="text-gray-600 mb-4">Masukkan nama-nama di bawah ini (satu per baris), lalu putar roda!</p>

        <div class="w-full max-w-md mb-6">
            <textarea id="namesInput" rows="6" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh:&#10;Peserta A&#10;Peserta B&#10;Peserta C&#10;Peserta D"></textarea>
            <button id="addNamesButton" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:scale-105">
                Tambahkan ke Roda
            </button>
            <button id="clearNamesButton" class="mt-2 w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:scale-105">
                Bersihkan Roda
            </button>
        </div>

        <div class="relative w-full max-w-lg mb-8">
            <canvas id="wheelCanvas" class="bg-gray-100 border border-gray-300 rounded-full shadow-inner mx-auto" width="500" height="500"></canvas>
            <button id="spinButton" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-full shadow-lg focus:outline-none focus:ring-4 focus:ring-green-300 transition duration-300 ease-in-out transform hover:scale-105 text-xl z-10">
                PUTAR!
            </button>
            <!-- Winner display is now handled by separate cards below -->
        </div>

        <div id="winnerCardContainer" class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-4 w-full max-w-xl hidden">
            <div id="winnerCard1" class="bg-blue-100 text-blue-800 font-bold text-xl p-4 rounded-lg shadow-md flex-1 min-w-[150px] text-center">
                <!-- Pemenang 1 akan ditampilkan di sini -->
            </div>
            <span class="text-3xl font-bold text-gray-700">VS</span>
            <div id="winnerCard2" class="bg-blue-100 text-blue-800 font-bold text-xl p-4 rounded-lg shadow-md flex-1 min-w-[150px] text-center">
                <!-- Pemenang 2 akan ditampilkan di sini -->
            </div>
        </div>

        <p id="noNamesMessage" class="text-red-500 font-semibold mt-4 hidden">Tidak ada nama untuk diputar. Harap masukkan nama di kolom di atas.</p>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('wheelCanvas');
        const ctx = canvas.getContext('2d');
        const namesInput = document.getElementById('namesInput');
        const addNamesButton = document.getElementById('addNamesButton');
        const clearNamesButton = document.getElementById('clearNamesButton');
        const spinButton = document.getElementById('spinButton');
        const winnerCardContainer = document.getElementById('winnerCardContainer');
        const winnerCard1 = document.getElementById('winnerCard1');
        const winnerCard2 = document.getElementById('winnerCard2');
        const noNamesMessage = document.getElementById('noNamesMessage');

        let segments = []; // Array untuk menyimpan segmen roda
        let originalNames = []; // Menyimpan daftar nama asli dari input
        const colors = [ // Warna untuk segmen roda
            '#FFDDC1', '#FFABAB', '#FFC3A0', '#FF677D', '#D4A5A5',
            '#88B04B', '#F7CAC9', '#92A8D1', '#034F84', '#F7786B',
            '#C94C4C', '#FF8C94', '#5B5EA6', '#9B2335', '#36486B',
            '#E1B860', '#C3BABA', '#8A2BE2', '#7FFF00', '#DDA0DD'
        ];

        let currentRotation = 0; // Rotasi roda saat ini
        let isSpinning = false; // Status putaran roda
        let spinVelocity = 0; // Kecepatan putaran

        // Fungsi untuk menggambar roda
        function drawWheel() {
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Bersihkan canvas
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;
            const radius = Math.min(centerX, centerY) * 0.9; // Radius roda

            if (segments.length === 0) {
                // Gambar lingkaran abu-abu jika tidak ada segmen
                ctx.beginPath();
                ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
                ctx.fillStyle = '#E0E0E0'; // Warna abu-abu terang
                ctx.fill();
                ctx.lineWidth = 2;
                ctx.strokeStyle = '#B0B0B0'; // Warna abu-abu gelap
                ctx.stroke();
                ctx.font = '20px Inter';
                ctx.fillStyle = '#606060';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText('Tambahkan Nama', centerX, centerY);
                return;
            }

            const arcSize = (2 * Math.PI) / segments.length; // Ukuran busur untuk setiap segmen

            for (let i = 0; i < segments.length; i++) {
                const startAngle = currentRotation + i * arcSize;
                const endAngle = startAngle + arcSize;

                ctx.beginPath();
                ctx.moveTo(centerX, centerY);
                ctx.arc(centerX, centerY, radius, startAngle, endAngle);
                ctx.closePath();

                ctx.fillStyle = segments[i].color;
                ctx.fill();
                ctx.lineWidth = 1;
                ctx.strokeStyle = '#FFFFFF'; // Garis pemisah segmen
                ctx.stroke();

                // Gambar teks
                ctx.save();
                ctx.translate(centerX, centerY);
                ctx.rotate(startAngle + arcSize / 2); // Putar ke tengah segmen
                ctx.textAlign = 'right';
                ctx.fillStyle = '#333333';
                ctx.font = 'bold 16px Inter'; // Ukuran font
                ctx.fillText(segments[i].name, radius * 0.85, 0); // Posisikan teks
                ctx.restore();
            }

            // Gambar penunjuk pemenang pertama (segitiga di atas)
            ctx.beginPath();
            ctx.fillStyle = '#333333';
            ctx.moveTo(centerX - 10, centerY - radius - 20);
            ctx.lineTo(centerX + 10, centerY - radius - 20);
            ctx.lineTo(centerX, centerY - radius - 10);
            ctx.closePath();
            ctx.fill();

            // Gambar penunjuk pemenang kedua (segitiga di bawah)
            ctx.beginPath();
            ctx.fillStyle = '#333333';
            ctx.moveTo(centerX - 10, centerY + radius + 20); // Adjusted Y for bottom
            ctx.lineTo(centerX + 10, centerY + radius + 20); // Adjusted Y for bottom
            ctx.lineTo(centerX, centerY + radius + 10);    // Adjusted Y for bottom
            ctx.closePath();
            ctx.fill();
        }

        // Fungsi untuk mengupdate roda berdasarkan input nama
        function updateWheel() {
            originalNames = namesInput.value.split('\n').map(name => name.trim()).filter(name => name !== '');
            segments = originalNames.map((name, index) => ({
                name: name,
                color: colors[index % colors.length] // Siklus warna
            }));

            if (segments.length > 0) {
                noNamesMessage.classList.add('hidden');
                spinButton.disabled = false; // Aktifkan tombol spin
            } else {
                noNamesMessage.textContent = 'Tidak ada nama untuk diputar. Harap masukkan nama di kolom di atas.';
                noNamesMessage.classList.remove('hidden');
                spinButton.disabled = true; // Nonaktifkan tombol spin jika tidak ada nama
            }
            drawWheel();
            winnerCardContainer.classList.add('hidden');
        }

        // Fungsi untuk memutar roda
        function spinWheel() {
            if (isSpinning || segments.length < 2) { // Minimal 2 segmen untuk 2 pemenang
                if (segments.length < 2) {
                    noNamesMessage.textContent = 'Minimal 2 nama diperlukan untuk memutar roda.';
                    noNamesMessage.classList.remove('hidden');
                }
                return;
            }

            isSpinning = true;
            spinButton.style.display = 'none'; // Sembunyikan tombol putar saat berputar
            winnerCardContainer.classList.add('hidden');
            noNamesMessage.classList.add('hidden'); // Sembunyikan pesan error jika ada

            // Pilih segmen pemenang secara acak untuk pointer atas
            const chosenIndex1 = Math.floor(Math.random() * segments.length);
            let chosenIndex2 = -1;

            // Pastikan pemenang kedua berbeda dari pemenang pertama
            if (segments.length > 1) {
                do {
                    chosenIndex2 = Math.floor(Math.random() * segments.length);
                } while (chosenIndex2 === chosenIndex1); // Ulangi sampai indeks berbeda
            } else {
                // Jika hanya ada 1 nama atau kurang, tidak bisa memilih 2 nama berbeda
                chosenIndex2 = chosenIndex1; // Akan sama jika hanya 1 nama
            }

            // Hitung rotasi target untuk segmen pemenang (pointer atas)
            const minRotations = 5; // Minimal 5 putaran penuh
            const arcSize = (2 * Math.PI) / segments.length;
            const targetAngle1 = (2 * Math.PI * minRotations) + (2 * Math.PI - (chosenIndex1 * arcSize));

            // Untuk pointer bawah, kita ingin dia menunjuk ke chosenIndex2
            // Kita perlu menghitung offset rotasi agar chosenIndex2 berada di posisi bawah
            // Posisi bawah adalah targetAngle1 + Math.PI (180 derajat)
            const rotationOffsetForBottomPointer = (chosenIndex2 * arcSize) - Math.PI;
            const finalTargetRotation = targetAngle1 - rotationOffsetForBottomPointer;


            spinVelocity = 0.5; // Kecepatan awal putaran

            let animationFrameId;

            function animateSpin() {
                currentRotation += spinVelocity;
                spinVelocity *= 0.99; // Perlambat putaran (deceleration)

                // Jika kecepatan sangat rendah dan mendekati target, hentikan
                // Kita perlu sedikit toleransi karena floating point
                if (spinVelocity < 0.001 && Math.abs(finalTargetRotation - currentRotation) < 0.01) {
                    isSpinning = false;
                    cancelAnimationFrame(animationFrameId);

                    // Sesuaikan rotasi akhir agar tepat di tengah segmen pemenang (pointer atas)
                    // Ini memastikan roda berhenti tepat di posisi yang diinginkan
                    currentRotation = finalTargetRotation % (2 * Math.PI);
                    if (currentRotation < 0) currentRotation += (2 * Math.PI); // Pastikan positif

                    drawWheel(); // Gambar ulang untuk posisi akhir yang tepat

                    // --- Tentukan Pemenang 1 dan Pemenang 2 ---
                    let winner1 = segments[chosenIndex1].name;
                    let winner2 = segments[chosenIndex2].name;

                    // Tampilkan pemenang di kartu
                    winnerCard1.textContent = winner1;
                    winnerCard2.textContent = winner2;
                    winnerCardContainer.classList.remove('hidden');
                    spinButton.style.display = 'block'; // Tampilkan kembali tombol putar

                    // --- Hapus nama yang sudah terpilih dari roda ---
                    // Buat array baru tanpa pemenang yang sudah terpilih
                    const remainingNames = originalNames.filter(name => name !== winner1 && name !== winner2);
                    // Jika ada nama yang sama, pastikan hanya satu instance yang dihapus per winner
                    if (winner1 === winner2 && remainingNames.length < originalNames.length - 1) {
                        // Jika kedua pemenang sama dan ada lebih dari satu instance nama itu,
                        // hapus hanya dua instance. Ini kasus kompleks, bisa disederhanakan
                        // dengan menghapus satu per satu.
                        const tempNames = [...originalNames];
                        const index1 = tempNames.indexOf(winner1);
                        if (index1 > -1) {
                            tempNames.splice(index1, 1);
                        }
                        const index2 = tempNames.indexOf(winner2);
                        if (index2 > -1) {
                            tempNames.splice(index2, 1);
                        }
                        namesInput.value = tempNames.join('\n');
                    } else {
                        // Kasus umum: hapus kedua nama yang berbeda
                        const tempNames = [...originalNames];
                        const index1 = tempNames.indexOf(winner1);
                        if (index1 > -1) {
                            tempNames.splice(index1, 1);
                        }
                        const index2 = tempNames.indexOf(winner2);
                        if (index2 > -1) {
                            // Perlu cek lagi index2 karena tempNames sudah berubah
                            const newIndex2 = tempNames.indexOf(winner2);
                            if (newIndex2 > -1) {
                                tempNames.splice(newIndex2, 1);
                            }
                        }
                        namesInput.value = tempNames.join('\n');
                    }

                    // Update roda dengan nama yang tersisa
                    updateWheel();

                    return;
                }

                drawWheel();
                animationFrameId = requestAnimationFrame(animateSpin);
            }

            animateSpin();
        }

        // Event Listeners
        addNamesButton.addEventListener('click', updateWheel);
        clearNamesButton.addEventListener('click', () => {
            namesInput.value = '';
            segments = [];
            originalNames = []; // Bersihkan juga originalNames
            updateWheel(); // Panggil updateWheel untuk membersihkan roda dan status
        });
        spinButton.addEventListener('click', spinWheel);

        // Inisialisasi roda saat halaman dimuat
        updateWheel(); // Panggil updateWheel untuk inisialisasi awal dengan input kosong

        // Responsiveness untuk canvas
        function resizeCanvas() {
            const container = canvas.parentElement;
            const size = Math.min(container.offsetWidth, window.innerHeight * 0.6, 500); // Batasi ukuran maksimum
            canvas.width = size;
            canvas.height = size;
            drawWheel();
        }

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas(); // Panggil saat awal untuk mengatur ukuran
    });
</script>
@endsection
