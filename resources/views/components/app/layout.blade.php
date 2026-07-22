<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F4F7FB]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'ICAREMU - Intelligent Care Management' }}</title>

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Alpine JS -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            brand: {
                                50: '#EFF6FF',
                                500: '#186EF9',
                                600: '#155DFC',
                                700: '#1D4ED8',
                            },
                            emerald: {
                                500: '#00A86B',
                                600: '#00965E',
                            },
                            appbg: '#F4F7FB'
                        },
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                            heading: ['Plus Jakarta Sans', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
    @endif

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F4F7FB;
            color: #1E293B;
        }
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .card-figma {
            background: #FFFFFF;
            border-radius: 24px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(226, 232, 240, 0.6);
        }
    </style>
</head>
<body class="h-full antialiased text-slate-800 bg-[#F4F7FB] flex">

    <!-- Sidebar persistent (260px wide) -->
    <x-app.sidebar :active="$active ?? 'dashboard-uks'" />

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-y-auto">
        <main class="flex-1 p-6 sm:p-10 max-w-7xl w-full mx-auto space-y-8">
            {{ $slot }}
        </main>
    </div>

</body>
</html>
