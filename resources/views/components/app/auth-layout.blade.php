<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F4F7FB]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'ICAREMU - Authentication' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            brand: { 500: '#186EF9' },
                            emerald: { 500: '#00A86B' }
                        },
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                            heading: ['Plus Jakarta Sans', 'sans-serif']
                        }
                    }
                }
            }
        </script>
    @endif

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F4F7FB; }
        h1, h2, h3, h4, .font-heading { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full antialiased text-slate-800 bg-[#F4F7FB] flex flex-col justify-center items-center p-4">

    <!-- iCareMu Logo Header -->
    <div class="mb-6 flex flex-col items-center">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500 flex items-center justify-center text-white font-bold text-2xl shadow-md">
                +
            </div>
            <div class="flex flex-col">
                <span class="font-heading font-extrabold text-3xl tracking-tight text-[#006654]">
                    iCare<span class="text-[#00A86B]">Mu</span>
                </span>
                <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Sehat • Peduli • Berkemajuan</span>
            </div>
        </div>
    </div>

    <!-- Centered Card Box -->
    <div class="w-full max-w-lg bg-white rounded-3xl p-8 sm:p-10 shadow-[0_4px_25px_rgba(0,0,0,0.04)] border border-slate-200/80">
        {{ $slot }}
    </div>

</body>
</html>
