<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Finish;
use App\Models\Material;
use App\Models\Materialtype;
use App\Models\Quantity;
use App\Models\Reservation;
use App\Models\Supplier;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{

    public function index(Request $request)
    {

        $materials = Material::with(['materialtype','finish']);
        $finishes = Finish::get();
        $materialTypes = Materialtype::query()->get();
        $quantities = Quantity::get();
        $reservations = Reservation::get();

        $materials->when(request('materialtype_id'), function($query) {
            $query->where('materialtype_id', request('materialtype_id'));
        })->when(request('weight'), function($query) {
            $query->where('weight', request('weight'));
        })->when(request('finish'), function($query) {
            $query->where('finish_id', request('finish'));
        });

        return view('warehouse.warehouse.index', [
            'materials' => $materials->whereHas('quantities')->get(),
            'finishes' => $finishes,
            'materialTypes' => $materialTypes,
            'quantities' => $quantities,
            'reservations' => $reservations
        ]);
    }

    public function create(Material $material, Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|numeric|min:1|max:'.$material->max('id')
        ]);

        $reservations = Reservation::get();

        return view('warehouse.warehouse.create',[
            'material' => $material->where('id', $validatedData['id'])->first(),
            'quantities' => Quantity::where('material_id', $validatedData['id'])->get(),
            'suppliers' => Company::where('company_role_id', 4)->orWhere('company_role_id', 5)->orWhere('company_role_id', 1)->get(),
            'reservations' => $reservations->where('material_id', $validatedData['id'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Quantity $quantity)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'material_id' => 'required|numeric',
            'measure' => 'required|string',
            'quantity' => 'required|numeric',
            'description' => 'required|string|max:64',
            'transfer' => 'required|string|min:2|max:3',
            'company_id' => 'required|numeric|min:1'
        ]);

        $material_quantity = $quantity->where('material_id', $validatedData['material_id'])->sum('quantity');
        // dd($material_quantity->sum('quantity'));
        if($validatedData['transfer'] === 'Out') {
            // provera da li bi stanje otišlo u minus
            if(($material_quantity - $validatedData['quantity']) >= 0) {
                $validatedData['quantity'] = 0 - $validatedData['quantity'];
            } else {
                // ukoliko stanje ide u minus izbaciti grešku i vratiti na stranicu unosa
                return redirect()->route('warehouse.create', ['id' => $validatedData['material_id']])->with('error', 'Nema dovoljno materijala na stanju');
            }

        }

        $quantity->create($validatedData);

        return redirect()->route('material.show', $validatedData['material_id'])->with('success', 'Stanje materijala je promenjeno');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {

        $materialTypes =  \App\Models\Materialtype::get();
        $finishes = \App\Models\Finish::get();
        $quantities = \App\Models\Quantity::where('material_id', $material->id)->get();
        return view('warehouse.warehouse.edit', [
            'material' => $material->load('materialtype')->first(),
            'materialTypes' => $materialTypes,
            'finishes' => $finishes,
            'quantities' => $quantities
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function order(Request $request){
        $materials = Material::with(['materialtype','finish']);
        $finishes = Finish::get();
        $materialTypes = Materialtype::query()->get();
        $quantities = Quantity::get();
        $reservations = Reservation::get();

        $materials->when(request('materialtype_id'), function($query) {
            $query->where('materialtype_id', request('materialtype_id'));
        })->when(request('weight'), function($query) {
            $query->where('weight', request('weight'));
        })->when(request('finish'), function($query) {
            $query->where('finish_id', request('finish'));
        });

        return view('warehouse.warehouse.order', [
            'materials' => $materials->whereHas('quantities')->get(),
            'finishes' => $finishes,
            'materialTypes' => $materialTypes,
            'quantities' => $quantities,
            'reservations' => $reservations
        ]);
    }

}
