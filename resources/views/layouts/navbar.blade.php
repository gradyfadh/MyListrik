<nav class="bg-white shadow-sm py-4 px-20 sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center px-4">
        <div class="flex items-center space-x-2">
            <a href="#" class="text-xl font-bold text-blue-500">MyListrik</a>
        </div>

        <div class="space-x-2">
            <a href="{{ route('pelanggan.register.form') }}"
                class="border border-blue-500 text-blue-500 px-4 py-2 rounded-md hover:bg-blue-100 text-sm font-semibold transition duration-200">Daftar</a>
            <a href="{{ route('pelanggan.login') }}"
                class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 text-sm font-semibold transition duration-200">Login</a>
        </div>
    </div>
</nav>
