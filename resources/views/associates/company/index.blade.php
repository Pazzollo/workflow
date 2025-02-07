<?php
use Illuminate\Support\Facades\Redirect;
?>

@extends('associates.layouts.app')

@section('title', 'Početna')

@section('content')

<style>
    .card-hover:hover {
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    }

    #flexbox {
        display: flex;
        max-width: 1200px;
        justify-content: flex-start;
        flex-wrap: wrap;
        }

    .box {
        margin: 5px;
        padding: 8px 14px;
        text-align: center;

    }
</style>

@if (session('company'))
    <div class="alert alert-danger">
        {{ session('company') }}
    </div>
@endif

<div class="d-flex gap-2">

@foreach ($companies as $company)
    @if ($company->companyRole->id == 2)
        @if ($company->id == Auth::user()->company_id || Auth::user()->role_id == 1)
            @php
                $balance = 0;
                $transfers = $transfer
                ->where([
                        ['transfer_doughter_id', $company->id]
                ])->orderBy('created_at')->get();
                foreach ($transfers as $transfer) {
                    if($transfer->deleted == 1) {
                        continue;
                    }
                    if($transfer->transfer_type_id == 1) {
                        if($transfer->status == 1) {
                            $balance += $transfer->ammount;
                        } else {
                            continue;
                        }
                    } else {
                        $balance -= $transfer->ammount;
                    }
                }
            @endphp
            <a href="{{ route('transfer.index', ['id' => $company]) }}" class="card mt-3 col-2 text-decoration-none card-hover"
                style="min-width: 180px">
                <div class="card-header">
                    <h5>{{ $company->name }}</h5>
                    <h6 class="fw-bold {{ $balance < 0 ? 'text-danger' : 'text-success' }}">Stanje: {{ number_format($balance, 2, ',', '.') }}</h6>
                </div>
            </a>
            <br>
        @endif
    @endif
@endforeach
</div>
<hr>

<div class="d-flex gap-2" id="flexbox">
    @foreach ($companies as $company)
        @if ($company->companyRole->id > 2)
            {{-- @if ($company->id == Auth::user()->company_id || Auth::user()->role_id == 1) --}}
                <a href="{{ route('company.show', $company) }}" class="boks card mt-3 col-2 text-decoration-none card-hover"
                    style="min-width: 180px">
                    <div class="card-header">
                        <h5>{{ $company->name }}</h5>
                        <h6 class="fw-bold text-success">{{ $company->city }}</h6>
                    </div>
                </a>
                <br>
            {{-- @endif --}}
        @endif
    @endforeach
</div>

@endsection
