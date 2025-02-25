<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyContact;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::with('companies')->orderBy('name')->get();

        return view('warehouse.contacts.index', ['contacts' => $contacts]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::orderBy('name')->get();
        return view('warehouse.contacts.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'phone2' => 'nullable|string',
            'birthday' => 'nullable|date',
            'company_id' => 'required|exists:companies,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        $contact = Contact::create($data);

        $contact->companies()->attach($data['company_id'], [
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null
        ]);

        return redirect()->route('contacts.index')->with('success', 'Kontakt je uspešno kreiran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::where('id', $id)->first();
        // dd($contact->load('companies'));

        return view('warehouse.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        $companies = Company::orderBy('name')->get();
        $contact->with(['companies' => function($query){
            $query->whereNull('company_contact.end_date')
                ->orWhere('company_contact.end_date', '>=', now());
        }])->get();

        return view('warehouse.contacts.edit', compact('contact', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'phone2' => 'nullable|string',
            'birthday' => 'nullable|date',
            'company_id' => 'required|exists:companies,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        $contact = Contact::where('id', $id)->first();

        $contact->update($request->only(['name', 'email', 'phone', 'phone2', 'birthday']));
        $companyContact = CompanyContact::where('contact_id', $contact->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $companyContact->update([
            'company_id' => $data['company_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null
        ]);

        return redirect()->route('contacts.show', $contact)->with('success', 'Kontakt je uspešno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
