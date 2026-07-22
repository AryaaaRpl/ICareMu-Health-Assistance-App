<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>ICareMu OS — Institutional Health & Intelligence Platform | Seed-Stage SaaS</title>
    <meta name="description" content="ICareMu OS is the premier AI-driven health monitoring, predictive triage, and institutional care coordination platform built for schools, enterprises, and healthcare providers.">
    <meta name="keywords" content="Healthtech SaaS, Institutional Healthcare, Predictive Triage, School Health OS, Enterprise Wellness, Health AI">
    <meta name="author" content="ICareMu Health Technologies Inc.">

    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="ICareMu OS — Next-Gen Institutional Care Coordination">
    <meta property="og:description" content="Empowering 100k+ students and workforce members with predictive AI health screening, instant doctor dispatch, and automated compliance.">
    <meta property="og:image" content="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=1200&auto=format&fit=crop">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="ICareMu OS — Institutional Health SaaS">
    <meta name="twitter:description" content="Seed to Series A Investment Deck & Interactive Product Showcase for Business Competition.">

    <!-- JSON-LD Structured Data for Investors & SEO -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "ICareMu OS",
      "applicationCategory": "HealthApplication",
      "operatingSystem": "Web, Cloud, Cross-platform",
      "offers": {
        "@type": "Offer",
        "price": "499",
        "priceCurrency": "USD"
      },
      "author": {
        "@type": "Organization",
        "name": "ICareMu Health Technologies"
      }
    }
    </script>

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Alpine JS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#EEF2FF',
                            100: '#E0E7FF',
                            500: '#6366F1',
                            600: '#4F46E5',
                            700: '#4338CA',
                            900: '#312E81',
                        },
                        emerald: {
                            400: '#34D399',
                            500: '#10B981',
                            600: '#059669',
                        },
                        darkbg: '#090D16',
                        carddark: '#111827'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>


    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FAFAFA;
        }
        .dark body {
            background-color: #090D16;
        }
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(229, 231, 235, 0.8);
        }
        .dark .glass-panel {
            background: rgba(17, 24, 39, 0.75);
            border: 1px solid rgba(31, 41, 55, 0.8);
        }
        .glow-effect {
            box-shadow: 0 0 50px -10px rgba(99, 102, 241, 0.25);
        }
        .dark .glow-effect {
            box-shadow: 0 0 50px -10px rgba(99, 102, 241, 0.4);
        }
    </style>
</head>
<body class="text-slate-900 dark:text-slate-100 antialiased selection:bg-brand-500 selection:text-white transition-colors duration-300">

    <!-- Accessibility Skip Link -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-brand-600 text-white px-4 py-2 rounded-lg z-50">
        Skip to main content
    </a>

    <!-- Top Scroll Progress Indicator -->
    <div x-data="{ progress: 0 }" 
         x-on:scroll.window="progress = (window.pageYOffset / (document.documentElement.scrollHeight - window.innerHeight)) * 100" 
         class="fixed top-0 left-0 h-1 bg-gradient-to-r from-brand-500 via-emerald-400 to-indigo-600 z-50 transition-all duration-150"
         :style="`width: ${progress}%`"></div>

    <main id="main-content">
        {{ $slot }}
    </main>

    <!-- Floating Utilities: Dark Mode & Back To Top -->
    <div class="fixed bottom-6 right-6 flex flex-col gap-3 z-40" x-data="{ showTop: false }" x-on:scroll.window="showTop = window.pageYOffset > 500">
        <!-- Back To Top -->
        <button x-show="showTop" x-transition 
                @click="window.scrollTo({top: 0, behavior: 'smooth'})"
                class="p-3 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-full shadow-xl border border-slate-200 dark:border-slate-700 hover:scale-110 transition-all focus:outline-none"
                aria-label="Back to top">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
        </button>

        <!-- Dark Mode Switcher -->
        <button x-on:click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" 
                class="p-3.5 bg-white dark:bg-slate-800 text-slate-700 dark:text-amber-400 rounded-full shadow-xl border border-slate-200 dark:border-slate-700 hover:rotate-45 transition-all duration-300 focus:outline-none"
                aria-label="Toggle Theme">
            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </button>
    </div>

</body>
</html>
