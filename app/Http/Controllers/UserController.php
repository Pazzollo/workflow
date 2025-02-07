<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        };

        $companies = Company::with('companyRole')->orderBy('name')->get();
        $users = User::with('company', 'role')->get();
        return view('associates.user.index', compact('companies', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        };

        $companies = Company::with('companyRole')->orderBy('name')->get();
        $user = User::with('company', 'role')->where('id', $id)->first();
        return view('associates.user.show', compact('companies', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        };

        if(Auth::user()->id != $id) {
            return redirect()->route('user.index')
                ->with('error', 'Nije dozvoljeno uređivati podatke drugih korisnika!');
        }

        $companies = Company::with('companyRole')->orderBy('name')->get();
        $user = User::with('company', 'role')->where('id', $id)->first();
        return view('associates.user.edit', compact('companies', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        if(Auth::user()->id != $id) {
            return redirect()->route('user.index')
                ->with('error', 'Nije dozvoljeno uređivati podatke drugih korisnika!');
        }

        $data = request()->validate([
            'email' => 'required|email',
            'phone1' => 'required|string|max:20',
            'phone2' => 'sometimes|nullable|string|max:20',
            'password' => 'required|string|min:8',
            'password_check' => 'required|string|min:8',
        ]);

        if($data['password'] != $data['password_check']) {
            return redirect()->route('user.edit', $id)
                ->with('error', 'Lozinke se ne poklapaju!');
        }

        $user = User::find($id);

        $data['updated_at'] = now()->addHours(2);
        $user->update($data);

        return redirect()->route('user.show', $user->id)
            ->with('success', 'Podaci su uspešno ažurirani!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
