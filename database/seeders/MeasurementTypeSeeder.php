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
        $types = [ 'Pressure', 'Volume', 'Mass', 'Length', 'Area', 'Energy', 'Power', 'Time', 'Frequency', 'Current', 'Voltage', 'Resistance', 'Density', 'Flow Rate', 'Light Intensity', 'Sound Level', 'pH Level', 'Viscosity'];
        foreach ($types as $type) {
            MeasurementType::create(['name' => $type]);
        }
    }
}
