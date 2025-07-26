<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayListrik | Pembayaran Listrik Pascabayar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .shadow-sides-bottom {
            box-shadow:
                0 4px 8px rgba(0, 0, 0, 0.1),
                /* bawah */
                -4px 0 8px rgba(0, 0, 0, 0.05),
                /* kiri */
                4px 0 8px rgba(0, 0, 0, 0.05);
            /* kanan */
        }
    </style>
</head>

<body class="bg-white text-gray-800">


    @include('pelanggan.layouts.navbar')

    @yield('content')

    @include('pelanggan.layouts.footer')

    @stack('scripts')

</body>

</html>
