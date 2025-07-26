<!-- Topbar -->
<div class="flex justify-between items-center mt-5 bg-white rounded-2xl p-3 mb-10 shadow-md">
    <h1 class="text-2xl font-bold">Administrator</h1>

    <div class="flex items-center gap-4">

        @php
            $currentUser = \App\Models\User::find(session('logged_id'));
        @endphp


        <!-- Avatar -->
        <div
            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
            {{ strtoupper(substr($currentUser->nama_admin ?? 'A', 0, 1)) }}
        </div>

        <!-- Dropdown -->
        <div class="relative select-none">
            <details class="group">
                <summary class="flex items-center gap-2 cursor-pointer list-none">
                    <span class="font-semibold text-gray-700 hidden md:inline">
                        {{ $currentAdmin->nama_admin ?? 'Admin' }}
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
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class=" w-full text-left px-4 py-2 text-md text-white">Logout
                                <span><i class="fa-solid fa-right-from-bracket text-md"></i></span>
                            </button>
                        </form>
                    </li>
                </ul>
            </details>
        </div>
    </div>
</div>
