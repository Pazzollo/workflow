@extends('associates.layouts.app')

@section('title', 'Nova transakcija')

@section('content')

@if (session('warning'))
    <div class="alert alert-danger">
        {{ session('warning') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@php
    $route = Route::currentRouteName();
@endphp

<form style="max-width: 500px" method="POST" action={{ route('transfer.store') }}>
    @csrf
    <legend class="btn {{ $route == 'transfer.income' ? 'btn-success' : 'btn-warning'}} mt-2 btn-sm fs-6" >{{ $route == 'transfer.income' ? 'Uplata na račun Sapient Graphics-a' : 'Isplata sa računa Sapient Graphics-a' }}</legend>
    <div class="mb-3">
        <label for="transfer_doughter_id" class="form-label">Firma</label>
        <select name="transfer_doughter_id" id="transfer_doughter_id" class="form-select">
            @if (Auth::user()->role_id == 1)
                <option value="">Izaberite firmu</option>
                @foreach ($companies as $company)
                    @if ($company->companyRole->id == 2)
                        <option value={{ $company->id }}>{{ $company->name }}</option>
                    @endif
                @endforeach
            @else
                <option value={{ $companies->where('id', Auth::user()->company_id)->first()->id }}>{{ $companies->where('id', Auth::user()->company_id)->first()->name }}</option>
            @endif
        </select>
        @error('transfer_doughter_id')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
        <input hidden type="text" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
        <input hidden type="text" id="transfer_type_id" name="transfer_type_id" value={{ $transfer_type_id }}>
    </div>
        <div class="mb-3">
            <label for="transfer_date" class="form-label">Datum</label>
            <input type="date" id="transfer_date" class="form-control" name="transfer_date" value={{ old('transfer_date') }}>
            @error('transfer_date')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Kratak opis trasakcije</label>
            <textarea type="text" id="description" class="form-control" name="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-2">
            <label for="ammount" class="form-label">Iznos (RSD)</label>
            <input type="text" step=".01" id="ammount" class="form-control" name="ammount" value = {{ old('ammount') }}>
        </div>
        @error('ammount')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
        <label for="company_id" class="form-label">{{ $route == 'transfer.payment' ? 'Dobavljač' : 'Kupac'}}</label>
        <select name="company_id" id="company_id" class="form-select">
            <option value="{{ old('company_id') }}">Izaberite {{ $route == 'transfer.payment' ? 'dobavljača' : 'kupca'}}</option>
            @foreach ($companies as $company)
                @if ($route == 'transfer.payment')
                    @if (Auth::user()->role_id == 2 && $company->company_role_id == 2 && $company->id != Auth::user()->company_id)
                        @continue
                    @endif
                    @if ($company->companyRole->id == 2 || $company->companyRole->id == 4 || $company->companyRole->id == 5)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endif
                @else
                    @if (Auth::user()->role_id == 2 && $company->company_role_id == 2 && $company->id != Auth::user()->company_id)
                        @continue
                    @endif
                    @if ($company->companyRole->id == 2 || $company->companyRole->id == 3 || $company->companyRole->id == 5)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endif
                @endif
            @endforeach
        </select>
        @error('company_id')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    <button type="submit" class="btn btn-primary mt-4 mb-2">Submit</button>
</form>

@endsection
