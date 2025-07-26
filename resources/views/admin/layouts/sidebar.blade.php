<aside class="w-80 h-full bg-white shadow-md rounded-t-3xl ml-10 mt-5 overflow-hidden">
    <div class="sticky top-0 bg-white p-6 text-xl font-bold text-indigo-700 flex items-center gap-2 z-10">
        Voltix Admin
    </div>
    <nav class=" w-full flex flex-col sidebar-nav px-4">
        <ul id="sidebarnav" class="text-gray-600 text-sm in overflow-y-auto max-h-[calc(100vh-100px)] pr-2">
            <li class="text-xs font-bold pb-[5px]">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">HOME</span>
            </li>

            <li class="sidebar-item selected">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full  hover:bg-blue-100 transition duration-300 {{ request()->routeIs('dashboard.index') ? 'bg-blue-100 font-semibold' : '' }}"
                    href="{{ route('admin.dashboard.index') }}">
                    <i class="ti ti-layout-dashboard ps-2  text-2xl"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item selected">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full  hover:bg-blue-100 transition duration-300 {{ request()->routeIs('dashboard.index') ? 'bg-blue-100 font-semibold' : '' }}"
                    href="{{ route('landing-page') }}">
                    <i class="ti ti-layout-dashboard ps-2  text-2xl"></i> <span>Website Utama</span>
                </a>
            </li>

            <li class="text-xs font-bold mb-4 mt-6">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">Harga Listrik</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full hover:bg-blue-100 transition duration-300 {{ request()->routeIs('tarif.index') ? 'bg-blue-100 font-semibold' : '' }}"
                    href="{{ route('tarif.index') }}">
                    <i class="ti ti-receipt-dollar ps-2 text-2xl"></i> <span>Tarif Layanan</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full hover:bg-blue-100 transition duration-300 {{ request()->routeIs('metode.*') ? 'bg-blue-100 font-semibold' : '' }}"
                    href="{{ route('metode.index') }}">
                    <i class="fa-solid fa-money-check-dollar ps-2 text-xl"></i> <span>Metode Pembayaran</span>
                </a>
            </li>

            <li class="text-xs font-bold mb-4 mt-6">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">Pelanggan</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full hover:bg-blue-100 transition duration-300 {{ request()->routeIs('admin.pelanggan.konfirmasi') ? 'bg-blue-100 font-semibold' : '' }}"
                    href="{{ route('admin.pelanggan.konfirmasi') }}">
                    <i class="ti ti-users-plus ps-2 text-2xl"></i> <span>Konfirmasi Pelanggan</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full hover:bg-blue-100 transition duration-300 {{ request()->routeIs('admin.pelanggan.index') ? 'bg-blue-100 font-semibold' : '' }}"
                    href="{{ route('admin.pelanggan.index') }}">
                    <i class="ti ti-users ps-2 text-2xl"></i> <span>Pelanggan Aktif</span>
                </a>
            </li>

            <li class="text-xs font-bold mb-4 mt-6">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">Tagihan & Pembayaran</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full hover:bg-blue-100 transition duration-300 {{ request()->routeIs('admin.penggunaan.index') ? 'bg-blue-100 font-semibold' : '' }}"
                    href="{{ route('admin.penggunaan.index') }}">
                    <i class="ti ti-chart-bar ps-2 text-2xl"></i> <span>Input Penggunaan</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full hover:bg-blue-100 transition duration-300 {{ request()->routeIs('admin.tagihan.index') ? 'bg-blue-100 font-semibold' : '' }}"
                    href="{{ route('admin.tagihan.index') }}">
                    <i class="ti ti-coin ps-2 text-2xl"></i> <span>Tagihan Pelanggan</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full hover:bg-blue-100 transition duration-300 {{ request()->routeIs('admin.pembayaran.index') ? 'bg-blue-100 font-semibold' : '' }}"
                    href="{{ route('admin.pembayaran.index') }}">
                    <i class="ti ti-cash ps-2 text-2xl"></i> <span>Riwayat Pembayaran</span>
                </a>
            </li>

            <li class="text-xs font-bold mb-4 mt-6">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">PENGATURAN</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full hover:bg-blue-100 transition duration-300 {{ request()->routeIs('admin.profile.index') ? 'bg-blue-100 font-semibold' : '' }}"
                    href="{{ route('admin.profile.index') }}">
                    <i class="ti ti-user-cog ps-2 text-2xl"></i> <span>Edit Profile</span>
                </a>
            </li>

        </ul>
    </nav>

    <!-- Hidden Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</aside>
