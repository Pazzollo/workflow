@extends('associates.layouts.app')

@section('title', 'Novi saradnik')

@section('content')

@if (session('company'))
    <div class="alert alert-danger">
        {{ session('company') }}
    </div>
@endif

@if (session('transfer'))
    <div class="alert alert-success">
        {{ session('transfer') }}
    </div>
@endif

<form style="max-width: 500px" method="POST" action={{ route('company.update', $company) }}>
    @csrf
    @method('PUT')
    <legend class="btn btn-warning mt-2 btn-sm fs-6">
        {{ Route::currentRouteName() == 'company.show' ? 'Pregled podataka o saradniku' : 'Ispravka podataka o saradniku' }}
    </legend>
    <div class="mb-3">
        <label for="name" class="form-label">Naziv firme</label>
        <input type="text" id="name" class="form-control" name="name" value = "{{ $company->name }}" disabled>

        <label for="address" class="form-label mt-4">Adresa</label>
        <input type="text" id="address" class="form-control" name="address" value = "{{ $company->address }}" disabled>

        <label for="city" class="form-label mt-4">Mesto</label>
        <input type="text" id="city" class="form-control" name="city" value = "{{ $company->city }}" disabled>

        <input hidden type="text" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
        <input hidden type="text" id="status_id" name="status_id" value="1">
    </div>
    <div class="mt-3 d-flex gap-4 justify-content-between">
        <div class="flex-fill">
            <label for="name" class="form-label">PIB</label>
            <input type="number" id="pib" class="form-control" name="pib" value = {{ $company->pib }} disabled>

        </div>
        <div class="flex-fill">
            <label for="mbr" class="form-label">Matični broj</label>
            <input type="number" id="mbr" class="form-control" name="mbr" value = {{ $company->mbr }} disabled>
        </div>
    </div>
    {{-- @if (Auth::user()->role_id == 1) --}}
    <div class="mt-3 d-flex gap-4">
        <div>
            <input class="form-check-input" type="checkbox" id="customer" name="customer"
            @checked($company->company_role_id == 3 || $company->company_role_id == 5) disabled>
            <label class="form-check-label" for="flexCheckDefault">
                Klijent (Kupac)
            </label>
        </div>
        <div>
            <input class="form-check-input" type="checkbox" id="supplier" name="supplier"
            @checked($company->company_role_id == 4 || $company->company_role_id == 5) disabled>
            <label class="form-check-label" for="flexCheckDefault">
                Dobavljač
            </label>
        </div>
        @if (Auth::user()->role_id == 1)
        <div>
            <input class="form-check-input" type="checkbox" id="associate" name="associate"
            @checked($company->company_role_id == 2) disabled>
            <label class="form-check-label" for="flexCheckDefault">
                Saradnik
            </label>
        </div>

        @endif
    </div>
    {{-- @endif --}}
    @if (Route::currentRouteName() == 'company.edit')
        <button type="submit" class="btn btn-primary mt-4">Snimi</button>
    @else
        <a href="{{ url()->previous() }}" class="btn btn-primary mt-4">Nazad</a>
    @endif
        <a href="{{ route('company.edit', $company) }}" type="submit" class="btn btn-primary mt-4">Izmeni podatke</a>
    @if ($company->company_role_id == 2)
        <a href="{{ route('transfer.index', ['id' => $company]) }}" type="submit" class="btn btn-secondary mt-4">Stanje</a>
    @endif

</form>

@endsection
