<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data = $request->validate([
            'name' => 'nullable|string',
            'role' => 'required|numeric'
        ]);



        if($data['role'] == 3 || $data['role'] == 4) {
            $companies = Company::when(isset($data['name']), function($query) use($data) {
                $query->where('name', 'like', '%' . $data['name'] . '%');
            })
            ->with('companyRole')
            ->where(function($query) use($data) {
                $query->where('company_role_id', $data['role'])
                      ->orWhere('company_role_id', 5);
            })
            ->orderBy('name')
            ->get();
        } else {
            $companies = Company::where('company_role_id', null)->get();
        }

        if(!$companies->isEmpty()) {
            return view('warehouse.companies.index', compact('companies'));
        } else {
            $request->session()->flash('error', 'Firma sa takvim podatkom ne postoji!');
            return view('warehouse.companies.index', compact('companies'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warehouse.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $data = $request->validate([
            'name' => 'required|string',
            'phone1' => 'required|string',
            'phone2' => 'nullable|string',
            'email1' => 'required|email',
            'email2' => 'nullable|email',
            'address' => 'required|string',
            'city' => 'required|string',
            'zipcode' => 'required|string',
            'pib' => 'required|string',
            'mbr' => 'required|string',
            'customer' => 'sometimes',
            'supplier' => 'sometimes',
        ]);

        if ($request->has('associate')) {
            $data['company_role_id'] = 2;
        } else {
            if ($request->has('customer', 'supplier')) {
                $data['company_role_id'] = 5;
            } elseif ($request->has('customer')) {
                $data['company_role_id'] = 3;
            } elseif ($request->has('supplier')) {
                $data['company_role_id'] = 4;
            }
        }

        $data['status_id'] = 1;

        // dd($data);

        $company = Company::create($data);

        $request->session()->flash('success', 'Firma je uspešno dodata!');
        return redirect()->route('warehouseCompany.show', $company->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::where('id', $id)->first();
        // $contacts = Contact::where('company_id', $id)->get();
        $contacts = $company->contacts->sortBy('name');
        // dd($contacts->where('pivot.end_date', null));
        // dd($company);
        return view('warehouse.companies.show', [
            'company' => $company,
            'contacts' => $contacts->where('pivot.end_date', null)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::where('id', $id)->first();
        return view('warehouse.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Company $company, Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string',
            'phone1' => 'required|string',
            'phone2' => 'nullable|string',
            'email1' => 'required|email',
            'email2' => 'nullable|email',
            'address' => 'required|string',
            'city' => 'required|string',
            'zipcode' => 'nullable|string',
            'pib' => 'required|string|max:9',
            'mbr' => 'required|string|max:8',
            'customer' => 'sometimes',
            'supplier' => 'sometimes',
        ]);

        $company->update($data);

        return redirect()->route('warehouseCompany.show', $company->id)->with('success', 'Podaci su uspešno izmenjeni!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
