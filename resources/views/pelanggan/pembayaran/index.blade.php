@extends('pelanggan.layouts.index')

<!-- Include Alert Component dengan Fixed Position -->
<div class="fixed top-4 right-4 z-50 max-w-md">
    @include('components.alert')
</div>

@push('styles')
    <style>
        .step-content {
            transition: all 0.3s ease-in-out;
        }

        .step-item {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .step-circle {
            transition: all 0.2s ease;
        }

        .payment-option {
            transition: all 0.2s ease;
        }

        .payment-option:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@section('content')
    <div class="bg-gray-100 min-h-screen px-4 py-8">
        <div class="max-w-7xl mx-auto">

            {{-- ===== Heading ===== --}}
            <div class="text-center mb-5">
                <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800">
                    Transaksi Pembayaran Listrik
                </h1>
                <p class="mt-2 text-gray-500">
                    Ikuti langkah‑langkah berikut untuk menyelesaikan pembayaran dengan mudah dan aman.
                </p>
            </div>

            {{-- ===== Grid 2 kolom ===== --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

                {{-- ────────────────  K O L O M   K I R I  ──────────────── --}}
                <div class="space-y-3 col-span-2">

                    {{-- ▸ Step Navigation --}}
                    <div class="bg-white rounded-2xl shadow px-6 py-2" id="step-navigation">
                        <div class="flex items-center justify-between relative">
                            {{-- Step 1 --}}
                            <div class="step-item flex flex-col items-center gap-1 z-10 active" data-step="1">
                                <div
                                    class="step-circle w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-xl text-white">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </div>
                                <span class="text-xs font-medium text-blue-600">Detail Tagihan</span>
                            </div>

                            {{-- Progress Line 1-2 --}}
                            <div class="flex-1 mx-4 relative">
                                <div class="progress-line h-1 bg-gray-300 rounded-full" id="line-1-2">
                                    <div class="progress-fill h-full bg-blue-600 rounded-full transition-all duration-300"
                                        style="width: 0%"></div>
                                </div>
                            </div>

                            {{-- Step 2 --}}
                            <div class="step-item flex flex-col items-center gap-1 z-10 text-gray-400" data-step="2">
                                <div
                                    class="step-circle w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-xl">
                                    <i class="fa-solid fa-building-columns"></i>
                                </div>
                                <span class="text-xs font-medium">Rekening Tujuan</span>
                            </div>

                            {{-- Progress Line 2-3 --}}
                            <div class="flex-1 mx-4 relative">
                                <div class="progress-line h-1 bg-gray-300 rounded-full" id="line-2-3">
                                    <div class="progress-fill h-full bg-blue-600 rounded-full transition-all duration-300"
                                        style="width: 0%"></div>
                                </div>
                            </div>

                            {{-- Step 3 --}}
                            <div class="step-item flex flex-col items-center gap-1 z-10 text-gray-400" data-step="3">
                                <div
                                    class="step-circle w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-xl">
                                    <i class="fa-solid fa-upload"></i>
                                </div>
                                <span class="text-xs font-medium">Unggah Bukti</span>
                            </div>
                        </div>
                    </div>

                    {{-- ▸ Step 1: Detail Tagihan --}}
                    <div class="step-content bg-white p-6 rounded-xl shadow" id="step-1">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <i class="ti ti-file-description text-xl"></i> Detail Tagihan
                        </h2>

                        {{-- tabel ringkas --}}
                        <div class="border rounded-xl divide-y text-sm bg-gray-100">
                            @foreach (['Nama Pelanggan' => $tagihan->pelanggan->nama_pelanggan, 'No. Invoice' => $tagihan->no_invoice, 'Nomor KWH' => $tagihan->pelanggan->nomor_kwh, 'Periode' => bulanIndo($tagihan->bulan) . ' ' . $tagihan->tahun, 'Jumlah Meter' => number_format($tagihan->jumlah_meter) . ' kWh', 'Tarif / kWh' => 'Rp ' . number_format($tagihan->pelanggan->tarif->tarifperkwh ?? 0, 0, ',', '.')] as $label => $value)
                                {{-- baris detail --}}
                                <div class="flex justify-between px-4 py-2">
                                    <span class="text-gray-500">{{ $label }}</span>
                                    <span class="font-semibold">{{ $value }}</span>
                                </div>
                            @endforeach
                            <div class="flex justify-between px-4 py-3 font-semibold text-base">
                                <span>Total Bayar</span>
                                <span class="text-blue-600" id="total-bayar">
                                    Rp
                                    {{ number_format($tagihan->jumlah_meter * ($tagihan->pelanggan->tarif->tarifperkwh ?? 0), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="text-right mt-6">
                            <button id="btn-step-1"
                                class="inline-flex items-center gap-1 text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                                Lanjut ke Rekening Tujuan
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    {{-- ▸ Step 2: Rekening Tujuan --}}
                    <div class="step-content bg-white p-6 rounded-xl shadow hidden" id="step-2">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-building-columns text-xl"></i> Rekening Tujuan
                        </h2>

                        <p class="text-gray-600 mb-6">
                            Pilih rekening tujuan sesuai metode pembayaran yang Anda inginkan.<br>
                            Pastikan Anda mentransfer sesuai nominal <span class="font-semibold text-blue-600">
                                Rp
                                {{ number_format($tagihan->jumlah_meter * ($tagihan->pelanggan->tarif->tarifperkwh ?? 0), 0, ',', '.') }}
                            </span> a.n PT Voltix.
                        </p>

                        {{-- Payment Methods from Database --}}
                        @php
                            // Group payment methods by jenis_pembayaran from database
                            $metodePembayarans = \App\Models\MetodePembayaran::where('is_aktif', true)->get();
                            $banks = $metodePembayarans->where('jenis_pembayaran', 'Bank');
                            $ewallets = $metodePembayarans->where('jenis_pembayaran', 'E-Wallet');
                            $qris = $metodePembayarans->where('jenis_pembayaran', 'QRIS');
                            $retail = $metodePembayarans->where('jenis_pembayaran', 'Retail');
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            {{-- ==== BANKS ==== --}}
                            @if ($banks->count() > 0)
                                <div class="bg-gray-50 rounded-xl p-6 border">
                                    <h3 class="text-center font-semibold text-lg mb-4">Bank</h3>

                                    @foreach ($banks as $bank)
                                        <label
                                            class="flex items-center gap-4 bg-white hover:bg-blue-50 border rounded-lg p-4 mb-3 cursor-pointer payment-option">
                                            <input type="radio" name="metode_pembayaran" value="{{ $bank->nama }}"
                                                data-id="{{ $bank->id }}" data-biaya="{{ $bank->biaya_admin }}"
                                                class="form-radio text-blue-600" required>
                                            <img src="{{ $bank->logo_url }}" alt="{{ $bank->nama }}"
                                                class="w-14 h-8 object-contain">
                                            <div class="flex-1">
                                                <p class="font-semibold">{{ $bank->nama }}</p>
                                                <p class="text-xs text-gray-500">{{ $bank->atas_nama }}</p>
                                                <p class="text-sm font-mono">{{ $bank->nomor_rekening }}</p>
                                                @if ($bank->biaya_admin > 0)
                                                    <p class="text-xs text-orange-600">+ Biaya Admin:
                                                        {{ $bank->biaya_admin_format }}</p>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                            {{-- ==== E‑WALLETS ==== --}}
                            @if ($ewallets->count() > 0)
                                <div class="bg-gray-50 rounded-xl p-6 border">
                                    <h3 class="text-center font-semibold text-lg mb-4">E‑Wallet</h3>

                                    @foreach ($ewallets as $ewallet)
                                        <label
                                            class="flex items-center gap-4 bg-white hover:bg-blue-50 border rounded-lg p-4 mb-3 cursor-pointer payment-option">
                                            <input type="radio" name="metode_pembayaran" value="{{ $ewallet->nama }}"
                                                data-id="{{ $ewallet->id }}" data-biaya="{{ $ewallet->biaya_admin }}"
                                                class="form-radio text-blue-600" required>
                                            <img src="{{ $ewallet->logo_url }}" alt="{{ $ewallet->nama }}"
                                                class="w-14 h-8 object-contain">
                                            <div class="flex-1">
                                                <p class="font-semibold">{{ $ewallet->nama }}</p>
                                                <p class="text-xs text-gray-500">{{ $ewallet->atas_nama }}</p>
                                                <p class="text-sm font-mono">
                                                    {{ $ewallet->nomor_rekening ?: 'Scan QR Code' }}</p>
                                                @if ($ewallet->biaya_admin > 0)
                                                    <p class="text-xs text-orange-600">+ Biaya Admin:
                                                        {{ $ewallet->biaya_admin_format }}</p>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                            {{-- ==== QRIS ==== --}}
                            @if ($qris->count() > 0)
                                <div class="bg-gray-50 rounded-xl p-6 border">
                                    <h3 class="text-center font-semibold text-lg mb-4">QRIS</h3>

                                    @foreach ($qris as $qr)
                                        <label
                                            class="flex items-center gap-4 bg-white hover:bg-blue-50 border rounded-lg p-4 mb-3 cursor-pointer payment-option">
                                            <input type="radio" name="metode_pembayaran" value="{{ $qr->nama }}"
                                                data-id="{{ $qr->id }}" data-biaya="{{ $qr->biaya_admin }}"
                                                class="form-radio text-blue-600" required>
                                            <img src="{{ $qr->logo_url }}" alt="{{ $qr->nama }}"
                                                class="w-14 h-8 object-contain">
                                            <div class="flex-1">
                                                <p class="font-semibold">{{ $qr->nama }}</p>
                                                <p class="text-xs text-gray-500">{{ $qr->atas_nama }}</p>
                                                <p class="text-sm font-mono">
                                                    {{ $qr->nomor_rekening ?: 'Scan QR Code' }}</p>
                                                @if ($qr->biaya_admin > 0)
                                                    <p class="text-xs text-orange-600">+ Biaya Admin:
                                                        {{ $qr->biaya_admin_format }}</p>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                            {{-- ==== RETAIL ==== --}}
                            @if ($retail->count() > 0)
                                <div class="bg-gray-50 rounded-xl p-6 border">
                                    <h3 class="text-center font-semibold text-lg mb-4">Retail</h3>

                                    @foreach ($retail as $ret)
                                        <label
                                            class="flex items-center gap-4 bg-white hover:bg-blue-50 border rounded-lg p-4 mb-3 cursor-pointer payment-option">
                                            <input type="radio" name="metode_pembayaran" value="{{ $ret->nama }}"
                                                data-id="{{ $ret->id }}" data-biaya="{{ $ret->biaya_admin }}"
                                                class="form-radio text-blue-600" required>
                                            <img src="{{ $ret->logo_url }}" alt="{{ $ret->nama }}"
                                                class="w-14 h-8 object-contain">
                                            <div class="flex-1">
                                                <p class="font-semibold">{{ $ret->nama }}</p>
                                                <p class="text-xs text-gray-500">{{ $ret->atas_nama }}</p>
                                                <p class="text-sm font-mono">
                                                    {{ $ret->nomor_rekening ?: 'Kode Pembayaran' }}</p>
                                                @if ($ret->biaya_admin > 0)
                                                    <p class="text-xs text-orange-600">+ Biaya Admin:
                                                        {{ $ret->biaya_admin_format }}</p>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- No Payment Methods Available --}}
                        @if ($metodePembayarans->count() == 0)
                            <div class="text-center py-8">
                                <i class="fa-solid fa-credit-card-off text-4xl text-gray-400 mb-4"></i>
                                <h3 class="text-lg font-semibold text-gray-600 mb-2">Tidak Ada Metode Pembayaran</h3>
                                <p class="text-gray-500">Silakan hubungi admin untuk informasi metode pembayaran.</p>
                            </div>
                        @endif

                        <div class="flex justify-between mt-6">
                            <button id="btn-back-step-2"
                                class="inline-flex items-center gap-2 border px-5 py-2 rounded-md text-gray-700 hover:bg-gray-100">
                                <i class="fa-solid fa-arrow-left"></i> Kembali ke Detail Tagihan
                            </button>
                            <button id="btn-step-2"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md shadow disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                                Lanjut ke Unggah Bukti <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    {{-- ▸ Step 3: Unggah Bukti --}}
                    <div class="step-content bg-white p-6 rounded-xl shadow hidden" id="step-3">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-upload text-xl"></i> Unggah Bukti Pembayaran
                        </h2>

                        <p class="text-sm text-gray-600 mb-6">
                            Unggah bukti pembayaran yang jelas (JPG, JPEG, PNG, atau PDF, maksimal 2 MB) sebagai konfirmasi
                            pembayaran Anda.
                        </p>

                        {{-- Error Messages --}}
                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                    <div>
                                        <h3 class="text-sm font-medium text-red-800">Terjadi Kesalahan</h3>
                                        <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Success Message --}}
                        @if (session('success'))
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span class="text-sm text-green-800">{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        {{-- Error Message --}}
                        @if (session('error'))
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                    <span class="text-sm text-red-800">{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif

                        {{-- Info metode pembayaran terpilih --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6" id="selected-payment-info"
                            style="display: none;">
                            <div class="space-y-2">
                                <p class="text-sm text-blue-800">
                                    <strong>Metode Pembayaran Terpilih:</strong> <span id="selected-payment-name"></span>
                                </p>
                                <div class="border-t border-blue-200 pt-2">
                                    <div class="flex justify-between text-sm text-blue-700">
                                        <span>Tagihan Listrik:</span>
                                        <span id="bill-amount">Rp
                                            {{ number_format($tagihan->jumlah_meter * ($tagihan->pelanggan->tarif->tarifperkwh ?? 0), 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-blue-700" id="admin-fee-row"
                                        style="display: none;">
                                        <span>Biaya Admin:</span>
                                        <span id="admin-fee-amount">Rp 0</span>
                                    </div>
                                    <div
                                        class="flex justify-between text-sm font-semibold text-blue-800 border-t border-blue-200 pt-1 mt-1">
                                        <span>Total Bayar:</span>
                                        <span id="total-amount">Rp
                                            {{ number_format($tagihan->jumlah_meter * ($tagihan->pelanggan->tarif->tarifperkwh ?? 0), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form id="form-upload" action="{{ route('bayar.store', $tagihan->id_tagihan) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="metode_pembayaran" id="selected-method" value="">

                            <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Pembayaran</label>
                            <input type="file" name="bukti_pembayaran" accept="image/*,application/pdf"
                                class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm file:mr-4 file:px-4 file:py-2 file:rounded-md file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-500 cursor-pointer"
                                required>

                            <p class="text-xs text-gray-500 mt-2">
                                Pastikan file yang diunggah berukuran maksimal 2 MB.
                            </p>

                            {{-- preview sederhana --}}
                            <div id="preview" class="hidden mt-4">
                                <p class="text-xs text-gray-500 mb-1">Pratinjau:</p>
                                <img src="#" alt="preview" class="max-h-40 rounded-md shadow">
                            </div>
                        </form>

                        <div class="flex justify-between mt-6">
                            <button id="btn-back-step-3"
                                class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 px-6 py-2 rounded-md text-sm hover:bg-gray-100">
                                <i class="ti ti-arrow-left text-base"></i> Kembali ke Rekening Tujuan
                            </button>
                            <button type="submit" form="form-upload"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2 rounded-md shadow">
                                <i class="ti ti-upload text-base"></i> Unggah Bukti Pembayaran
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ────────────────  K O L O M   K A N A N  ──────────────── --}}
                <div class="bg-white p-6 rounded-xl shadow h-fit col-span-1">
                    <h2 class="text-lg font-semibold mb-4">Cara Pembayaran</h2>

                    @foreach (['Periksa Tagihan' => 'Pastikan semua data tagihan telah sesuai dan benar.', 'Pilih Metode Pembayaran' => 'Tentukan rekening bank atau e‑wallet yang ingin Anda gunakan.', 'Transfer Nominal Tepat' => 'Lakukan transfer sesuai dengan jumlah total yang tertera.', 'Unggah Bukti Pembayaran' => 'Upload bukti transfer sebagai konfirmasi pembayaran.'] as $i => $desc)
                        <div class="flex items-start gap-3 mb-4">
                            <span
                                class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white text-xs flex items-center justify-center">
                                {{ $loop->iteration }}
                            </span>
                            <p class="text-sm text-gray-700">{{ $desc }}</p>
                        </div>
                    @endforeach

                    <p class="mt-4 text-xs text-gray-500">
                        Butuh bantuan? Hubungi CS di
                        <a href="tel:08123456789" class="text-blue-600">0812‑3456‑789</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let currentStep = 1;

            // Function to update step navigation
            function updateStepNavigation(step) {
                $('.step-item').each(function() {
                    const stepNum = $(this).data('step');
                    const circle = $(this).find('.step-circle');
                    const text = $(this).find('span');

                    if (stepNum <= step) {
                        $(this).removeClass('text-gray-400').addClass('text-blue-600');
                        circle.removeClass('bg-gray-200').addClass('bg-blue-600 text-white');
                        text.removeClass('text-gray-400').addClass('text-blue-600');
                    } else {
                        $(this).removeClass('text-blue-600').addClass('text-gray-400');
                        circle.removeClass('bg-blue-600 text-white').addClass('bg-gray-200');
                        text.removeClass('text-blue-600').addClass('text-gray-400');
                    }
                });

                // Update progress lines
                updateProgressLines(step);
            }

            // Function to update progress lines
            function updateProgressLines(step) {
                if (step >= 2) {
                    $('#line-1-2 .progress-fill').css('width', '100%');
                } else {
                    $('#line-1-2 .progress-fill').css('width', '0%');
                }

                if (step >= 3) {
                    $('#line-2-3 .progress-fill').css('width', '100%');
                } else {
                    $('#line-2-3 .progress-fill').css('width', '0%');
                }
            }

            // Function to show specific step with animation
            function showStep(step) {
                const currentContent = $(`.step-content:not(.hidden)`);
                const nextContent = $(`#step-${step}`);

                // Fade out current step
                currentContent.fadeOut(200, function() {
                    currentContent.addClass('hidden');

                    // Fade in next step
                    nextContent.removeClass('hidden').hide().fadeIn(300).addClass('fade-in');

                    setTimeout(() => nextContent.removeClass('fade-in'), 300);
                });

                updateStepNavigation(step);
                currentStep = step;

                // Smooth scroll to top of content
                $('html, body').animate({
                    scrollTop: $('#step-navigation').offset().top - 100
                }, 400);
            }

            // Step 1 -> Step 2
            $('#btn-step-1').click(function() {
                showStep(2);
            });

            // Back from Step 2 -> Step 1
            $('#btn-back-step-2').click(function() {
                showStep(1);
            });

            // Step 2 -> Step 3
            $('#btn-step-2').click(function() {
                const selectedPayment = $('input[name="metode_pembayaran"]:checked');
                if (selectedPayment.length > 0) {
                    const paymentName = selectedPayment.val();
                    const paymentId = selectedPayment.data('id');
                    const adminFee = selectedPayment.data('biaya') || 0;

                    $('#selected-method').val(paymentName);
                    $('#selected-payment-name').text(paymentName);

                    // Add hidden input for payment method ID
                    if ($('#selected-method-id').length === 0) {
                        $('#form-upload').append(
                            '<input type="hidden" name="metode_pembayaran_id" id="selected-method-id" value="">'
                        );
                    }
                    $('#selected-method-id').val(paymentId);

                    // Update payment info breakdown
                    const originalTotal =
                        {{ $tagihan->jumlah_meter * ($tagihan->pelanggan->tarif->tarifperkwh ?? 0) }};

                    if (adminFee > 0) {
                        const newTotal = originalTotal + parseInt(adminFee);
                        $('#admin-fee-row').show();
                        $('#admin-fee-amount').text('Rp ' + new Intl.NumberFormat('id-ID').format(
                            parseInt(adminFee)));
                        $('#total-amount').text('Rp ' + new Intl.NumberFormat('id-ID').format(newTotal));
                    } else {
                        $('#admin-fee-row').hide();
                        $('#total-amount').text('Rp ' + new Intl.NumberFormat('id-ID').format(
                            originalTotal));
                    }

                    $('#selected-payment-info').fadeIn(300);
                    showStep(3);
                }
            });

            // Back from Step 3 -> Step 2
            $('#btn-back-step-3').click(function() {
                showStep(2);
            });

            // Enable/disable step 2 button based on payment method selection
            $('input[name="metode_pembayaran"]').change(function() {
                if ($(this).is(':checked')) {
                    $('#btn-step-2').prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');

                    // Add visual feedback for selected payment option
                    $('.payment-option').removeClass('border-blue-500 bg-blue-50 ring-2 ring-blue-200');
                    $(this).closest('.payment-option').addClass(
                        'border-blue-500 bg-blue-50 ring-2 ring-blue-200');
                }
            });

            // File preview functionality
            $('input[name="bukti_pembayaran"]').change(function(e) {
                const file = e.target.files[0];
                if (!file) {
                    $('#preview').fadeOut(200);
                    return;
                }

                // Check file size (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2 MB.');
                    $(this).val('');
                    $('#preview').fadeOut(200);
                    return;
                }

                // Show preview for images
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview img').attr('src', e.target.result);
                        $('#preview').fadeIn(300);
                    };
                    reader.readAsDataURL(file);
                } else {
                    // For PDF files, just show filename
                    $('#preview').html(`
                <p class="text-xs text-gray-500 mb-1">File terpilih:</p>
                <div class="bg-gray-100 p-3 rounded-md flex items-center">
                    <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                    <span class="text-sm">${file.name}</span>
                    <span class="text-xs text-gray-500 ml-auto">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                </div>
            `).fadeIn(300);
                }
            });

            // Form submission with loading state
            $('#form-upload').submit(function(e) {
                const form = this;
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();

                // Debug: Log form data
                console.log('Form submission started');
                console.log('Selected method:', $('#selected-method').val());
                console.log('Selected method ID:', $('#selected-method-id').val());

                // Check if form is valid before proceeding
                if (!form.checkValidity()) {
                    console.log('Form validation failed');
                    // Let browser handle validation messages
                    return true;
                }

                // Check if payment method is selected
                if (!$('#selected-method').val() || !$('#selected-method-id').val()) {
                    e.preventDefault();
                    console.log('Payment method not selected');
                    alert('Silakan pilih metode pembayaran terlebih dahulu.');
                    return false;
                }

                console.log('Form is valid, submitting...');

                // Show loading state
                submitBtn.prop('disabled', true).addClass('btn-loading').html('Mengunggah...');

                // Allow form to submit normally
                return true;
            });

            // Click on step navigation to go to that step (if accessible)
            $('.step-item').click(function() {
                const targetStep = $(this).data('step');

                // Only allow going to previous steps or accessible next steps
                if (targetStep === 1) {
                    showStep(1);
                } else if (targetStep === 2 && currentStep >= 1) {
                    showStep(2);
                } else if (targetStep === 3 && currentStep >= 2 && $(
                        'input[name="metode_pembayaran"]:checked').length > 0) {
                    const selectedPayment = $('input[name="metode_pembayaran"]:checked');
                    const paymentName = selectedPayment.val();
                    const paymentId = selectedPayment.data('id');
                    const adminFee = selectedPayment.data('biaya') || 0;

                    $('#selected-method').val(paymentName);
                    $('#selected-payment-name').text(paymentName);

                    // Add hidden input for payment method ID
                    if ($('#selected-method-id').length === 0) {
                        $('#form-upload').append(
                            '<input type="hidden" name="metode_pembayaran_id" id="selected-method-id" value="">'
                        );
                    }
                    $('#selected-method-id').val(paymentId);

                    // Update payment info breakdown
                    const originalTotal =
                        {{ $tagihan->jumlah_meter * ($tagihan->pelanggan->tarif->tarifperkwh ?? 0) }};

                    if (adminFee > 0) {
                        const newTotal = originalTotal + parseInt(adminFee);
                        $('#admin-fee-row').show();
                        $('#admin-fee-amount').text('Rp ' + new Intl.NumberFormat('id-ID').format(
                            parseInt(adminFee)));
                        $('#total-amount').text('Rp ' + new Intl.NumberFormat('id-ID').format(newTotal));
                    } else {
                        $('#admin-fee-row').hide();
                        $('#total-amount').text('Rp ' + new Intl.NumberFormat('id-ID').format(
                            originalTotal));
                    }

                    $('#selected-payment-info').show();
                    showStep(3);
                }
            });

            // Add hover effects to step navigation
            $('.step-item').hover(
                function() {
                    const stepNum = $(this).data('step');
                    if (stepNum <= currentStep || stepNum === currentStep + 1) {
                        $(this).addClass('transform scale-105');
                    }
                },
                function() {
                    $(this).removeClass('transform scale-105');
                }
            );

            // Real-time validation feedback
            $('#form-upload input[required]').on('input change', function() {
                const form = $('#form-upload')[0];
                const submitBtn = $('#form-upload button[type="submit"]');

                if (form.checkValidity()) {
                    submitBtn.removeClass('opacity-50 cursor-not-allowed');
                } else {
                    submitBtn.addClass('opacity-50 cursor-not-allowed');
                }
            });

            // Add notification for successful step completion
            function showNotification(message, type = 'success') {
                const notification = $(`
            <div class="fixed top-4 right-4 z-50 max-w-sm bg-white border border-gray-200 rounded-lg shadow-lg p-4 ${type === 'success' ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50'}">
                <div class="flex items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle text-green-500' : 'fa-exclamation-circle text-red-500'} mr-3"></i>
                    <span class="text-sm ${type === 'success' ? 'text-green-800' : 'text-red-800'}">${message}</span>
                </div>
            </div>
        `);

                $('body').append(notification);

                setTimeout(() => {
                    notification.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            // Show notification when payment method is selected
            $('input[name="metode_pembayaran"]').change(function() {
                if ($(this).is(':checked')) {
                    showNotification(`Metode pembayaran ${$(this).val()} telah dipilih`);
                }
            });
        });
    </script>
@endpush
