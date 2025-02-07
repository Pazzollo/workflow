<?php

namespace App\Http\Controllers;

use App\Models\Finish;
use App\Models\Materialtype;
use Illuminate\Http\Request;

class FinishController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        return view('warehouse.finish.create', [
            'finishes' => Finish::get(),
            'materialTypes' => Materialtype::get()
        ]);
    }

    public function store(Finish $finish, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:64'
        ]);

        foreach ($finish->get() as $type) {
            if(strtolower($type['name']) == strtolower($validatedData['name'])) {
                return redirect()->route('finish.create')->with('error', 'Tip premaza već postoji!')->with('old_input', $validatedData['name']);
            }
        }

        $finish->create($validatedData);

        return redirect()->route('finish.create')->with('success', 'Novi tip premaza je unet');
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
