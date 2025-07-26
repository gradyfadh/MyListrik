<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan - VoltPay</title>
    <!-- CSS -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css_admin/sb-admin-2.min.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-8">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden w-full max-w-5xl grid grid-cols-1 md:grid-cols-2">

            <!-- Kiri: Form Registrasi -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-[#ff654d] mb-1 text-center">🔌 Voltix - Daftar Pelanggan</h2>
                <p class="text-center text-sm text-gray-500 mb-6">Buat akun pelanggan baru untuk mulai mengelola tagihan
                    listrik Anda</p>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('pelanggan.register.post') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kolom kiri -->
                        <div>
                            <div class="mb-4">
                                <input type="text" name="nama_pelanggan" placeholder="Nama Lengkap"
                                    value="{{ old('nama_pelanggan') }}"
                                    class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]"
                                    required>
                            </div>

                            <div class="mb-4">
                                <input type="email" name="email" placeholder="Alamat Email"
                                    value="{{ old('email') }}"
                                    class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]"
                                    required>
                            </div>

                            <div class="mb-4">
                                <input type="text" name="nomor_kwh" placeholder="Nomor KWH/Meter"
                                    value="{{ old('nomor_kwh') }}"
                                    class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]"
                                    required>
                            </div>

                            <div class="mb-4">
                                <input type="text" name="no_telp" placeholder="Nomor Telepon (Opsional)"
                                    value="{{ old('no_telp') }}"
                                    class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]">
                            </div>
                        </div>

                        <!-- Kolom kanan -->
                        <div>
                            <div class="mb-4">
                                <select name="id_tarif"
                                    class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]"
                                    required>
                                    <option value="">-- Pilih Tarif Listrik --</option>
                                    @foreach ($tarifs as $tarif)
                                        <option value="{{ $tarif->id_tarif }}"
                                            {{ old('id_tarif') == $tarif->id_tarif ? 'selected' : '' }}>
                                            {{ $tarif->kode_tarif }} - {{ $tarif->daya }} Watt - Rp
                                            {{ number_format($tarif->tarifperkwh, 0, ',', '.') }}/kWh
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <textarea name="alamat" rows="3" placeholder="Alamat Lengkap"
                                    class="w-full rounded-lg px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]"
                                    required>{{ old('alamat') }}</textarea>
                            </div>

                            <div class="mb-4">
                                <input type="password" name="password" placeholder="Kata Sandi (Min. 8 karakter)"
                                    class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]"
                                    required>
                            </div>

                            <div class="mb-4">
                                <input type="password" name="password_confirmation" placeholder="Konfirmasi Kata Sandi"
                                    class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg mb-4 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            <div>
                                <strong>Informasi:</strong> Setelah mendaftar, akun Anda akan menunggu persetujuan admin
                                sebelum dapat digunakan untuk login.
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#ff654d] text-white py-2.5 mt-2 rounded-full font-semibold hover:bg-[#e14b3b] transition">
                        Daftar sebagai Pelanggan
                    </button>

                    <div class="mt-4 flex justify-between text-sm">
                        <a href="{{ route('pelanggan.login') }}" class="text-gray-600 hover:text-[#ff654d]">&larr;
                            Kembali ke Login</a>
                        <a href="{{ route('login') }}" class="text-gray-500 hover:underline">Login sebagai Admin</a>
                    </div>
                </form>
            </div>

            <!-- Kanan: Branding -->
            <div
                class="bg-gradient-to-br from-[#ff654d] to-[#e14b3b] text-white flex flex-col justify-center items-center p-8">
                <div class="text-center">
                    <div class="text-4xl font-bold mb-4">⚡ Voltix</div>
                    <h3 class="text-xl font-semibold mb-4">Bergabunglah dengan Kami!</h3>
                    <p class="text-sm max-w-xs mb-6 opacity-90">
                        Nikmati kemudahan mengelola tagihan listrik dengan sistem digital yang modern dan aman.
                    </p>

                    <div class="space-y-3 text-left">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-300"></i>
                            <span class="text-sm">Monitoring penggunaan real-time</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-300"></i>
                            <span class="text-sm">Pembayaran online yang mudah</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-300"></i>
                            <span class="text-sm">Riwayat tagihan lengkap</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-300"></i>
                            <span class="text-sm">Notifikasi tagihan otomatis</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
