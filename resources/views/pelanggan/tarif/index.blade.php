@extends('pelanggan.layouts.index')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-blue-700 text-center">Daftar Tarif Listrik</h2>
        <p class="text-center text-gray-600 mb-8">Lihat tarif listrik yang tersedia untuk membantu Anda memilih paket yang
            tepat.</p>

        <!-- Include Alert Component dengan Fixed Position -->
        <div class="fixed top-4 right-4 z-50 max-w-md">
            @include('components.alert')
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <!-- Kolom Tarif -->
            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6 order-2 lg:order-1">
                <!-- Looping data tarif -->
                @foreach ($tarifs as $tarif)
                    <div class="bg-white p-4 rounded-lg shadow-md border">
                        <div class="text-blue-600 text-xl mb-2">
                            <i class="fas fa-bolt"></i> {{ $tarif->daya }} VA
                        </div>
                        <p class="text-gray-900 font-semibold mb-1">
                            Rp {{ number_format($tarif->tarifperkwh, 0, ',', '.') }} / kWh
                        </p>
                        <p class="text-gray-600 text-sm">
                            {{ $tarif->deskripsi }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Kolom Kalkulator -->
            <div class="lg:sticky lg:top-24 self-start order-1 lg:order-2">
                <div class="bg-white p-6 rounded-lg shadow-md border">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Kalkulator Pemakaian Listrik</h3>

                    <form>
                        <div class="mb-4">
                            <label for="tarif" class="block text-sm text-gray-600 mb-1">Pilih Tarif</label>
                            <select id="tarif" name="tarif"
                                class="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Tarif --</option>
                                @foreach ($tarifs as $tarif)
                                    <option value="{{ $tarif->tarifperkwh }}">
                                        {{ $tarif->daya }} VA - Rp
                                        {{ number_format($tarif->tarifperkwh, 0, ',', '.') }}/kWh
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="kwh" class="block text-sm text-gray-600 mb-1">Pemakaian (kWh)</label>
                            <input type="number" id="kwh" name="kwh" min="0" step="0.01"
                                class="w-full h-10 p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Masukkan jumlah kWh">
                            <div class="text-xs text-gray-500 mt-1">Contoh: 150 kWh per bulan</div>
                        </div>

                        <div class="flex gap-2 mb-3">
                            <button type="button" id="hitungBiaya"
                                class="flex-1 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-500 transition duration-200">
                                <i class="fas fa-calculator mr-1"></i> Hitung Biaya
                            </button>
                            <button type="button" id="resetBiaya"
                                class="px-4 bg-gray-500 text-white py-2 rounded-md hover:bg-gray-600 transition duration-200"
                                title="Reset kalkulator">
                                <i class="fas fa-redo-alt"></i>
                            </button>
                        </div>

                        <div class="text-xs text-gray-500 mb-3">
                            <strong>Contoh penggunaan:</strong><br>
                            <button type="button" class="text-blue-600 hover:underline preset-btn" data-kwh="100">100
                                kWh</button> |
                            <button type="button" class="text-blue-600 hover:underline preset-btn" data-kwh="150">150
                                kWh</button> |
                            <button type="button" class="text-blue-600 hover:underline preset-btn" data-kwh="200">200
                                kWh</button>
                        </div>
                    </form>

                    <!-- Hasil Perhitungan - Hidden by default -->
                    <div id="hasilBiaya" class="mt-4 p-3 bg-gray-50 rounded-md border hidden">
                        <!-- Hasil akan diisi oleh JavaScript -->
                    </div>

                    <div class="mt-4 p-3 bg-blue-50 rounded-md border-l-4 border-blue-400">
                        <h4 class="text-sm font-semibold text-blue-800 mb-2">💡 Info Pemakaian Rata-rata</h4>
                        <div class="text-xs text-blue-700 space-y-1">
                            <div>• Rumah kecil (1-2 orang): 80-120 kWh/bulan</div>
                            <div>• Rumah sedang (3-4 orang): 150-250 kWh/bulan</div>
                            <div>• Rumah besar (5+ orang): 300-500 kWh/bulan</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hitungButton = document.getElementById('hitungBiaya');
            const resetButton = document.getElementById('resetBiaya');
            const tarifSelect = document.getElementById('tarif');
            const kwhInput = document.getElementById('kwh');
            const hasilDiv = document.getElementById('hasilBiaya');
            const presetButtons = document.querySelectorAll('.preset-btn');

            // Event listener untuk tombol hitung - HANYA INI yang menampilkan hasil
            hitungButton.addEventListener('click', function() {
                hitungBiayaListrik();
            });

            // Event listener untuk tombol reset
            resetButton.addEventListener('click', function() {
                resetKalkulator();
            });

            // Event listener untuk preset buttons - hanya mengisi input, tidak langsung hitung
            presetButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const kwh = this.getAttribute('data-kwh');
                    kwhInput.value = kwh;
                    // Tidak langsung hitung, biarkan user klik tombol hitung
                });
            });

            // Event listener untuk Enter key pada input kWh
            kwhInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    hitungBiayaListrik();
                }
            });

            function hitungBiayaListrik() {
                const tarif = parseFloat(tarifSelect.value);
                const kwh = parseFloat(kwhInput.value);

                // Validasi input
                if (!tarif || !kwh || kwh <= 0) {
                    if (!tarif && !kwh) {
                        showResult(`
                            <strong class="text-red-600">Hasil Perhitungan:</strong><br>
                            <span class="text-red-500">Silakan pilih tarif dan masukkan jumlah kWh terlebih dahulu</span><br>
                            <span class="text-xs italic text-gray-400 mt-2 block">* Perhitungan ini adalah estimasi</span>
                        `);
                    } else if (!tarif) {
                        showResult(`
                            <strong class="text-red-600">Hasil Perhitungan:</strong><br>
                            <span class="text-red-500">Silakan pilih tarif terlebih dahulu</span><br>
                            <span class="text-xs italic text-gray-400 mt-2 block">* Perhitungan ini adalah estimasi</span>
                        `);
                    } else if (!kwh || kwh <= 0) {
                        showResult(`
                            <strong class="text-red-600">Hasil Perhitungan:</strong><br>
                            <span class="text-red-500">Masukkan jumlah kWh yang valid (lebih dari 0)</span><br>
                            <span class="text-xs italic text-gray-400 mt-2 block">* Perhitungan ini adalah estimasi</span>
                        `);
                    }
                    return;
                }

                // Hitung biaya
                const biayaDasar = tarif * kwh;
                const totalBiaya = biayaDasar;

                // Format mata uang Indonesia
                const formatRupiah = (amount) => {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(amount);
                };

                // Tampilkan hasil detail dengan animasi
                showResult(`
                    <strong class="text-green-600">Hasil Perhitungan:</strong><br>
                    <div class="mt-3 space-y-2">
                        <div class="flex justify-between text-sm py-1">
                            <span class="text-gray-600">Pemakaian:</span>
                            <span class="font-medium text-gray-800">${kwh} kWh</span>
                        </div>
                        <div class="flex justify-between text-sm py-1">
                            <span class="text-gray-600">Tarif per kWh:</span>
                            <span class="font-medium text-gray-800">${formatRupiah(tarif)}</span>
                        </div>
                        <div class="flex justify-between text-sm py-1">
                            <span class="text-gray-600">Biaya Pemakaian:</span>
                            <span class="font-medium text-gray-800">${formatRupiah(biayaDasar)}</span>
                        </div>

                        <hr class="my-2 border-gray-300">
                        <div class="flex justify-between text-lg font-bold py-1">
                            <span class="text-gray-700">Total Biaya:</span>
                            <span class="text-blue-600">${formatRupiah(totalBiaya)}</span>
                        </div>
                    </div>
                    <span class="text-xs italic text-gray-400 mt-3 block">* Belum termasuk biaya admin</span>
                `);
            }

            function showResult(html) {
                hasilDiv.innerHTML = html;

                // Tampilkan dengan animasi smooth
                if (hasilDiv.classList.contains('hidden')) {
                    hasilDiv.classList.remove('hidden');
                    hasilDiv.style.opacity = '0';
                    hasilDiv.style.transform = 'translateY(-10px)';

                    setTimeout(() => {
                        hasilDiv.style.transition = 'all 0.3s ease-out';
                        hasilDiv.style.opacity = '1';
                        hasilDiv.style.transform = 'translateY(0)';
                    }, 10);
                }
            }

            function resetKalkulator() {
                // Reset input fields
                tarifSelect.value = '';
                kwhInput.value = '';

                // Sembunyikan hasil dengan animasi
                if (!hasilDiv.classList.contains('hidden')) {
                    hasilDiv.style.transition = 'all 0.3s ease-out';
                    hasilDiv.style.opacity = '0';
                    hasilDiv.style.transform = 'translateY(-10px)';

                    setTimeout(() => {
                        hasilDiv.classList.add('hidden');
                        hasilDiv.style.opacity = '';
                        hasilDiv.style.transform = '';
                        hasilDiv.style.transition = '';
                    }, 300);
                }

                // Focus ke tarif select
                tarifSelect.focus();
            }
        });
    </script>
@endpush
