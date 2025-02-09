<?php

namespace App\Http\Controllers;

use App\Models\Dimension;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class DimensionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dimensions = Dimension::all();

        return view('warehouse.dimension.index', compact('dimensions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warehouse.dimension.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Dimension $dimension)
    {
        $data = $request->validate([
            'name' => 'required|string|max:32',
            'length' => 'required|numeric|min:3',
            'width' => 'required|numeric|min:3',
            'description' => 'nullable|string|max:64',
        ]);

        if ($dimension->where('name', $data['name'])->exists()) {
            return redirect()->route('dimension.create')
                ->with('error', 'Format sa tim nazivom već postoji.');
        }

        Dimension::create($data);

        return redirect()->route('dimension.index')
            ->with('success', 'Uspešno uneta nova dimenzija.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dimension = Dimension::findOrFail($id);
        return view('warehouse.dimension.show', compact('dimension'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dimension = Dimension::findOrFail($id);
        return view('warehouse.dimension.edit', compact('dimension'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:32',
            'length' => 'required|numeric|min:3',
            'width' => 'required|numeric|min:3',
            'description' => 'nullable|string|max:64',
        ]);

        $dimension = Dimension::findOrFail($id);

        if ($dimension->name !== $data['name'] && $dimension->where('name', $data['name'])->exists()) {
            return redirect()->route('dimension.edit', $id)
                ->with('error', 'Format sa tim nazivom već postoji.');
        }

        $dimension->update($data);

        return redirect()->route('dimension.index')
            ->with('success', 'Uspešno su promenjeni podaci o formatu');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
