<?php

namespace Database\Seeders;

use App\Models\Tarif;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tarifs = [
            [
                'kode_tarif' => 'R1',
                'daya' => '450',
                'tarifperkwh' => 415.00,
                'deskripsi' => 'Tarif untuk rumah tangga kecil berdaya 450 VA',
            ],
            [
                'kode_tarif' => 'R2',
                'daya' => '900',
                'tarifperkwh' => 605.00,
                'deskripsi' => 'Tarif rumah tangga menengah 900 VA',
            ],
            [
                'kode_tarif' => 'R3',
                'daya' => '1300',
                'tarifperkwh' => 1352.00,
                'deskripsi' => 'Tarif rumah tangga besar 1300 VA',
            ],
            [
                'kode_tarif' => 'B1',
                'daya' => '2200',
                'tarifperkwh' => 1444.70,
                'deskripsi' => 'Tarif untuk bisnis kecil dengan daya 2200 VA',
            ],
            [
                'kode_tarif' => 'B2',
                'daya' => '3500',
                'tarifperkwh' => 1444.70,
                'deskripsi' => 'Tarif untuk bisnis sedang, daya 3500 VA',
            ],
            [
                'kode_tarif' => 'B3',
                'daya' => '6600',
                'tarifperkwh' => 1115.74,
                'deskripsi' => 'Tarif untuk bisnis besar, daya 6600 VA',
            ],
        ];

        foreach ($tarifs as $tarif) {
            Tarif::create($tarif);
        }
    }
}
