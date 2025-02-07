@extends('warehouse.layouts.app')

@php
    $title = 'Lista kontakata';
@endphp

@section('title', $title)

@section('content')

    <x-functions />
    <x-search-companies />

    <div class="sticky-top bg-white">
        <x-header :search="true" :title="$title" />
        {{-- Ako ne želimo search ikonicu, vrednost :search ćemo staviti "false" --}}
    </div>
    <main class="d-flex" id="main">
        <x-sidebar id="sidebar" :links="[]" />
        <content id="content" class="mt-2 px-1">
            <x-error-message :message="session('error')" />
            <x-success-message :message="session('success')" />

                @foreach ($contacts as $contact)
                    <div class="card mb-2 border-1 px-2 pb-2 pt-0">

                        <div class="">
                            <div class="d-flex justify-content-around align-items-end mt-2 gap-2">
                                <div class="text-dark w-100"><span class="fw-bold">{{ $contact->name }}</span> - {{ $contact->companies->last()->name }}</div>
                                <a href="{{ route('contacts.show', $contact) }}"
                                    class=" btn btn-sm btn-outline-dark">
                                    Detalji
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <x-footer />

        </content>
    </main>

@endsection

{{-- <table class="table">
    <thead>
        <tr>
            <th>Ime</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>Firma</th>
            <th>Datum početka</th>
            <th>Datum završetka</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->phone }}</td>
                <td>
                    @if($contact->companies->isNotEmpty())
                        {{ $contact->companies->first()->name }}
                    @else
                        Nema firme
                    @endif
                </td>
                <td>
                    @if($contact->companies->isNotEmpty())
                        {{ $contact->companies->first()->pivot->start_date }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($contact->companies->isNotEmpty())
                        {{ $contact->companies->first()->pivot->end_date }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table> --}}
