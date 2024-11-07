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
        //
        $modules = Module::with('data')->get();
        return view('modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $measurementTypes = MeasurementType::all();
        return view('modules.create', compact('measurementTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'measurement_type_id' => 'required|exists:measurement_types,id',
    ]);

    Module::create($request->only('name', 'measurement_type_id'));

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
    public function update(Request $request, Module $module)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        //
    }
}
