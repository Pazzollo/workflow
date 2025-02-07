<?php

namespace App\Http\Controllers;

use App\Models\Finish;
use App\Models\Material;
use App\Models\Materialtype;
use App\Models\Quantity;
use App\Models\Reservation;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {

        $validatedData = $request->validate([
            'materialtype_id' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'finish' => 'nullable|numeric'
        ]);

        $materialTypes =  Materialtype::get();
        $finishes = Finish::get();
        $material = Material::when(isset($validatedData['materialtype_id']), function($query) use($validatedData) {
            $query->where('materialtype_id', $validatedData['materialtype_id']);
        })->when(isset($validatedData['weight']), function($query) use($validatedData) {
            $query->where('weight', $validatedData['weight']);
        })->when(isset($validatedData['finish']), function($query) use($validatedData) {
            $query->where('finish_id', $validatedData['finish']);
        });
        return view('warehouse.materials.index', [
            'materialTypes' => $materialTypes,
            'finishes' => $finishes,
            'materials' => $material->with(['materialtype', 'finish'])->orderBy('materialtype_id')->orderBy('weight')->get()
        ]);
    }
    public function create(Material $material, Finish $finish, Materialtype $materialtype)
    {
        return view('warehouse.materials.create', [
            'materials' => $material->get(),
            'finishes' => $finish->get(),
            'materialTypes' => $materialtype->get()
        ]);
    }
    public function store(Material $materials, Request $request)
    {
        $validatedData = $request->validate([
            'materialtype_id' => 'required|numeric|min:1',
            'brand' => 'required|string|min:2|max:64',
            'finish_id' => 'required|numeric|min:1',
            'width' => 'required|numeric',
            'length' => 'required|numeric',
            'dimension_name' => 'required|string|min:2',
            'weight' => 'required|numeric|min:40',
            'tickness' => 'nullable|numeric|min:40',
            'description' => 'nullable|string|max:64'
        ]);


        foreach ($materials->get() as $material) {
            if($material['materialtype_id'] == $validatedData['materialtype_id']) {
                if(strtolower($material['brand']) == strtolower($validatedData['brand'])) {
                    if($material['finish_id'] == $validatedData['finish_id']) {
                        if($material['width'] == $validatedData['width']) {
                            if($material['length'] == $validatedData['length']) {
                                if($material['weight'] == $validatedData['weight']){
                                    return redirect()->route('material.create')->with('error', 'Materijal sa istim osobinama već postoji!');
                                }
                            }
                        }
                    }
                }
            }
        }

        $materials->create($validatedData);

        return redirect()->route('material.index')->with('success', 'Novi materijal je unet');
    }

    public function show(Material $material)
    {

        $materialTypes =  Materialtype::get();
        $finishes = Finish::get();
        $quantities = Quantity::where('material_id', $material->id)->with('company')->orderBy('created_at', 'desc')->get();
        $reservations = Reservation::where('material_id', $material->id)->get();

        return view('warehouse.materials.show', [
            'material' => $material->load('materialtype'),
            'materialTypes' => $materialTypes,
            'finishes' => $finishes,
            'quantities' => $quantities,
            'reservations' => $reservations
        ]);
    }

    public function edit()
    {

    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function warehouse(Material $warehouse_material, $id)
    {
        $material = $warehouse_material->where('id', $id)->with('materialtype')->first();
        dd($material->materialtype->name);

    }

}
