<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function update(Request $request)
    {
        $key = $request->input('key');
        $value = $request->input('value');
        if (!$key || !$value) {
            return response()->json(['status' => 'Invalid input'], 400);
        }

        $request->session()->put($key, $value);
        return response()->json(['status' => 'Session updated']);
    }

    public function get(Request $request)
    {
        // Provera ulaznih podataka
        $key = $request->input('key');
        if (!$key) {
            return response()->json(['status' => 'Invalid input'], 400);
        }

        $value = $request->session()->get($key);
        // Dodajte dd da proverite vrednost
        // dd($value);
        return response()->json(['value' => $value]);
    }
}
