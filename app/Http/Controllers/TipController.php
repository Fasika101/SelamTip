<?php

namespace App\Http\Controllers;

use App\Models\Beggar;
use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TipController extends Controller
{
    public function show(string $code)
    {
        $beggar = Beggar::where('unique_code', $code)->where('is_active', true)->firstOrFail();
        return view('tip.show', compact('beggar'));
    }

    public function initiate(Request $request, string $code)
    {
        $request->validate([
            'amount'  => 'required|numeric|min:5|max:10000',
            'phone'   => 'required|string|min:9|max:13',
        ]);

        $beggar = Beggar::where('unique_code', $code)->where('is_active', true)->firstOrFail();

        $phone = $request->phone;
        if (!str_starts_with($phone, '+251') && !str_starts_with($phone, '251')) {
            $phone = '251' . ltrim($phone, '0');
        }

        $txRef = 'SELEMA-' . strtoupper(Str::random(12));

        $tip = Tip::create([
            'beggar_id' => $beggar->id,
            'phone'     => $phone,
            'amount'    => $request->amount,
            'tx_ref'    => $txRef,
            'status'    => 'pending',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.chapa.secret_key'),
            'Content-Type'  => 'application/json',
        ])->post('https://api.chapa.co/v1/transaction/initialize', [
            'amount'            => $request->amount,
            'currency'          => 'ETB',
            'phone_number'      => $phone,
            'tx_ref'            => $txRef,
            'return_url'        => route('tip.callback', ['tx_ref' => $txRef]),
            'callback_url'      => route('tip.webhook'),
            'customization'     => [
                'title'       => 'SelemaTip',
                'description' => 'Tip for ' . $beggar->name,
            ],
        ]);

        if ($response->successful() && $response->json('status') === 'success') {
            $checkoutUrl = $response->json('data.checkout_url');
            $tip->update(['chapa_checkout_url' => $checkoutUrl]);
            return redirect($checkoutUrl);
        }

        return back()->with('error', 'Payment initiation failed. Please try again.');
    }

    public function callback(Request $request)
    {
        $txRef = $request->query('tx_ref') ?? $request->input('trx_ref');

        if (!$txRef) {
            return redirect('/')->with('error', 'Invalid payment reference.');
        }

        $tip = Tip::where('tx_ref', $txRef)->firstOrFail();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.chapa.secret_key'),
        ])->get("https://api.chapa.co/v1/transaction/verify/{$txRef}");

        if ($response->successful() && $response->json('data.status') === 'success') {
            $lotto = Tip::generateLottoNumber();
            $tip->update([
                'status'       => 'paid',
                'lotto_number' => $lotto,
            ]);
            return redirect()->route('tip.success', $txRef);
        }

        $tip->update(['status' => 'failed']);
        return redirect()->route('tip.show', $tip->beggar->unique_code)
            ->with('error', 'Payment was not completed. Please try again.');
    }

    public function webhook(Request $request)
    {
        $txRef = $request->input('trx_ref') ?? $request->input('tx_ref');
        if ($txRef) {
            $tip = Tip::where('tx_ref', $txRef)->first();
            if ($tip && $tip->status === 'pending') {
                $lotto = Tip::generateLottoNumber();
                $tip->update(['status' => 'paid', 'lotto_number' => $lotto]);
            }
        }
        return response()->json(['status' => 'ok']);
    }

    public function success(string $txRef)
    {
        $tip = Tip::with('beggar')->where('tx_ref', $txRef)->where('status', 'paid')->firstOrFail();
        return view('tip.success', compact('tip'));
    }
}
