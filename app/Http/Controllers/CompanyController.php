<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    public function index(Transfer $transfer)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if(isset($_GET['role'])){
            if($_GET['role'] == 3){
                $companies = Company::with('companyRole')
                    ->where('company_role_id', 3)
                    ->orWhere('company_role_id', 5)
                    ->orWhere('company_role_id', 2)
                    ->orderBy('name')->get();
                return view('associates.company.index', compact('companies', 'transfer'));
            } else {
                $companies = Company::with('companyRole')
                    ->where('company_role_id', 4)
                    ->orWhere('company_role_id', 5)
                    ->orWhere('company_role_id', 2)
                    ->orderBy('name')->get();
                return view('associates.company.index', compact('companies', 'transfer'));
            }
        }

        $companies = Company::with('companyRole')->orderBy('name')->orderBy('name')->get();
        return view('associates.company.index', compact('companies', 'transfer'));

    }

    public function show(int $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $companies = Company::with('companyRole')->get();

        $company = $companies->where('id', $id)->first();

        if (!$company) {
            return redirect()->route('company.index')->with('company', 'Company not found');
        }

        return view('associates.company.show', compact('company', 'companies'));

        if($company->id === Auth::user()->company_id || Auth::user()->role_id === 1){
            $transfers = Transfer::where('transfer_doughter_id', $company->id)->with('user')->orderByDesc('transfer_date')->get();
            return view('show', compact(['company', 'companies', 'transfers']));
        } else {
            return redirect()->route('company.index')->with('company', 'Nemate pristup ovom resursu');
        }
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $companies = Company::with('companyRole')->get();

        return view('associates.company.create', compact('companies'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $data = $request->validate([
            'name' => 'required|string|max:64',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:64',
            'pib' => 'required|numeric|digits:9',
            'mbr' => 'required|numeric|digits:8',
            'status_id' => 'required|integer',
            'zipcode' => 'required|numeric|digits:5',
            'customer' => 'sometimes',
            'supplier' => 'sometimes',
            'associate' => 'sometimes',

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

        Company::create($data);

        return redirect()->route('company.index');
    }

    public function edit(int $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $companies = Company::with('companyRole')->get();

        $company = $companies->where('id', $id)->first();

        if (!$company) {
            return redirect()->route('company.index')->with('company', 'Company not found');
        }

        return view('associates.company.edit', compact('company', 'companies'));
    }

    public function update(Request $request, int $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $data = $request->validate([
            'name' => 'required|string|max:64',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:64',
            'pib' => 'required|numeric|digits:9',
            'mbr' => 'required|numeric|digits:8',
            'status_id' => 'required|integer',
            'customer' => 'sometimes',
            'supplier' => 'sometimes',
            'associate' => 'sometimes',
        ]);

        $company = Company::find($id);

        if (!$company) {
            return redirect()->route('company.index')->with('company', 'Company not found');
        }

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

        $company->update($data);

        return redirect()->route('company.index');
    }

    public function new()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $companies = Company::with('companyRole')->get();

        return view('associates.company.new', compact('companies'));
    }

}
