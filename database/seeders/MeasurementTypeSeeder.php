<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MeasurementType;

class MeasurementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $types = ['Temperature', 'Humidity', 'Speed'];
        foreach ($types as $type) {
            MeasurementType::create(['name' => $type]);
        }
    }
}
