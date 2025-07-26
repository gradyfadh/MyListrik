<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link rel="shortcut icon" type="image/png" href="./assets/images/logos/favicon.png" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    @stack('scripts')

</head>

<body class="bg-blue-50 font-sans">
    <div class="min-h-screen">
        <!-- Sidebar - Fixed Position -->
        <div class="fixed left-0 top-0 h-full z-40">
            @include('admin.layouts.sidebar')
        </div>

        <!-- Main Content -->
        <main class="ml-[380px]"> <!-- ml-[380px] = w-80 (320px) + ml-10 (40px) + mr-10 (20px) -->
            <!-- Topbar - Fixed Position -->
            <div class="fixed top-0 right-0 z-30 mr-4" style="left: 380px;">
                @include('admin.layouts.topbar')
            </div>

            <!-- Content Area -->
            <div class="pt-24 pb-6 mr-4"> <!-- pt-24 untuk memberikan ruang topbar -->
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
