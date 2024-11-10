<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\MeasurementType;
use App\Models\StatusMonitoring;
use Illuminate\Support\Facades\Artisan;
use App\Models\SkippedModule;
use Carbon\Carbon;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = MeasurementType::all();
        $modules = Module::with('data')->get();
        return view('modules.index', compact('modules','types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $modules = Module::with('MeasurementType')
        ->orderBy('updated_at', 'desc')
        ->get()
        ->map(function ($module) {
            return [
                'id' => $module->id,
                'name' => $module->name,
                'measurement_type_id' => $module->MeasurementType->id ?? 'N/A',
                'measurement_type_name' => $module->MeasurementType->name ?? 'N/A',
                'status' => $module->status,
                'updated_at' => $module->updated_at->format('Y-m-d H:i:s'), // Format as needed
            ];
        });
        //return $modules;
        $measurementTypes = MeasurementType::all();
        return view('modules.create', compact('measurementTypes','modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
        //return $request;
        $validatedData = $request->validate([ 
        'name' => 'required|string|max:255', 
        'measurement_type_id' => 'required|exists:measurement_types,id', ]);

       // return $validatedData['measurement_type_id'];
       $module = Module::create([ 
        'name' => $validatedData['name'], 
        'measurement_type_id' => $validatedData['measurement_type_id'],
     ]);

     StatusMonitoring::create([
        'module_id' => $module->id,
        'status' => 'active',
    ]);

    return redirect()->route('modules.index')->with('success', 'Module registered successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        //
    }
    public function getAllModules($id)
    {
        if($id==0){
        $modules = Module::all(); // Fetch all modules, with relevant data if needed

    // Return JSON data with selected fields
    return response()->json($modules->map(function ($module) {
        return [
            'id' => $module->id,
            'name' => $module->name,
            'status' => $module->status,
            'created_at' => $module->created_at->diffforhumans(),
            'updated_at' => $module->updated_at->diffforhumans(),
        ];
    }));
    
        }

        if($id==1){
            $modules = Module::where('status', 'active')->get(); // Fetch all modules, with relevant data if needed
    
        // Return JSON data with selected fields
        return response()->json($modules->map(function ($module) {
            return [
                'id' => $module->id,
                'name' => $module->name,
                'status' => $module->status,
                'created_at' => $module->created_at->diffforhumans(),
                'updated_at' => $module->updated_at->diffforhumans(),
            ];
        }));
        
            }

            if($id==2){
                $modules = Module::where('status', 'inactive')->get(); // Fetch all modules, with relevant data if needed
        
            // Return JSON data with selected fields
            return response()->json($modules->map(function ($module) {
                return [
                    'id' => $module->id,
                    'name' => $module->name,
                    'status' => $module->status,
                    'created_at' => $module->created_at->diffforhumans(),
                    'updated_at' => $module->updated_at->diffforhumans(),
                ];
            }));
            
                }
}
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'measurement_type_id' => 'required|exists:measurement_types,id',
            'status' => 'required|string|in:active,inactive',
        ]);
    
        // Find the module by ID
        $module = Module::findOrFail($id);
    
        // Update the module fields with validated data
        $module->name = $validatedData['name'];
        $module->measurement_type_id = $validatedData['measurement_type_id'];
        $module->status = $validatedData['status'];
    
        // Save the updated module to the database
        $module->save();

        $latestStatus = StatusMonitoring::where('module_id', $id) ->orderBy('created_at', 'desc') ->first();

        if (is_null($latestStatus) || $latestStatus->status !== $validatedData['status']) {
        StatusMonitoring::create([
            'module_id' => $id,
            'status' => $validatedData['status'],
        ]);
    
    }
        // Redirect back to the module list page with a success message
        return redirect()->route('modules.index')->with('info', 'Module updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $type = Module::findOrFail($id);
        $type->delete();

      return redirect()->route('modules.index')->with('warning', 'Module deleted successfully!');
    }

    public function updateModuleStatus(Request $request)
    {
        // Run the artisan command and capture the output
        Artisan::call('update-module-status');  // Run your custom command

        // Get the output of the command
        $output = Artisan::output();

        session()->flash('formSubmitted', true);

        // Return a response to the view with the command output
        return redirect()->back()->with('success', 'Module status updated successfully.')
            ->with('output', $output);  // Pass the output to the view
    }
    public function module_stat(){

        $totalModules = Module::count();
        $activeModules = Module::where('status', 'active')->count();
        $inactiveModules = Module::where('status', 'inactive')->count();

        $modules = Module::all();

        return view('modules.index', compact('totalModules', 'activeModules', 'inactiveModules', 'modules'));
    
    }
    public function updateStatus($id,$status)
{
    $skippedModule = SkippedModule::findOrFail($id);

    // Update the status (e.g., 'resolved' or 'ignored')
    $skippedModule->status = $status;
    $skippedModule->save();

    // Redirect back with a success message
    return redirect()->back()->with('status', 'Module status updated successfully.');
}
    public function skipped_modules()
    {
        // Fetch all skipped modules, with optional pagination if needed
        $skippedModules = SkippedModule::where('status', 'pending')->get(); // or ->paginate(10);

        // Return the view with the skipped modules data
        return view('skippedModules.index', compact('skippedModules'));
    }
    public function simulateMalfunction()
{
    // Run the Artisan command to simulate the module malfunction
    Artisan::call('simulate:module-malfunction');

    // Capture the output of the Artisan command
    $message = Artisan::output();

    // Return the output message to the frontend
    return response()->json([
        'status' => 'success',
        'message' => $message // Send the command output as a message
    ]);
}
    
    public function showStatus(Request $request)
    {
        $module = Module::findOrFail($request->module_id);
        $statusMonitorings = StatusMonitoring::where('module_id', $module->id)
                                             ->orderBy('created_at', 'desc')
                                             ->take(10)
                                             ->get();
    
        $previousStatus = null;
    
        foreach ($statusMonitorings as $status) {
            $statusCreatedAt = Carbon::parse($status->created_at);
    
            if ($status->is($statusMonitorings->first())) {
                // For the latest status, calculate the time difference from now
                $status->time_in_status = $statusCreatedAt->diffForHumans(Carbon::now(), true);
            } else {
                // If this is not the first record, calculate the difference from the previous status
                if ($previousStatus) {
                    if ($status->status == 'active') {
                        // If the status is "active", calculate the difference from the previous status (which is "inactive")
                        $status->time_in_status = $previousStatus->created_at->diffForHumans($statusCreatedAt, true);
                    } elseif ($status->status == 'inactive') {
                        // If the status is "inactive", calculate the difference from the previous "active" status
                        $status->time_in_status = $previousStatus->created_at->diffForHumans($statusCreatedAt, true);
                    }
                }
            }
    
            // Update previous status for next iteration
            $previousStatus = $status;
        }
    
        return response()->json($statusMonitorings);
    }
    

 

}
