<?php

namespace Database\Seeders;

use App\Models\Barangay;
use App\Models\Municipality;
use Illuminate\Database\Seeder;

class BarangaySeeder extends Seeder
{
    public function run(): void
    {
        $municipality = Municipality::where('name', 'Luna')->firstOrFail();

        $barangays = [
            // Exact centroid coordinates confirmed April 2026.
            // Household counts sourced from municipal records.
            ['name' => 'Luna',    'latitude' => 18.333209, 'longitude' => 121.354445, 'household_count' => null],
            ['name' => 'Bacsay',  'latitude' => 18.290748, 'longitude' => 121.359264, 'household_count' => 139],
            ['name' => 'Turod',   'latitude' => 18.328254, 'longitude' => 121.352291, 'household_count' => 49],
            ['name' => 'Zumigui', 'latitude' => 18.338661, 'longitude' => 121.351669, 'household_count' => 185],
        ];

        foreach ($barangays as $data) {
            Barangay::updateOrCreate(
                ['name' => $data['name'], 'municipality_id' => $municipality->id],
                array_merge($data, ['municipality_id' => $municipality->id])
            );
        }
    }
}
