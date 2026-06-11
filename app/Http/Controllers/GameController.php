<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\PsType;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $psTypes = PsType::with('games')->get();
        return view('games.index', compact('psTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ps_type_id' => 'required|exists:ps_types,id',
            'name' => 'required|string|max:255',
        ]);
        Game::create($request->only('ps_type_id', 'name'));
        return redirect()->back()->with('success', 'Game ditambahkan.');
    }

    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->back()->with('success', 'Game dihapus.');
    }
}
