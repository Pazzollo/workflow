<?php

namespace App\Http\Controllers;

use App\Models\Finish;
use App\Models\Material;
use App\Models\Materialtype;
use App\Models\Quantity;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{

    public function index()
    {
        //
    }

    public function create(Material $material, Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|numeric|min:1|max:'.$material->max('id')
        ]);

        if(auth()->user()->role_id === 5) {
            return redirect()->route('reservation.show', $validatedData['id'])
                ->with('error', 'Nemate pravo na rezervaciju');
        }

        return view('warehouse.reservations.create',[
            'material' => $material->where('id', $validatedData['id'])->first(),
            'quantities' => Quantity::where('material_id', $validatedData['id'])->get(),
            'reservations' => Reservation::where('material_id', $validatedData['id'])->get()
        ]);
    }

    public function store(Request $request, Reservation $reservation)
    {
        $validatedData = $request->validate([
            'material_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'description' => 'required|string|max:32'
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['reserved'] = 1;
        // dd($validatedData);

        $reservation->create($validatedData);

        return redirect()->route('reservation.show', $validatedData['material_id'])
            ->with('success', 'Materijal stavljen na rezervaciju');

    }

    public function show($material_id)
    {
        $materialTypes =  Materialtype::get();
        $finishes = Finish::get();
        $quantities = Quantity::where('material_id', $material_id)->with('company')->orderBy('created_at', 'desc')->get();
        $reservations = Reservation::where('material_id', $material_id)->with(['material', 'user'])->orderBy('created_at', 'desc')->get();
        $material = Material::where('id', $material_id)->with('materialtype')->first();

        return view('warehouse.reservations.show', [
            'material' => $material,
            'materialTypes' => $materialTypes,
            'finishes' => $finishes,
            'quantities' => $quantities,
            'reservations' => $reservations
        ]);
    }

    public function edit($id)
    {
        $reservation = Reservation::where('id', $id)->where('reserved', 1)->with(['material', 'user'])->first();
        // dd($reservation);
        if($reservation->user_id != auth()->user()->id) {
            return redirect()->route('reservation.show', $reservation->material_id)
                ->with('error', 'Rezervaciju može izmeniti samo '. $reservation->user->name);
        }
        $material = Material::where('id', $reservation->material_id)->with('materialtype')->first();
        $quantities = Quantity::where('material_id', $reservation->material_id)->orderBy('created_at', 'desc')->get();
        return view('warehouse.reservations.edit', [
            'reservation' => $reservation,
            'material' => $material,
            'quantities' => $quantities
        ]);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|numeric',
            'description' => 'required|string|max:32',
            'material_id' => 'required|numeric'
        ]);
        if($reservation->user_id != auth()->user()->id) {
            return redirect()->route('reservation.show', $reservation->material_id)
                ->with('error', 'Rezervaciju može izmeniti samo '. $reservation->user->name);
        }
        $reservation->update($validatedData);

        return redirect()->route('reservation.show', $reservation->material_id)
            ->with('success', 'Rezervacija je izmenjena');
    }

    public function destroy(Request $request, Reservation $reservation, Quantity $quantity)
    {
        $item_quantity = $quantity->where('material_id', $reservation->material_id)->sum('quantity');
        $update['reserved'] = 0;

        if(isset($request['delete'])){
            if($reservation->user_id == auth()->user()->id) {
                $reservation->update($update);
                return redirect()->route('reservation.show', $reservation->material_id)->with('success', 'Rezervacija je uklonjena');
            } else return redirect()->route('reservation.show', $reservation->material_id)->with('error', 'Rezervaciju može poništiti samo '. $reservation->user->first_name . ' ' . $reservation->user->last_name);
        } elseif(isset($request['reserve'])) {
            if(auth()->user()->role_id === 5 || auth()->user()->role_id === 1) {
                try {
                    $data['material_id'] = $reservation->material_id;
                    $data['quantity'] = 0 - $reservation->quantity;
                    $data['description'] = $reservation->description;
                    $data['supplier_id'] = 1;
                    $data['transfer'] = "Out";
                    $data['measure'] = "tabaka";
                    // dd($data);
                    if(($item_quantity - $reservation->quantity) >= 0) {
                        if($quantity->create($data)){
                            $reservation->update($update);
                        };
                    } else {
                        return redirect()->route('reservation.show', $reservation->material_id)->with('error', 'Nema dovoljno materijala na stanju');
                    }
                } catch (\Throwable $th) {
                    return redirect()->route('reservation.show', $reservation->material_id)->with('error', 'Materijal nije skinut sa rezervacije');
                }
                return redirect()->route('reservation.show', $reservation->material_id)->with('success', 'Materijal je skinut sa stanja');
            } else {
                return redirect()->route('reservation.show', $reservation->material_id)->with('error', 'Nemate pravo izmene statusa rezervacije');
            }
        }
    }
}
