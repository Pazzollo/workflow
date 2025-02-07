@extends('layouts.app')

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

@php
    $route = Route::currentRouteName();
@endphp

<form style="max-width: 500px" method="POST" action={{ route('transfer.update', $transfer) }}>
    @csrf
    <legend class="btn {{ $route == 'transfer.income' ? 'btn-success' : 'btn-warning'}} mt-2 btn-sm fs-6" >{{ $route == 'transfer.income' ? 'Uplata na račun Sapient Graphics-a' : 'Isplata sa računa Sapient Graphics-a' }}</legend>
    <div class="mb-3">
        <label for="transfer_doughter_id" class="form-label">Firma</label>
        <select name="transfer_doughter_id" id="transfer_doughter_id" class="form-select" disabled>
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
        <input hidden type="text" id="transfer_type_id" name="transfer_type_id" value={{ $transfer->transfer_type_id }}>
    </div>
        <div class="mb-3">
            <label for="description" class="form-label">Kratak opis trasakcije</label>
            <textarea rows="5" type="text" id="description" class="form-control" name="description" disabled>
                {{ $transfer->description }}
            </textarea>
            @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-2">
            <label for="ammount" class="form-label">Iznos (RSD)</label>
            <input type="text" step=".01" id="ammount" class="form-control" name="ammount" value = {{ $transfer->ammount }} disabled>
        </div>
        @error('ammount')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
        <label for="company_id" class="form-label">Kupac</label>
        <select name="company_id" id="company_id" class="form-select" disabled>
            <option value="{{ $transfer->company_id }}">{{ $transfer->company->name }}</option>
        </select>
        @error('company_id')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    <button type="submit" name="authorise" class="btn btn-primary mt-2">Odobri</button>
</form>

{{ Auth::user()->name }}<br>
{{ $companies->where('id', Auth::user()->company_id)->first()->name }}<br>

@endsection
