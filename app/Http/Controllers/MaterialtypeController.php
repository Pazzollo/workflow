<?php

namespace App\Http\Controllers;

use App\Models\Finish;
use App\Models\Materialtype;
use Illuminate\Http\Request;

class MaterialtypeController extends Controller
{

    public function index()
    {
        return view('warehouse.materialtype.index', [
            'materialTypes' => Materialtype::get()->sortBy('name')
        ]);
    }

    public function create()
    {
        return view('warehouse.materialtype.create', [
            'finishes' => Finish::get(),
            'materialTypes' => Materialtype::get()
        ]);
    }

    public function store(Materialtype $materialtype, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:64'
        ]);

        foreach ($materialtype->get() as $type) {
            if(strtolower($type['name']) == strtolower($validatedData['name'])) {
                return redirect()->route('material_type.create')->with('error', 'Vrsta materijala već postoji!')->with('old_input', $validatedData['name']);
            }
        }

        $materialtype->create($validatedData);

        return redirect()->route('material_type.create')->with('success', 'Nova vrsta materijala je uneta');
    }
    public function show(string $id)
    {
        $materialType = Materialtype::find($id);
        return view('warehouse.materialtype.show', [
            'materialType' => $materialType
        ]);
    }
    public function edit(string $id)
    {
        $materialType = Materialtype::find($id);
        return view('warehouse.materialtype.edit', [
            'materialType' => $materialType
        ]);
    }
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:64'
        ]);

        $materialType = Materialtype::find($id);

        $materialType->update($data);

        return redirect()->route('material_type.show', $materialType)->with('success', 'Vrsta materijala je ažurirana');
    }
    public function destroy(string $id)
    {
        //
    }
}
