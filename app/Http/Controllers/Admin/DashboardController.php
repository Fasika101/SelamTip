<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beggar;
use App\Models\Tip;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBeggars   = Beggar::count();
        $totalTips      = Tip::where('status', 'paid')->count();
        $totalAmount    = Tip::where('status', 'paid')->sum('amount');
        $recentTips     = Tip::with('beggar')->where('status', 'paid')->latest()->take(10)->get();

        return view('admin.dashboard', compact('totalBeggars', 'totalTips', 'totalAmount', 'recentTips'));
    }
}
