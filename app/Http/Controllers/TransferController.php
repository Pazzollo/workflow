<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Statement;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class TransferController extends Controller
{

    public function index(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        };

        $id = Auth::user()->company_id;

        /*
        Ako je korisnik admin, a nije poslao id kompanije, redirektujemo ga na listu kompanija
        */
        if (Auth::user()->role_id === 1) {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            } else {
                return redirect()->route('company.index');
            }
        }
        if(isset($_GET['year'])) {
            $year = $_GET['year'] == 'all' ?  '%' : $_GET['year'];
        } else {
            $year = date('Y');
        }

        $companies = Company::with('companyRole')->get();

        $company = $companies->where('id', $id)->first();

        if (!$company) {
            return redirect()->route('associates.company.index')->with('company', 'Company not found');
        }

        if($company->id === Auth::user()->company_id || Auth::user()->role_id === 1){
            $transfers = Transfer::where('transfer_doughter_id', $company->id)
            ->where('transfer_date', 'LIKE', $year.'%')
            ->with('user')
            ->orderByDesc('transfer_date')
            ->with('statement')
            ->get();

            $active_transfers = Transfer::where('transfer_doughter_id', $company->id)
            ->where('transfer_date', '<', value: $year.'-01-01')
            ->where('status', 1)
            ->where('deleted', 0)
            ->with('statement')
            ->with('user')
            ->get();

            // dd($active_transfers->toArray()['2']['statement'][0]['ammount']);

            $pocetno_stanje = 0;
            if($active_transfers->count() > 0) {
                foreach($active_transfers as $transfer) {
                    if($transfer->transfer_type_id === 1) {
                        if($transfer->statement->count() > 0) {
                            for($i = 0; $i < $transfer->statement->count(); $i++) {
                                $pocetno_stanje += $transfer->statement[$i]->ammount;
                            }
                            // $pocetno_stanje += $transfer->statement[0]->ammount;
                        } else {
                            $pocetno_stanje += $transfer->ammount;
                        }
                    } else {
                        $pocetno_stanje -= $transfer->ammount;
                    }
                }
            }

            return view('associates.transfer.index', compact(['company', 'companies', 'transfers', 'pocetno_stanje']));

        } else {

            return redirect()->route('company.index')->with('company', 'Nemate pristup ovom resursu');

        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($transfer_type_id = null)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('associates.transfer.create',
            [
                'user' => Auth::user()->companies,
                'companies' => Company::with('companyRole')->get(),
                'transfer_id' => $transfer_type_id
            ]);
    }

    public function income()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('associates.transfer.create',
        [
            'user' => Auth::user()->companies,
            'companies' => Company::with('companyRole')->orderBy('name')->get(),
            'transfer_type_id' => 1
        ]);
    }

    public function payment()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('associates.transfer.create',
        [
            'user' => Auth::user()->companies,
            'companies' => Company::with('companyRole')->orderBy('name')->get(),
            'transfer_type_id' => 2
        ]);
    }

    public function display($company)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /*
        Ako se ne prosledi vrsta transfera, redirektujemo korisnika na listu transfera
        Ako se prosledi, proveravamo da li je to income ili payment
        Ukoliko nije ni jedno ni drugo, redirektujemo korisnika na listu kompanija ukoliko je admin, ili na listu transfera ukoliko je user
        */
        if(!isset($_GET['transfer'])) {
            return redirect()->route('transfer.index');
        } else {
            if($_GET['transfer'] == 'income') {
                $transfer_type = 1;
            } elseif($_GET['transfer'] == 'payment') {
                $transfer_type = 2;
            } else {
                if(Auth::user()->role_id === 1) {
                    return redirect()->route('company.index');
                } else {
                    return redirect()->route('transfer.index', ['id' => Auth::user()->company_id]);
                }
            }
        }

        if(isset($_GET['year'])) {
            $year = $_GET['year'] == 'all' ?  '' : $_GET['year'];
        } else {
            $year = date('Y');
        }

        $transfers = Transfer::where('transfer_doughter_id', $company)
        ->where('transfer_type_id', $transfer_type)
        ->where('transfer_date', 'LIKE', $year.'%')
        ->with('user')->orderByDesc('transfer_date')
        ->get();

        $companies = Company::with('companyRole')->get();

        return view('associates.transfer.display', ['transfers' => $transfers, 'company' => $company, 'companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Transfer $transfer)
    {
        $data = $request->validate([
            'transfer_doughter_id' => 'required|integer',
            'user_id' => 'required|integer',
            'transfer_type_id' => 'required|integer',
            'transfer_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'ammount' => 'required|numeric',
            'company_id' => 'required|integer',
        ]);
        $data['status'] = $data['transfer_type_id'] == 1 ? 0 : 1;
        if(Auth::user()->role_id === 1 || Auth::user()->company_id == $data['transfer_doughter_id']) {
            $transfer->create($data);
            return redirect()->route('company.show', ['company' => $data['transfer_doughter_id']])->with('success', 'Uspesno ste uneli transfer');
        } else {
            return redirect()->route('company.index')->with('warning', 'Nemate pristup ovom resursu');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Company $company)
    {
        $transfer = Transfer::find($id);
        return view('associates.transfer.show', ['id' => $id, 'companies' => Company::with('companyRole')->get(), 'transfer' => $transfer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
            $transfer = Transfer::with('user')->with('statement')->find($id);
            return view('associates.transfer.edit', ['id' => $id, 'companies' => Company::with('companyRole')->get(), 'transfer' => $transfer]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, Request $request)
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $transfer = Transfer::find($id);

        $data = request()->validate([
            'transfer_doughter_id' => 'sometimes|integer',
            'user_id' => 'sometimes|integer',
            'transfer_type_id' => 'sometimes|integer',
            'transfer_date' => 'sometimes|date',
            'description' => 'sometimes|nullable|string|max:255',
            'ammount' => 'sometimes|numeric',
            'company_id' => 'sometimes|integer',
            'deleted' => 'sometimes|nullable|integer',
            'deleted_by' => 'sometimes|nullable|integer',
            'status' => 'sometimes|nullable|integer',
            'statement_date' => 'sometimes|nullable|date',
            'statement_ammount' => 'sometimes|nullable|numeric',
            'complete_payment' => 'sometimes | nullable | boolean',
            'statement_sum' => 'sometimes | nullable | numeric',
        ]);

        if (isset($_POST['update'])) {
            $data['updated_at'] = now()->addHours(2);
            $transfer->update($data);
        } elseif (isset($_POST['delete'])) {
            $data['user_id'] = $transfer->user_id;
            $data['deleted'] = 1;
            $data['deleted_by'] = Auth::user()->id;
            $data['updated_at'] = now()->addHours(2);
            $transfer->update($data);
        } elseif(isset($_POST['restore'])) {
            $data['user_id'] = $transfer->user_id;
            $data['deleted'] = 0;
            $data['updated_at'] = now()->addHours(2);
            $transfer->update($data);
        } elseif (isset($_POST['status'])) {
            $data['status'] = 1;
            $data['updated_at'] = now()->addHours(2);
            try {
                $statement = new Statement();
                $statement->create([
                    'transfer_id' => $id,
                    'ammount' => $transfer->ammount - Statement::where('transfer_id', $id)->sum('ammount'),
                    'statement_date' => now()->addHours(2)
                ]);
                $transfer->update($data);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Nije uspeo upis u bazu! '.$th);
            }
        } elseif (isset($_POST['partial_payment'])) {
            $statement = new Statement();
            $statement->create([
                'transfer_id' => $id,
                'ammount' => $data['statement_ammount']/1.2,
                'statement_date' => $data['statement_date'] ? $data['statement_date'] : now()->addHours(2),
            ]);
            if($transfer->ammount - $data['statement_sum'] - $data['statement_ammount']/1.2 <= 0) {
                $data['status'] = 1;
            }

            $data['updated_at'] = now()->addHours(2);
            $transfer->update($data);

        } elseif (isset($_POST['full_payment'])) {
            $statement = new Statement();
            $statement->create([
                'transfer_id' => $id,
                'ammount' => $transfer->ammount,
                'statement_date' => $data['statement_date'] ? $data['statement_date'] : now()->addHours(2),
            ]);

            $data['status'] = 1;
            $data['updated_at'] = now()->addHours(2);
            $transfer->update($data);

        }

        return redirect()->route('transfer.index', ['id' => $transfer->transfer_doughter_id])->with('success', 'Uspesno ste promenili podatke o transferu');

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
