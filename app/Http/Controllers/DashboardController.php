<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;

class DashboardController extends Controller
{
    public function showDashboard()
    {

        $totalModules = Module::count();
        $activeModules = Module::where('status', 'active')->count();
        $inactiveModules = Module::where('status', 'inactive')->count();

        //

        $modules = Module::with(['measurementType', 'measurements'])
        ->withCount('measurements')
        ->get()
        ->map(function ($module) {
            $lastMeasurement = $module->measurements->last();
            return [
                'id' => $module->id,
                'name' => $module->name,
                'measurement_type_id' => $module->measurementType->id ?? 'N/A',
                'measurement_type_name' => $module->measurementType->name ?? 'N/A',
                'status' => $module->status,
                'created_at' => $module->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $module->updated_at->format('Y-m-d H:i:s'),
                'measurements_count' => $module->measurements_count,
                'last_measurement_value' => $module->measurements->last()->value ?? 'N/A',
                'last_measurement_timestamp' => $lastMeasurement ? $lastMeasurement->updated_at->format('Y-m-d H:i:s') :'N/A',
                'measurements' => $module->measurements->map(function ($measurement) {
                    return [
                        'id' => $measurement->id,
                        'module_id' => $measurement->module_id,
                        'value' => $measurement->value,
                        'reading_type' => $measurement->reading_type,
                        'created_at' => $measurement->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $measurement->updated_at->format('Y-m-d H:i:s'),
                    ];
                })
            ];
        });
    
              
        //

        return view('dashboard', compact('totalModules', 'activeModules', 'inactiveModules','modules'));
    }

    // Display details for a specific module
    public function showModuleDetails($id)
    {
        $module = Module::with(['measurements' => function ($query) {
            $query->latest()->take(50); // Adjust the limit as needed
        }])->findOrFail($id);

        return view('module.details', compact('module'));
    }

    public function getModuleActivityData()
{
    $moduleData = Module::withCount('measurements') 
    ->orderBy('measurements_count', 'desc') 
    ->take(5)    
    ->get()
        ->map(function ($module) {
            return [
                'name' => $module->name,
                'dataPoints' => $module->measurements_count,
            ];
        });

    return response()->json($moduleData);
}

public function getCombinedData() {
    $modules = Module::with(['measurements']) // Assuming each module has a relationship with measurements
                     ->get();

    // Format the data to return the necessary information
    $data = $modules->map(function ($module) {
        $totalDataPoints = $module->measurements->count(); // Counting the data points
        $averageMeasurement = $module->measurements->avg('value'); // Average of measurement values
        
        return [
            'name' => $module->name,
            'total_data_points' => $totalDataPoints,
            'average_measurement' => $averageMeasurement,
        ];
    });

    return response()->json($data);
}
}
