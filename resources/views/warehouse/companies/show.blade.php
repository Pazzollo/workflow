@extends('warehouse.layouts.app')

@php
    $title = $company->name
@endphp

@section('title', $title)

@section('content')

    <x-functions />
    <x-search-companies :companyRole="$company->company_role_id"/>

    <div class="sticky-top bg-white">
        <x-header :search="true" :title="$title" />
        {{-- Ako ne želimo search ikonicu, vrednost :search ćemo staviti "false" --}}
    </div>
    <main class="d-flex" id="main">
        <x-sidebar id="sidebar" :links="[]" />
        <content id="content" class="mt-2 px-1">

            <x-error-message :message="session('error')" />
            <x-success-message :message="session('success')" />

               <div class="card mb-2 border-1 px-2 pb-2">
                    <div class="">
                        <div class="px-1 d-flex align-items-end gap-2 pb-4 fw-bold">
                            <div class="text-uppercase text-dark mt-2">{{ $company->name }}</div>
                            <div> - {{ $company->city }}</div>
                        </div>
                        <table class="table table-sm">
                            <tr>
                                <td>Kontakt osoba:</td>
                                @foreach ($contacts as $contact)
                                    <td><a class="text-dark fw-bold" href="{{ route('contacts.show', $contact) }}">{{ $contact->name }}</a></td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>Telefon:</td>
                                <td>{{ $company->phone1 }}</td>
                                <td>{{ $company->phone2 }}</td>
                            </tr>
                            <tr>
                                <td>E-mail:</td>
                                <td>{{ $company->email1 }}</td>
                                <td>{{ $company->email2 }}</td>
                            </tr>
                            <tr>
                                <td>Adresa:</td>
                                <td class="text-capitalize">{{ $company->address }}</td>
                                <td></td>
                            </tr>
                        </table>

                        <a href="{{ route('warehouseCompany.edit', $company) }}" class=" btn btn-sm btn-primary w-100 mt-2"
                            type="submit">
                            Izmeni Podatke
                        </a>
                    </div>
                </div>
                <x-footer />

        </content>
    </main>

@endsection
