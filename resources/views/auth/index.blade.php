@extends('warehouse.layouts.app')

@php
    $title = 'Prijava';
@endphp

@section('title', $title)

@section('content')
    <div id="wrapper">

        {{-- <x-modal /> --}}
        <x-header :search="false" :burger="false" :sign="false" />
        {{-- Ako ne želimo search ikonicu, vrednost :search ćemo staviti "false",
            isto važi i za hamburger meni --}}
        <main class="d-flex" id="main">
            <content id="" class="px-1 m-auto w-100">
                @if (session('error'))
                <div class="card mt-2 border border-danger">
                    <div class="card-body text-danger text-center">
                      {{ session('error') }}
                    </div>
                </div>
                @endif
                <h3 class="text-center pt-3 font-medium fs-3">Zdravo {{ Auth::user()->name }}</h3>
                <h4 class="text-center pt-3 font-sm fs-6">Izaberi aplikaciju</h4>
                <div class="d-flex gap-3">
                    @if (Auth::user()->company_id == 1)
                        <a href="{{ route('workflow.index') }}" class="btn w-100 btn-primary">Radni nalozi</a>
                        <a href="{{ route('warehouse.index') }}" class="btn w-100 btn-primary">Magacin</a>
                    @endif

                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                        <a href="{{ route('company.index') }}" class="btn w-100 btn-primary">Saradnici</a>
                    @elseif (Auth::user()->role_id == 3)
                        <a href="{{ route('company.index') }}" class="btn w-100 btn-primary">Moji poslovi</a>
                    @endif

                </div>
            </content>
        </main>
    </div>
@endsection
