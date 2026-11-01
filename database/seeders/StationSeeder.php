<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    public function run(): void
    {
        $stations = [
            [
                'name' => 'Manggarai',
                'line_name' => 'Bogor Line',
                'city' => 'Jakarta Selatan',
                'image_url' => null,
            ],
            [
                'name' => 'Tanah Abang',
                'line_name' => 'Rangkasbitung Line',
                'city' => 'Jakarta Pusat',
                'image_url' => null,
            ],
            [
                'name' => 'Bogor',
                'line_name' => 'Bogor Line',
                'city' => 'Bogor',
                'image_url' => null,
            ],
            [
                'name' => 'Bekasi',
                'line_name' => 'Cikarang Line',
                'city' => 'Bekasi',
                'image_url' => null,
            ],
        ];

        foreach ($stations as $station) {
            Station::create($station);
        }
    }
}