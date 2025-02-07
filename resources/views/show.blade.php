@extends('layouts.app')

@section('title', 'Transakcije')

@section('content')

@if (session('success'))
    <div class="alert alert-success mt-3" style="max-width: 400px">
        {{ session('success') }}
    </div>
@endif
@if (session('warning'))
    <div class="alert alert-danger">
        {{ session('warning') }}
    </div>
@endif
@php
    $n=1;
    for($i=0; $i<count($transfers); $i++){
        if($transfers[$i]->transfer_type_id == 1){
            if($transfers[$i]->deleted != 1) {
                if ($transfers[$i]->status == 1) {
                    $ammounts[$i] = $transfers[$i]->ammount;
                } else {
                    $ammounts[$i] = 0;
                }
            } else {
                $ammounts[$i] = 0;
            }
        }else{
            if($transfers[$i]->deleted != 1) {
                $ammounts[$i] = -$transfers[$i]->ammount;
            } else {
                $ammounts[$i] = 0;
            }
        }
    }
    $ammounts = array_reverse($ammounts);
    $balance = [];
    for($i=0; $i<count($ammounts); $i++){
        if($ammounts[$i] == 0) {
                $deleted[$i] = 0;
            } else {
                $deleted[$i] = 1;
            }
        if($i == 0){
            $balance[$i] = $ammounts[$i];
        }else{
            $balance[$i] = $balance[$i-1] + $ammounts[$i];
        }
    }
    $balance = array_reverse($balance);
    $n = count($transfers);
    $i=0;
@endphp

{{-- <div class="card mt-2">
    <div class="card-header">
        <h5>{{ $company->name }}</h5>
        <h6 class="fw-bold {{ $balance[0] < 0 ? 'text-danger' : 'text-success' }}">Stanje: {{ number_format($balance[0], 2, ',','.') }}</h6>
    </div>
</div> --}}

<table class="table table-hover table-striped- mt-3">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Firma</th>
        <th scope="col">Opis</th>
        <th scope="col">Transakcija</th>
        <th scope="col">Iznos (RSD)</th>
        <th scope="col">Iznos sa PDV</th>
        <th scope="col">Uneo</th>
        <th scope="col">Datum</th>
        <th scope="col">Stanje</th>
        <th scope="col">Akcija</th>
        <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">

        @foreach ($transfers as $transfer)
            <tr class="{{ $transfer->deleted == 1 ? 'table-dark' : ($transfer->transfer_type_id === 1 ? 'table-success' :           'table-danger') }}"
                {{ (Auth::user()->role_id != 1 and $transfer->deleted == 1) ? 'hidden' : '' }}>
                <td scope="row">{{ $n }}</td>
                <td>{{ $transfer->company->name }}</td>
                <td>{{ $transfer->description }}</td>
                <td scope="col">{{ $transfer->transfer_type_id == 1 ? 'Uplata' : 'Isplata' }}</td>
                <th class="text-end">{{ number_format($transfer->ammount, 2, ',', '.') }}</th>
                <td class="text-end">{{ number_format($transfer->ammount * 1.2, 2, ',', '.') }}</td>
                <td>{{ $transfer->user->name }}</td>
                <td>{{ date('d. m. Y.', strtotime($transfer->transfer_date)) }}</td>
                <td class="text-end fw-bold {{ $balance[$i]<0 ? 'text-danger' : 'text-success' }}">

                    {{ number_format(($balance[$i]), 2, ',', '.') }}
                </td>
                <td>
                    <a href="{{ route('transfer.edit', $transfer) }}"
                        class="btn btn-sm btn-primary me-1"
                        @disabled(Auth::user()->role_id != 1 || Auth::user()->id != $transfer->user_id)>
                        Izmeni
                    </a>
                    @if ($transfer->deleted == 1)
                        <a href="{{ route('transfer.edit', $transfer) }}"
                            class="btn btn-sm btn-warning w-auto"
                            @disabled(Auth::user()->role_id != 1)>
                            Vrati
                        </a>
                    @else
                        <a href="{{ route('transfer.edit', $transfer) }}"
                            class="btn btn-sm btn-danger"
                            {{ (Auth::user()->id == $transfer->user_id || Auth::user()->role_id == 1) ? '' : 'disabled' }}>
                            Obriši
                        </a>
                    @endif

                </td>
                <td>
                    @if ($transfer->status == 1)
                        <span class="btn btn-sm bg-success">Z</span>
                    @else
                        <a @disabled(Auth::user()->role_id != 1)
                            class="btn btn-sm bg-danger"
                            href="{{ route('transfer.edit', $transfer) }}">O</a>
                    @endif
                </td>
            </tr>
        @php
            $i++;
            $n--;
        @endphp
        @endforeach
    </tbody>
    </table>

@endsection


