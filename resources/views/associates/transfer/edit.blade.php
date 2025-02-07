@extends('associates.layouts.app')

@section('title', 'Izmena transakcije')

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
    @method('PUT')
    <legend class="btn {{ $transfer->transfer_type_id == 1 ? 'btn-success' : 'btn-warning'}} mt-2 btn-sm fs-6" >{{ $transfer->transfer_type_id == 1 ? 'Uplata na račun Sapient Graphics-a' : 'Isplata sa računa Sapient Graphics-a' }}</legend>
    <div class="d-grid mb-2">
        <button class="btn btn-outline-secondary mt-2 btn-sm fs-6" disabled>Transfer kreirao {{ $transfer->user->name}}</button>
    </div>

    <div class="mb-3">
        <label for="transfer_doughter_id" class="form-label">Firma</label>
        <select name="transfer_doughter_id" id="transfer_doughter_id"
            class="form-select"
            @disabled(Auth::user()->id != $transfer->user_id)>
            @if (Auth::user()->role_id == 1)
                <option value="">Izaberite firmu</option>
                @foreach ($companies as $company)
                    @if ($company->companyRole->id == 2)
                        <option value={{ $company->id }} @selected($company->id == $transfer->transfer_doughter_id)>{{ $company->name }}</option>
                    @endif
                @endforeach
            @else
                <option value={{ $companies->where('id', Auth::user()->company_id)->first()->id }}>{{ $companies->where('id', Auth::user()->company_id)->first()->name }}</option>
            @endif
        </select>
        @error('transfer_doughter_id')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
        <input hidden type="number" id="id" name="id" value={{ $transfer->id }}>
        <input hidden type="text" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
        <input hidden type="text" id="transfer_type_id" name="transfer_type_id" value={{ $transfer->transfer_type_id }}>
    </div>
        <div class="mb-3">
            <label for="transfer_date" class="form-label">Datum</label>
            <input type="date" id="transfer_date" class="form-control" name="transfer_date" @disabled(Auth::user()->id != $transfer->user_id) value={{ $transfer->transfer_date }}>
            @error('transfer_date')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Kratak opis trasakcije</label>
            <textarea type="text" id="description" class="form-control" name="description" @disabled(Auth::user()->id != $transfer->user_id)>{{ $transfer->description }}</textarea>
            @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-2">
            <label for="ammount" class="form-label">Iznos računa bez PDV-a (RSD)</label>
            <input type="number" step=".01" id="ammount" class="form-control" name="ammount" value = {{ $transfer->ammount }} @disabled(Auth::user()->id != $transfer->user_id)>
        </div>
        @error('ammount')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
        @if ($transfer->transfer_type_id == 1)
        @php
            $ammount = 0;
            $statement = $transfer->statement;
            foreach ($statement as $item) {
                $ammount += $item['ammount'];
            }
        @endphp
        <div>
            <label class="form-label">Uplaćeno (bez PDV-a)</label>
            <input type="text" class="form-control" value = {{ number_format($ammount,2,',','.') }} disabled>
            <input type="text" class="form-control" name="statement_sum" id="statement_sum" value = {{ $ammount }} hidden>
        </div>
        <div class="mt-3 mb-2 border border-success p-2">Istorija uplata
        @foreach ($statement as $item)
            <div>
                {{ date_format(date_create($item['statement_date']), 'd. m. Y.') }} - {{ number_format($item['ammount'],2,',','.') }} RSD
            </div>
        @endforeach
        </div>
        @if (Auth::user()->role_id == 1)
        <div class="mt-3 mb-2">Nova uplata</div>
        <div class="border border-3 border-success p-1 mb-2">
            <div class="mb-2">
                <label for="statement_date" class="form-label">Datum delimične uplate</label>
                <input type="date" id="statement_date" class="form-control" name="statement_date" @disabled(Auth::user()->role_id != 1)>
            </div>
            <div>
                <label for="statement_ammount" class="form-label">Iznos delimične uplate</label>
                <input type="text" step=".01" id="statement_ammount" class="form-control" name="statement_ammount" @disabled(Auth::user()->role_id != 1)>
            </div>

            <button type="submit" name="partial_payment" class="btn btn-primary mt-2" @disabled($ammount >= $transfer->ammount)>Potvrdi uplatu</button>
            <button type="submit" name="full_payment" class="btn btn-success mt-2" @disabled($ammount > 0)>Uplata u celosti</button>
        </div>
        @endif

        @endif
        <label for="company_id" class="form-label">Kupac</label>
        <select name="company_id" id="company_id" class="form-select" @disabled(Auth::user()->id != $transfer->user_id)>
            <option value="{{ $transfer->company_id }}">{{ $transfer->company->name }}</option>
        </select>
        @error('company_id')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
        {{-- <div class="d-grid">
            <button class="btn btn-outline-secondary mt-2 btn-sm fs-6" disabled>Transfer kreirao {{ $transfer->user->name}}</button>
        </div> --}}

        <div class="d-flex justify-content-around mt-3">
            @if (Auth::user()->id == $transfer->user_id)
                <button type="submit" name="update" class="btn btn-primary mt-2">Izmeni</button>
            @endif
            @if (Auth::user()->id == $transfer->user_id || Auth::user()->role_id == 1)
            @if ($transfer->deleted == 1)
                <button type="submit" name="restore" class="btn btn-warning mt-2">Vrati iz obrisanih</button>
            @else
                <button type="submit" name="delete" class="btn btn-danger mt-2">Obriši</button>
                @if ($transfer->status == 0)
                    <button type="submit" name="status" class="btn btn-success mt-2"
                        {{ Auth::user()->role_id === 1 ? '' : ' disabled' }}>
                        Uplaćeno
                    </button>
                @endif
            @endif

            @endif

            <a href="{{ url()->previous() }}"name="cancel" class="btn btn-info mt-2">Nazad</a>
        </div>

</form>

@endsection
