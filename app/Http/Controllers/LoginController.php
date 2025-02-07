<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(!Auth::attempt($data)){
            throw ValidationException::withMessages([
                'email' => ['Podaci nisu ispravni.']
            ]);
        } else {
            if(Auth::user()->role_id === 1) {
                return redirect()->route('company.index');
            } else {
                return redirect()->route('transfer.index');
            }
        }
    }
}
