@php
    function activeNav($routeName)
    {
        return request()->routeIs($routeName) ? 'bg-orange-500 text-white' : '';
    }
    $pelanggan = \App\Models\Pelanggan::find(session('logged_id'));
@endphp

<nav class="bg-white shadow-sm py-4 px-20 sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center px-4">
        <div class="flex items-center space-x-2">
            <span class="text-xl font-bold text-blue-600">VOLTIX.ID</span>
        </div>

        <!-- Menu Navigasi -->
        <ul class="flex space-x-6 text-sm text-gray-700">
            <li>
                <a href="{{ route('pelanggan.index') }}"
                    class="p-2 rounded-md font-medium hover:bg-orange-500 hover:text-white transition duration-200 {{ activeNav('pelanggan.index') }}">
                    Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('pelanggan.tagihan') }}"
                    class="p-2 rounded-md font-medium hover:bg-orange-500 hover:text-white transition duration-200 {{ activeNav('pelanggan.tagihan') }}">
                    Tagihan
                </a>
            </li>
            <li class="relative group">
                <a
                    class="p-2 rounded-md font-medium hover:bg-orange-500 hover:text-white transition duration-200 {{ request()->routeIs('riwayat-penggunaan') || request()->routeIs('riwayat-pembayaran') ? 'bg-orange-500 text-white' : '' }}">
                    Riwayat
                </a>
                <ul
                    class="absolute hidden group-hover:block z-10 bg-white rounded shadow mt-2 w-48 p-2 space-y-1 border text-sm">
                    <li>
                        <a href="{{ route('riwayat-penggunaan') }}"
                            class="block px-4 py-2 rounded hover:bg-orange-300 {{ activeNav('riwayat-penggunaan') }}">
                            Riwayat Penggunaan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('riwayat-pembayaran') }}"
                            class="block px-4 py-2 rounded hover:bg-orange-300 {{ activeNav('riwayat-pembayaran') }}">
                            Riwayat Pembayaran
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('tarif.listrik.pelanggan') }}"
                    class="p-2 rounded-md font-medium hover:bg-orange-500 hover:text-white transition duration-200 {{ activeNav('tarif.listrik.pelanggan') }}">
                    Tarif Listrik
                </a>
            </li>
        </ul>

        <!-- Dropdown -->
        <div class="relative select-none">
            <details class="group">
                <summary class="flex items-center gap-2 cursor-pointer list-none">
                    <span class="font-semibold text-gray-700 hidden md:inline">
                        {{ $pelanggan->nama_pelanggan ?? 'Pelanggan' }}
                    </span>
                    <!-- Panah -->
                    <svg class="w-4 h-4 text-gray-600 transition-transform duration-200 group-open:rotate-180"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </summary>

                <!-- Menu -->
                <ul
                    class="absolute right-0 mt-2 w-48 bg-red-500 hover:bg-red-600 border shadow-md rounded-md
                   py-2 z-50 text-sm">

                    <li>
                        <form method="POST" action="{{ route('pelanggan.logout') }}">
                            @csrf
                            <button type="submit" class=" w-full text-left px-4 py-2 text-md text-white">Logout
                                <span><i class="fa-solid fa-right-from-bracket text-md"></i></span>
                            </button>
                        </form>
                    </li>
                </ul>
            </details>
        </div>

</nav>
