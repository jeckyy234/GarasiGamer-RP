<?php

namespace App\Http\Controllers;

use App\Models\PsType;
use App\Models\Rental;

class DashboardController extends Controller
{
    public function index()
    {
        $psTypes = PsType::with('rentals')->get();
        $totalActive = Rental::where('status', 'active')->count();

        return view('dashboard', compact('psTypes', 'totalActive'));
    }
}
