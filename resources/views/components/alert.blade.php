<!-- Alert Success dengan Auto Hide -->
@if (session('success'))
    <div id="successAlert"
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-lg"
        role="alert">
        <strong class="font-bold">Berhasil!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg onclick="closeAlert('successAlert')" class="fill-current h-6 w-6 text-green-500 cursor-pointer"
                role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
@endif

<!-- Alert Error dengan Auto Hide -->
@if (session('error'))
    <div id="errorAlert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 shadow-lg"
        role="alert">
        <strong class="font-bold">Gagal!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg onclick="closeAlert('errorAlert')" class="fill-current h-6 w-6 text-red-500 cursor-pointer"
                role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
@endif

<!-- Alert Warning dengan Auto Hide -->
@if (session('warning'))
    <div id="warningAlert"
        class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4 shadow-lg"
        role="alert">
        <strong class="font-bold">Perhatian!</strong>
        <span class="block sm:inline">{{ session('warning') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg onclick="closeAlert('warningAlert')" class="fill-current h-6 w-6 text-yellow-500 cursor-pointer"
                role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
@endif

<!-- Alert Info dengan Auto Hide -->
@if (session('info'))
    <div id="infoAlert"
        class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4 shadow-lg"
        role="alert">
        <strong class="font-bold">Informasi!</strong>
        <span class="block sm:inline">{{ session('info') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg onclick="closeAlert('infoAlert')" class="fill-current h-6 w-6 text-blue-500 cursor-pointer"
                role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
@endif

<!-- Alert untuk Validation Errors -->
@if ($errors->any())
    <div id="validationAlert"
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 shadow-lg" role="alert">
        <strong class="font-bold">Terjadi Kesalahan!</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg onclick="closeAlert('validationAlert')" class="fill-current h-6 w-6 text-red-500 cursor-pointer"
                role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
@endif

<script>
    // Fungsi untuk menutup alert secara manual dengan animasi slide-up
    function closeAlert(alertId) {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.style.transition = 'transform 0.3s ease-out, opacity 0.3s ease-out';
            alert.style.transform = 'translateX(100%)';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }
    }

    // Auto hide alerts setelah 5 detik dengan animasi slide-in
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = ['successAlert', 'errorAlert', 'warningAlert', 'infoAlert', 'validationAlert'];

        alerts.forEach(alertId => {
            const alert = document.getElementById(alertId);
            if (alert) {
                // Tambahkan animasi slide-in dari kanan
                alert.style.transform = 'translateX(100%)';
                alert.style.opacity = '0';
                alert.style.transition = 'transform 0.3s ease-in, opacity 0.3s ease-in';

                setTimeout(() => {
                    alert.style.transform = 'translateX(0)';
                    alert.style.opacity = '1';
                }, 100);

                // Auto hide setelah 5 detik
                setTimeout(() => {
                    closeAlert(alertId);
                }, 5000);
            }
        });
    });
</script>
