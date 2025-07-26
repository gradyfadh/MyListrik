<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VoltPay</title>
    <!-- CSS -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css_admin/sb-admin-2.min.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden w-full max-w-4xl grid grid-cols-1 md:grid-cols-2">

            <!-- Kiri: Form Login -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-[#ff654d] mb-1 text-center">⚡ Voltix Admin</h2>
                <p class="text-center text-sm text-gray-500 mb-6">Masuk ke akun Anda untuk mengakses layanan</p>

                <!-- Include Alert Component dengan Fixed Position -->
                <div class="fixed top-4 right-4 z-50 max-w-md">
                    @include('components.alert')
                </div>

                <form action="{{ route('login.attempt') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <input type="email" name="email" placeholder="Email"
                            class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]"
                            required autofocus>
                    </div>

                    <div class="mb-4">
                        <input type="password" name="password" placeholder="Kata Sandi"
                            class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]"
                            required>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit"
                        class="w-full bg-[#ff654d] text-white py-2.5 mt-2 rounded-full font-semibold hover:bg-[#e14b3b] transition">
                        Masuk sebagai Admin
                    </button>

                    <div class="mt-4 flex justify-between text-sm">
                        <a href="{{ url('/') }}" class="text-gray-600 hover:text-[#ff654d]">&larr; Beranda</a>
                        <a href="{{ route('register') }}" class="text-[#ff654d] hover:underline">Belum punya akun?
                            Daftar</a>
                    </div>

                    <div class="mt-3 text-center">
                        <a href="{{ route('pelanggan.login') }}" class="text-gray-500 hover:text-[#ff654d] text-sm">
                            Login sebagai Pelanggan
                        </a>
                    </div>
                </form>


            </div>

            <!-- Kanan: Branding -->
            <div
                class="bg-gradient-to-br from-[#ff654d] to-[#ff7e66] text-white flex flex-col justify-center items-center p-8">
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">∞ Voltix</div>
                    <p class="text-sm max-w-xs">
                        Login dan mulai kelola tagihan listrik pascabayar Anda secara praktis dan aman.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
