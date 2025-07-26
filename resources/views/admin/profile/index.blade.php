@extends('admin.index')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Profile Admin</h1>
            <p class="text-gray-600">Kelola informasi akun dan keamanan Anda</p>
        </div>

        <!-- Include Alert Component dengan Fixed Position -->
        <div class="fixed top-4 right-4 z-50 max-w-md">
            @include('components.alert')
        </div>

        <!-- Profile Grid -->
        @if (session('logged_in') && session('level') == 1)
            @php
                $currentUser = \App\Models\User::find(session('logged_id'));
            @endphp
            <div class="grid lg:grid-cols-3 gap-6">
                <!-- Info Profile Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center mb-6">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr($currentUser->nama_admin ?? 'A', 0, 1)) }}
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold text-gray-800">Info Profil</h2>
                            <p class="text-gray-500 text-sm">Data akun Anda</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Nama</label>
                            <p class="text-gray-900 font-medium">{{ $currentUser->nama_admin ?? 'Tidak tersedia' }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Email</label>
                            <p class="text-gray-900 font-medium">{{ $currentUser->email ?? 'Tidak tersedia' }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Role</label>
                            <span
                                class="inline-block bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full font-medium">
                                Administrator
                            </span>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Status Email</label>
                            <span
                                class="inline-block bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">
                                Terverifikasi
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Update Profile Form -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="ti ti-user text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-800">Update Profil</h3>
                            <p class="text-gray-500 text-sm">Perbarui informasi profil</p>
                        </div>
                    </div>

                    @if (session('success_profile'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success_profile') }}
                        </div>
                    @endif

                    @if ($errors->has('nama_admin') || $errors->has('email'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_admin"
                                value="{{ old('nama_admin', $currentUser->nama_admin ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $currentUser->email ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="admin@petirpay.id" required>
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-gray-900 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-800 transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Form -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="ti ti-lock text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-800">Ubah Password</h3>
                            <p class="text-gray-500 text-sm">Perbarui kata sandi akun</p>
                        </div>
                    </div>

                    @if (session('success_password'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success_password') }}
                        </div>
                    @endif

                    @if ($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @if ($errors->has('current_password'))
                                    <li>{{ $errors->first('current_password') }}</li>
                                @endif
                                @if ($errors->has('password'))
                                    <li>{{ $errors->first('password') }}</li>
                                @endif
                                @if ($errors->has('password_confirmation'))
                                    <li>{{ $errors->first('password_confirmation') }}</li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.profile.password.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                            <div class="relative">
                                <input type="password" name="current_password" id="current_password"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-3 pr-12 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Masukkan password saat ini" required>
                                <button type="button" onclick="togglePassword('current_password')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="ti ti-eye-off" id="current_password_icon"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                            <div class="relative">
                                <input type="password" name="password" id="new_password"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-3 pr-12 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Masukkan password baru" required>
                                <button type="button" onclick="togglePassword('new_password')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="ti ti-eye-off" id="new_password_icon"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="confirm_password"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-3 pr-12 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Konfirmasi password baru" required>
                                <button type="button" onclick="togglePassword('confirm_password')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="ti ti-eye-off" id="confirm_password_icon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-gray-900 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-800 transition-colors">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <h4 class="font-semibold">Akses Ditolak</h4>
                <p>Anda harus login sebagai admin untuk mengakses halaman ini.</p>
                <a href="{{ route('login') }}" class="text-red-800 underline font-medium">Klik di sini untuk login</a>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function togglePassword(inputId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(inputId + '_icon');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'ti ti-eye';
                } else {
                    input.type = 'password';
                    icon.className = 'ti ti-eye-off';
                }
            }
        </script>
    @endpush
@endsection
