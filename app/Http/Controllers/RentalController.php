<?php

namespace App\Http\Controllers;

use App\Models\PsType;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    // Menampilkan form sewa
    public function create()
    {
        $psTypes = PsType::all();
        return view('rentals.create', compact('psTypes'));
    }

    // Mendapatkan daftar unit yang tersedia untuk PS tertentu (AJAX)
    public function getAvailableUnits($psTypeId)
    {
        $psType = PsType::findOrFail($psTypeId);
        $usedUnits = Rental::where('ps_type_id', $psTypeId)
            ->where('status', 'active')
            ->pluck('unit_number')
            ->toArray();

        $availableUnits = [];
        for ($i = 1; $i <= $psType->total_units; $i++) {
            if (!in_array($i, $usedUnits)) {
                $availableUnits[] = [
                    'number' => $i,
                    'name'   => $psType->name . ' Unit ' . $i,
                ];
            }
        }

        return response()->json(['units' => $availableUnits]);
    }

    // Menyimpan transaksi sewa baru
    public function store(Request $request)
    {
        $request->validate([
            'ps_type_id'     => 'required|exists:ps_types,id',
            'unit_number'    => 'required|integer',
            'customer_name'  => 'required|string|max:255',
            'duration_hours' => 'required|numeric|min:0.5',
        ]);

        $psType = PsType::find($request->ps_type_id);

        // Cek apakah unit sudah dipakai (redundant, tapi aman)
        $existing = Rental::where('ps_type_id', $psType->id)
            ->where('unit_number', $request->unit_number)
            ->where('status', 'active')
            ->exists();

        if ($existing) {
            return redirect()->back()->with('error', 'Unit sudah digunakan, pilih unit lain.');
        }

        $totalPrice = $psType->price_per_hour * $request->duration_hours;

        Rental::create([
            'ps_type_id'    => $psType->id,
            'unit_number'   => $request->unit_number,
            'customer_name' => $request->customer_name,
            'duration_hours'=> $request->duration_hours,
            'total_price'   => $totalPrice,
            'rental_date'   => Carbon::now(),
            'status'        => 'active',
        ]);

        return redirect()->route('admin.rentals.history')
            ->with('success', 'Transaksi berhasil! Unit ' . $request->unit_number . ' disewa.');
    }

    // Menampilkan riwayat transaksi dengan filter
    public function history(Request $request)
    {
        $query = Rental::with('psType');

        if ($request->filled('date')) {
            $query->whereDate('rental_date', $request->date);
        }
        if ($request->filled('hour') && $request->hour !== '') {
            $query->whereRaw('HOUR(rental_date) = ?', [$request->hour]);
        }
        if ($request->filled('ps_type_id')) {
            $query->where('ps_type_id', $request->ps_type_id);
        }

        $rentals = $query->orderBy('rental_date', 'desc')->get();
        $psTypes = PsType::all();

        return view('rentals.history', compact('rentals', 'psTypes'));
    }

    // Menandai rental selesai (pengembalian)
    public function return(Rental $rental)
    {
        if ($rental->status === 'active') {
            $rental->update(['status' => 'completed']);
            return redirect()->back()->with('success', 'PS berhasil dikembalikan.');
        }
        return redirect()->back()->with('error', 'Transaksi sudah selesai.');
    }
}
