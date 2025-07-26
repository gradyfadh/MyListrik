@extends('pelanggan.layouts.index')

@section('content')
    <!-- Include Alert Component dengan Fixed Position -->
    <div class="fixed top-4 right-4 z-50 max-w-md">
        @include('components.alert')
    </div>

    <section class="min-h-screen py-20 md:py-24 px-4 md:px-8 lg:px-20 xl:px-24 flex items-center">
        <div class="container mx-auto flex flex-col-reverse md:flex-row items-center gap-12 w-full">
            <div class="md:w-1/2 text-center md:text-left">
                @php
                    $pelanggan = \App\Models\Pelanggan::find(session('logged_id'));
                @endphp
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-4 text-blue-600">
                    Selamat datang, <br>
                    <span class="text-orange-600">{{ $pelanggan->nama_pelanggan ?? 'Pelanggan' }}</span>
                </h1>
                <p class="text-gray-600 mb-8 text-lg lg:text-xl">
                    Kelola tagihan listrik anda dengan mudah. Periksa riwayat penggunaan, cek tagihan terbaru, dan lakukan
                    pembayaran dengan cepat dan aman. </p>
                <div class="flex justify-center md:justify-start gap-4">

                    <a href="{{ route('pelanggan.tagihan') }}"
                        class="bg-orange-600 text-white px-7 py-3 rounded-md font-medium hover:bg-orange-500 transition duration-200 shadow-md">Bayar
                        Tagihan</a>

                    <a href="{{ route('riwayat-pembayaran') }}"
                        class="bg-white border border-blue-600 text-blue-600 px-7 py-3 rounded-md font-medium hover:bg-blue-100 transition duration-200 shadow-md">Riwayat
                        Penggunaan</a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center md:justify-end">
                <img src="{{ asset('assets/images/landing_image.jpg') }}" alt="Ilustrasi E-Invoice"
                    class="w-full max-w-xs md:max-w-sm lg:max-w-md xl:max-w-lg h-auto">
            </div>
        </div>
    </section>


    <section class="bg-gray-100 py-16 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                Solusi Praktis untuk Pembayaran Listrik Anda
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-10">
                Kami menyediakan berbagai fitur untuk memastikan pengalaman pembayaran listrik Anda lancar dan efisien.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Fitur 1 -->
                <div class="bg-white rounded-lg shadow border p-6 text-left">
                    <div class="text-blue-600 text-3xl mb-4">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Pembayaran Cepat</h3>
                    <p class="text-sm text-gray-600">Bayar tagihan listrik Anda dalam hitungan detik, kapan saja dan di mana
                        saja.</p>
                </div>

                <!-- Fitur 2 -->
                <div class="bg-white rounded-lg shadow border p-6 text-left">
                    <div class="text-blue-600 text-3xl mb-4">
                        <i class="fa-solid fa-rotate-left"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Riwayat Transaksi</h3>
                    <p class="text-sm text-gray-600">Lacak semua pembayaran Anda dengan mudah melalui riwayat transaksi yang
                        terperinci.</p>
                </div>

                <!-- Fitur 3 -->
                <div class="bg-white rounded-lg shadow border p-6 text-left">
                    <div class="text-blue-600 text-3xl mb-4">
                        <i class="fa-regular fa-bell"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Notifikasi Tagihan</h3>
                    <p class="text-sm text-gray-600">Dapatkan pengingat tagihan agar Anda tidak pernah melewatkan tanggal
                        jatuh tempo.</p>
                </div>

                <!-- Fitur 4 -->
                <div class="bg-white rounded-lg shadow border p-6 text-left">
                    <div class="text-blue-600 text-3xl mb-4">
                        <i class="fa-solid fa-shield"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Aman & Terpercaya</h3>
                    <p class="text-sm text-gray-600">Keamanan data Anda adalah prioritas kami. Transaksi Anda dilindungi
                        dengan enkripsi terbaik.</p>
                </div>

                <!-- Fitur 5 -->
                <div class="bg-white rounded-lg shadow border p-6 text-left">
                    <div class="text-blue-600 text-3xl mb-4">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Dukungan 24/7</h3>
                    <p class="text-sm text-gray-600">Tim dukungan kami siap membantu Anda kapan saja, 24 jam sehari, 7 hari
                        seminggu.</p>
                </div>

                <!-- Fitur 6 -->
                <div class="bg-white rounded-lg shadow border p-6 text-left">
                    <div class="text-blue-600 text-3xl mb-4">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Fleksibel</h3>
                    <p class="text-sm text-gray-600">Bayar dari mana saja, kapan saja, menggunakan perangkat apa pun.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 px-6 bg-white">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-10 items-center">
            <!-- Kolom Kiri -->
            <div>
                <span class="inline-block px-4 py-1 mb-3 text-sm font-medium bg-blue-100 text-blue-600 rounded-full">
                    Mengapa Memilih Kami?
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                    Pilihan Terbaik untuk<br>Pembayaran Listrik Anda
                </h2>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Kami berkomitmen untuk menyediakan layanan pembayaran listrik pascabayar yang tidak hanya mudah, tetapi
                    juga memberikan nilai lebih bagi Anda.
                </p>

                <ul class="space-y-6 text-sm text-gray-700">
                    <li class="flex gap-3 items-start">
                        <span class="text-blue-600 text-lg"><i class="fa-solid fa-arrow-right"></i></span>
                        <div>
                            <p class="font-semibold">Tanpa Biaya Tersembunyi</p>
                            <p class="text-gray-600">Nikmati transparansi penuh. Kami tidak membebankan biaya tersembunyi
                                atau biaya tambahan yang tidak diumumkan.</p>
                        </div>
                    </li>
                    <li class="flex gap-3 items-start">
                        <span class="text-blue-600 text-lg"><i class="fa-solid fa-arrow-right"></i></span>
                        <div>
                            <p class="font-semibold">Integrasi Langsung dengan PLN</p>
                            <p class="text-gray-600">Sistem kami terintegrasi langsung dengan PLN, memastikan data tagihan
                                akurat dan pembayaran Anda tercatat secara real-time.</p>
                        </div>
                    </li>
                    <li class="flex gap-3 items-start">
                        <span class="text-blue-600 text-lg"><i class="fa-solid fa-arrow-right"></i></span>
                        <div>
                            <p class="font-semibold">Antarmuka Pengguna Intuitif</p>
                            <p class="text-gray-600">Desain yang bersih dan mudah digunakan memastikan siapa pun dapat
                                melakukan pembayaran tanpa kesulitan.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Kolom Kanan (Gambar/Ilustrasi) -->
            <div class="rounded-xl bg-gray-100 aspect-[4/3] flex items-center justify-center">
                <!-- Placeholder image -->
                <img src="/assets/images/smart_electric.png" class="w-full h-auto rounded-xl" alt="Ilustrasi" />

            </div>
        </div>
    </section>
@endsection
