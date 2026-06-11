<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PsType;
use App\Models\Game;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Garasi',
            'email' => 'admin@garasigamer.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        $ps3 = PsType::create(['name' => 'PS3', 'price_per_hour' => 8000, 'total_units' => 2]);
        $ps4 = PsType::create(['name' => 'PS4', 'price_per_hour' => 10000, 'total_units' => 3]);
        $ps5 = PsType::create(['name' => 'PS5', 'price_per_hour' => 15000, 'total_units' => 2]);
        $rentals = App\Models\Rental::whereNull('unit_number')->get();
foreach($rentals as $rental) {
    $rental->unit_number = 1; // atau sesuaikan
    $rental->save();
}

        $games = [
            $ps3->id => ['GTA SA', 'BULLY', 'DownHill', 'WinningEleven', 'Lego Batman'],
            $ps4->id => ['PES 2026', 'GTA V', 'COD', 'WarCRY6', 'RDR2'],
            $ps5->id => ['FC26', 'UFC', 'WWE', 'NBA', 'Minecraft', 'GTA V rp'],
        ];


        foreach ($games as $psId => $gameList) {
            foreach ($gameList as $gameName) {
                Game::create(['ps_type_id' => $psId, 'name' => $gameName]);
            }
        }
    }
}
