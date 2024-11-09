<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MeasurementType;
use Carbon\Carbon;

class ModuleTypeController extends Controller
{
    public function index()
    {
        $types = MeasurementType::all();
        return view('module-types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:measurement_types',
        ]);


        MeasurementType::create([
            'name' => $request->name,
        ]);

        return redirect()->route('module-types.index')->with('success', 'Module type added successfully!');
    
        }

        public function destroy($id)
{
    $type = MeasurementType::findOrFail($id);
    $type->delete();

    return redirect()->route('module-types.index')->with('warning', 'Module type deleted successfully!');
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $measurementType = MeasurementType::findOrFail($id);
    $measurementType->name = $request->name;
    $measurementType->save();

    return redirect()->back()->with('info', 'Measurement Type name updated successfully!');
}
}
