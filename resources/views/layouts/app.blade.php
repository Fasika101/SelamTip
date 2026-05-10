<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name') . ' — Tip with Heart')</title>
    <meta name="description" content="{{ config('app.name') }} — Help those in need with a quick mobile tip in Ethiopia.">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        },
                        eth: {
                            green:  '#078930',
                            yellow: '#FCDD09',
                            red:    '#DA121A',
                        }
                    },
                    fontFamily: {
                        display: ['Georgia', 'serif'],
                    },
                    animation: {
                        'fade-in':    'fadeIn 0.6s ease-out',
                        'slide-up':   'slideUp 0.5s ease-out',
                        'bounce-in':  'bounceIn 0.7s ease-out',
                        'spin-slow':  'spin 3s linear infinite',
                    },
                    keyframes: {
                        fadeIn:   { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp:  { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        bounceIn: { '0%': { opacity: '0', transform: 'scale(0.3)' }, '50%': { transform: 'scale(1.05)' }, '100%': { opacity: '1', transform: 'scale(1)' } },
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .eth-stripe { background: linear-gradient(90deg, #078930 33.33%, #FCDD09 33.33% 66.66%, #DA121A 66.66%); }
        .glass { backdrop-filter: blur(16px); background: rgba(255,255,255,0.85); }
        .tip-btn-active { transform: scale(1.05); box-shadow: 0 0 0 3px #b45309; }
    </style>

    @stack('styles')
</head>
<body class="bg-amber-50 min-h-screen">

    @yield('content')

    @stack('scripts')
</body>
</html>
