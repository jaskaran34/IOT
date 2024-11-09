<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\MeasurementType;

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
         Module::create([ 
        'name' => $validatedData['name'], 
        'measurement_type_id' => $validatedData['measurement_type_id'],
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
}
