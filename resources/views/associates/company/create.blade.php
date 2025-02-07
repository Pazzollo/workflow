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

<form class="mt-2" style="max-width: 500px" method="POST" action={{ route('company.store') }}>
    @csrf
    <legend class="btn btn-primary mt-2 fs-6" >Novi saradnik</legend>
    <div class="mb-3">
        <label for="name" class="form-label">Naziv firme</label>
        @error('name')
            <div class="text-danger" style="font-size: smaller">
                Unesite naziv firme
            </div>
        @enderror
        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value = {{ old('name') }}>

        <label for="address" class="form-label mt-4">Adresa</label>
        @error('address')
            <div class="text-danger" style="font-size: smaller">
                Unesite adresu firme
            </div>
        @enderror
        <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" name="address" value = {{ old('address') }}>

        <label for="city" class="form-label mt-4">Mesto</label>
        @error('city')
            <div class="text-danger" style="font-size: smaller">
                Unesite ime grada ili opštine
            </div>
        @enderror
        <input type="text" id="city" class="form-control @error('city') is-invalid @enderror" name="city" value = {{ old('city') }}>

        <input hidden type="text" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
        <input hidden type="text" id="status_id" name="status_id" value="1">
    </div>
    <div class="mt-3 d-flex gap-4 justify-content-between">
        <div class="flex-fill">
            <label for="name" class="form-label">PIB</label>
            @error('pib')
                <div class="text-danger" style="font-size: smaller">
                    Unesite jedinstveni PIB
                </div>
            @enderror
            <input type="number" id="pib" class="form-control @error('pib') is-invalid @enderror" name="pib" value = {{ old('pib') }}>

        </div>
        <div class="flex-fill">
            <label for="mbr" class="form-label">Matični broj</label>
            @error('mbr')
                <div class="text-danger" style="font-size: smaller">
                    Unesite jedinstveni matični broj
                </div>
            @enderror
            <input type="number" id="mbr" class="form-control @error('mbr') is-invalid @enderror" name="mbr" value = {{ old('mbr') }}>

        </div>
    </div>
    <div class="mt-3 d-flex gap-4">
        <div>
            <input class="form-check-input" type="checkbox" id="customer" name="customer">
            <label class="form-check-label" for="flexCheckDefault">
              Klijent (Kupac)
            </label>
        </div>
        <div>
            <input class="form-check-input" type="checkbox" id="supplier" name="supplier">
            <label class="form-check-label" for="flexCheckDefault">
              Dobavljač
            </label>
        </div>
        @if (Auth::user()->role_id == 1)
        <div>
            <input class="form-check-input" type="checkbox" id="associate" name="associate">
            <label class="form-check-label" for="flexCheckDefault">
              Saradnik
            </label>
        </div>

        @endif
    </div>

    <button type="submit" class="btn btn-primary mt-2">Snimi</button>
</form>

@endsection
