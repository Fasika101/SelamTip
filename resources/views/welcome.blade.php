<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SelemaTip — Tip with Heart 🇪🇹</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .eth-stripe { background: linear-gradient(90deg, #078930 33.33%, #FCDD09 33.33% 66.66%, #DA121A 66.66%); }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .float { animation: float 3s ease-in-out infinite; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
        .fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; }
        .fade-up-1 { animation-delay: 0.1s; }
        .fade-up-2 { animation-delay: 0.3s; }
        .fade-up-3 { animation-delay: 0.5s; }
    </style>
</head>
<body class="bg-amber-50 overflow-x-hidden">

    <!-- Ethiopian flag stripe -->
    <div class="eth-stripe h-2 w-full"></div>

    <!-- Hero Section -->
    <section class="min-h-screen flex flex-col items-center justify-center px-6 py-20 relative">
        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-5 pointer-events-none"
             style="background-image: radial-gradient(circle at 25px 25px, #b45309 2px, transparent 0); background-size: 50px 50px;"></div>

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <!-- Badge -->
            <div class="fade-up fade-up-1 inline-flex items-center gap-2 bg-amber-100 border border-amber-200 text-amber-800 text-sm font-semibold px-4 py-2 rounded-full mb-8">
                <span class="text-base">🇪🇹</span> Made for Ethiopia
            </div>

            <!-- Headline -->
            <h1 class="fade-up fade-up-1 text-5xl md:text-7xl font-black text-gray-900 leading-tight mb-6">
                Tip with a<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-orange-500">Scan & a Heart</span>
            </h1>

            <p class="fade-up fade-up-2 text-xl text-gray-600 max-w-2xl mx-auto mb-10 leading-relaxed">
                No cash? No problem. Scan a QR code, choose your tip amount, and pay instantly via <strong>Chapa</strong>. Help those in need — one birr at a time.
            </p>

            <!-- CTAs -->
            <div class="fade-up fade-up-3 flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                <a href="{{ route('admin.dashboard') }}"
                   class="px-8 py-4 bg-gradient-to-r from-amber-700 to-amber-600 text-white rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl hover:from-amber-600 hover:to-amber-500 transition-all duration-200">
                    🚀 Admin Panel
                </a>
                <a href="{{ route('admin.beggars.create') }}"
                   class="px-8 py-4 bg-white text-amber-800 rounded-2xl font-bold text-lg shadow-md hover:shadow-lg border-2 border-amber-200 hover:border-amber-400 transition-all duration-200">
                    ➕ Add Profile
                </a>
            </div>

            <!-- Phone mockup / icon row -->
            <div class="fade-up fade-up-3 flex items-center justify-center gap-8 text-6xl float">
                <span>📱</span>
                <span class="text-4xl text-gray-300">→</span>
                <span>🤲</span>
                <span class="text-4xl text-gray-300">→</span>
                <span>❤️</span>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="bg-white py-20 px-6 border-t border-amber-100">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-black text-center text-gray-900 mb-4">How it works</h2>
            <p class="text-center text-gray-500 mb-12">Simple, fast, and compassionate.</p>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach([
                    ['emoji' => '📸', 'step' => '1', 'title' => 'Scan QR', 'desc' => 'Scan the QR code worn or displayed by the person in need.'],
                    ['emoji' => '👤', 'step' => '2', 'title' => 'See Profile', 'desc' => "Their photo, name, and city appear instantly."],
                    ['emoji' => '💳', 'step' => '3', 'title' => 'Choose Amount', 'desc' => 'Pick 10, 20, 50, 100 ETB or enter any amount.'],
                    ['emoji' => '🎟️', 'step' => '4', 'title' => 'Get Lotto #', 'desc' => 'Pay via Chapa and receive a lucky lottery number!'],
                ] as $item)
                <div class="text-center group">
                    <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl group-hover:bg-amber-100 transition-colors border border-amber-100">
                        {{ $item['emoji'] }}
                    </div>
                    <div class="w-6 h-6 bg-amber-700 rounded-full flex items-center justify-center text-white text-xs font-black mx-auto mb-3">{{ $item['step'] }}</div>
                    <h3 class="font-bold text-gray-800 mb-2">{{ $item['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $item['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-amber-900 text-amber-100 py-10 px-6 text-center">
        <div class="text-3xl mb-3">🇪🇹</div>
        <p class="font-bold text-xl mb-1 text-white">SelemaTip</p>
        <p class="text-amber-300 text-sm">Connecting kindness with those who need it most.</p>
        <div class="eth-stripe h-1 w-32 mx-auto mt-6 rounded-full"></div>
    </footer>

</body>
</html>
