<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beggar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BeggarController extends Controller
{
    public function index()
    {
        $beggars = Beggar::withCount(['tips as paid_tips_count' => function ($q) {
            $q->where('status', 'paid');
        }])->withSum(['tips as total_received' => function ($q) {
            $q->where('status', 'paid');
        }], 'amount')->latest()->get();

        return view('admin.beggars.index', compact('beggars'));
    }

    public function create()
    {
        return view('admin.beggars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'city'  => 'required|string|max:100',
            'bio'   => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only('name', 'city', 'bio');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('beggars', 'public');
        }

        $beggar = Beggar::create($data);

        return redirect()->route('admin.beggars.show', $beggar)
            ->with('success', 'Profile created successfully!');
    }

    public function show(Beggar $beggar)
    {
        $tips = $beggar->tips()->where('status', 'paid')->latest()->take(20)->get();
        $qrCode = QrCode::format('svg')
            ->size(250)
            ->color(146, 64, 14)
            ->backgroundColor(255, 251, 235)
            ->generate(route('tip.show', $beggar->unique_code));

        return view('admin.beggars.show', compact('beggar', 'tips', 'qrCode'));
    }

    public function edit(Beggar $beggar)
    {
        return view('admin.beggars.edit', compact('beggar'));
    }

    public function update(Request $request, Beggar $beggar)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'city'      => 'required|string|max:100',
            'bio'       => 'nullable|string|max:500',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->only('name', 'city', 'bio');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('photo')) {
            if ($beggar->photo) {
                Storage::disk('public')->delete($beggar->photo);
            }
            $data['photo'] = $request->file('photo')->store('beggars', 'public');
        }

        $beggar->update($data);

        return redirect()->route('admin.beggars.show', $beggar)
            ->with('success', 'Profile updated successfully!');
    }

    public function destroy(Beggar $beggar)
    {
        if ($beggar->photo) {
            Storage::disk('public')->delete($beggar->photo);
        }
        $beggar->delete();
        return redirect()->route('admin.beggars.index')->with('success', 'Profile deleted.');
    }

    public function qrDownload(Beggar $beggar)
    {
        $qrCode = QrCode::format('svg')
            ->size(600)
            ->margin(2)
            ->color(146, 64, 14)
            ->generate(route('tip.show', $beggar->unique_code));

        return response($qrCode)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="qr-' . $beggar->unique_code . '.svg"');
    }
}
