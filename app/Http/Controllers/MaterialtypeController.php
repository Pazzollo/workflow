<?php

namespace App\Http\Controllers;

use App\Models\Finish;
use App\Models\Materialtype;
use Illuminate\Http\Request;

class MaterialtypeController extends Controller
{

    public function index()
    {
        //
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
        //
    }
    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        //
    }
    public function destroy(string $id)
    {
        //
    }
}
