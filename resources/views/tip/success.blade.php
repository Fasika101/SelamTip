@extends('layouts.app')

@section('title', 'Thank You! — SelemaTip')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-100 flex flex-col overflow-hidden" id="successPage">

    <!-- Ethiopian flag stripe -->
    <div class="eth-stripe h-1.5 w-full flex-shrink-0"></div>

    <!-- Confetti canvas -->
    <canvas id="confetti" class="fixed inset-0 pointer-events-none z-0" style="width:100%;height:100%;"></canvas>

    <div class="flex-1 flex items-center justify-center px-4 py-10 relative z-10">
        <div class="w-full max-w-sm animate-bounce-in">

            <!-- Success card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden text-center">

                <!-- Top gradient -->
                <div class="bg-gradient-to-br from-green-400 to-emerald-600 px-6 py-8 relative">
                    <div class="absolute inset-0 opacity-10"
                         style="background-image: url('data:image/svg+xml,%3Csvg width=\'30\' height=\'30\' viewBox=\'0 0 30 30\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M15 0C6.716 0 0 6.716 0 15s6.716 15 15 15 15-6.716 15-15S23.284 0 15 0zm0 2c7.18 0 13 5.82 13 13S22.18 28 15 28 2 22.18 2 15 7.82 2 15 2z\' fill=\'%23fff\' fill-rule=\'evenodd\'/%3E%3C/svg%3E')">
                    </div>

                    <!-- Success checkmark -->
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white border-opacity-30">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-black text-white mb-1">Thank You!</h1>
                    <p class="text-green-100 text-sm">አመሰግናለሁ · Your kindness matters</p>
                </div>

                <!-- Content -->
                <div class="px-6 pt-6 pb-2">

                    <!-- Amount display -->
                    <div class="bg-amber-50 rounded-2xl px-5 py-4 mb-5">
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-1">You tipped</p>
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-4xl font-black text-brand-800">{{ number_format($tip->amount, 0) }}</span>
                            <span class="text-xl font-bold text-brand-600 self-end pb-1">ETB</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">to <span class="font-semibold text-gray-700">{{ $tip->beggar->name }}</span></p>
                    </div>

                    <!-- Recipient mini profile -->
                    <div class="flex items-center gap-3 bg-gray-50 rounded-2xl px-4 py-3 mb-5">
                        <img src="{{ $tip->beggar->photo_url }}"
                             alt="{{ $tip->beggar->name }}"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($tip->beggar->name) }}&background=b45309&color=fff&size=64'"
                             class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                        <div class="text-left min-w-0">
                            <p class="font-semibold text-gray-800 truncate">{{ $tip->beggar->name }}</p>
                            <p class="text-xs text-gray-400 flex items-center gap-1">
                                <span>🇪🇹</span> {{ $tip->beggar->city }}, Ethiopia
                            </p>
                        </div>
                        <div class="ml-auto flex-shrink-0">
                            <span class="text-2xl">🤝</span>
                        </div>
                    </div>
                </div>

                <!-- Lottery section -->
                <div class="mx-6 mb-6">
                    <div class="relative">
                        <!-- Lottery card -->
                        <div class="bg-gradient-to-br from-brand-800 via-brand-700 to-amber-600 rounded-2xl px-5 py-5 text-white relative overflow-hidden">
                            <!-- Decorative circles -->
                            <div class="absolute -top-4 -right-4 w-20 h-20 bg-white opacity-5 rounded-full"></div>
                            <div class="absolute -bottom-6 -left-6 w-28 h-28 bg-white opacity-5 rounded-full"></div>

                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-amber-200 text-xs font-semibold uppercase tracking-widest">🎟️ Your Lotto Number</span>
                                    <span class="text-xs bg-white bg-opacity-20 rounded-full px-2 py-0.5 text-amber-100">Lucky Draw</span>
                                </div>

                                <div class="text-center py-2">
                                    <p class="text-3xl font-black tracking-[0.2em] text-white drop-shadow-lg" id="lottoNumber">
                                        {{ $tip->lotto_number }}
                                    </p>
                                </div>

                                <p class="text-amber-200 text-xs text-center mt-2">
                                    Keep this number · Draw results announced monthly
                                </p>
                            </div>
                        </div>

                        <!-- Ticket perforations -->
                        <div class="absolute -left-2 top-1/2 -translate-y-1/2 w-4 h-4 bg-amber-50 rounded-full border border-amber-100"></div>
                        <div class="absolute -right-2 top-1/2 -translate-y-1/2 w-4 h-4 bg-amber-50 rounded-full border border-amber-100"></div>
                    </div>
                </div>

                <!-- Transaction ref -->
                <div class="mx-6 mb-6">
                    <p class="text-xs text-gray-400">Transaction: <span class="font-mono text-gray-500">{{ $tip->tx_ref }}</span></p>
                </div>

                <!-- Actions -->
                <div class="px-6 pb-6 flex flex-col gap-3">
                    <a href="{{ route('tip.show', $tip->beggar->unique_code) }}"
                       class="w-full py-3.5 bg-brand-800 hover:bg-brand-700 text-white rounded-2xl font-bold text-sm transition-all duration-200 flex items-center justify-center gap-2 shadow-lg">
                        <span>💝</span> Tip Again
                    </a>
                    <button onclick="shareTip()"
                            class="w-full py-3.5 bg-amber-50 hover:bg-amber-100 text-brand-800 rounded-2xl font-bold text-sm transition-all duration-200 flex items-center justify-center gap-2 border border-amber-200">
                        <span>📤</span> Share the Love
                    </button>
                </div>
            </div>

            <p class="text-center text-xs text-gray-400 mt-6">
                Powered by <span class="font-semibold text-brand-700">SelemaTip</span> · 🇪🇹
            </p>
        </div>
    </div>

    <div class="eth-stripe h-1.5 w-full flex-shrink-0"></div>
</div>
@endsection

@push('scripts')
<script>
// Simple confetti
(function() {
    const canvas = document.getElementById('confetti');
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const colors = ['#f59e0b', '#d97706', '#b45309', '#078930', '#FCDD09', '#DA121A', '#fde68a'];
    const particles = Array.from({ length: 120 }, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height - canvas.height,
        r: Math.random() * 6 + 3,
        d: Math.random() * 120 + 10,
        color: colors[Math.floor(Math.random() * colors.length)],
        tilt: Math.floor(Math.random() * 10) - 10,
        tiltAngle: 0,
        tiltAngleIncremental: (Math.random() * 0.07) + 0.05,
    }));

    let angle = 0;
    let frame = 0;

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        angle += 0.01;
        frame++;

        particles.forEach((p, i) => {
            ctx.beginPath();
            ctx.lineWidth = p.r / 2;
            ctx.strokeStyle = p.color;
            ctx.moveTo(p.x + p.tilt + p.r / 3, p.y);
            ctx.lineTo(p.x + p.tilt, p.y + p.tilt + p.r / 5);
            ctx.stroke();

            p.tiltAngle += p.tiltAngleIncremental;
            p.y += (Math.cos(angle + p.d) + 3 + p.r / 2) / 2;
            p.x += Math.sin(angle);
            p.tilt = Math.sin(p.tiltAngle - (i / 3)) * 15;

            if (p.y > canvas.height) {
                p.x = Math.random() * canvas.width;
                p.y = -10;
            }
        });

        if (frame < 250) requestAnimationFrame(draw);
        else ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    draw();
})();

// Share
function shareTip() {
    const text = "I just tipped {{ $tip->beggar->name }} on SelemaTip! 🇪🇹❤️ Scan their QR code to help too. #SelemaTip #Ethiopia";
    if (navigator.share) {
        navigator.share({ title: 'SelemaTip', text });
    } else {
        navigator.clipboard.writeText(text).then(() => alert('Copied to clipboard!'));
    }
}
</script>
@endpush
