<?php

namespace App\Http\Controllers;

use App\Models\PsType;
use App\Models\Rental;
use Illuminate\Http\Request;

class PsTypeController extends Controller
{
    public function index()
    {
        $psTypes = PsType::withCount(['rentals as active_rentals' => function($q) {
            $q->where('status', 'active');
        }])->get();
        return view('ps_types.index', compact('psTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:ps_types',
            'price_per_hour' => 'required|integer|min:1000',
            'total_units' => 'required|integer|min:1',
        ]);
        PsType::create($request->all());
        return redirect()->back()->with('success', 'Tipe PS berhasil ditambahkan.');
    }

    public function update(Request $request, PsType $psType)
    {
        $request->validate([
            'price_per_hour' => 'required|integer',
            'total_units' => 'required|integer|min:' . ($psType->active_rentals_count ?? 0),
        ]);
        $psType->update($request->only('price_per_hour', 'total_units'));
        return redirect()->back()->with('success', 'Data PS diperbarui.');
    }

    public function destroy(PsType $psType)
    {
        if ($psType->rentals()->exists()) {
            return redirect()->back()->with('error', 'Tidak bisa dihapus karena masih ada transaksi.');
        }
        $psType->delete();
        return redirect()->back()->with('success', 'Tipe PS dihapus.');
    }
}
