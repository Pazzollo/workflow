@extends('warehouse.layouts.app')

@php
    $title = $contact->name;
    use Carbon\Carbon;
@endphp

@section('title', $title)

@section('content')

    <x-functions />
    {{-- <x-search-companies :companyRole="$company->company_role_id"/> --}}

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
                            <div class="text-uppercase text-dark mt-2">{{ $contact->name}}</div>
                            <div> - {{ $contact->companies[count($contact->companies)-1]->name }}</div>
                        </div>
                        <table class="table table-sm">
                            <tr>
                                <td>Telefon:</td>
                                    <td><a class="text-dark fw-bold" href="{{ route('contacts.show', $contact) }}">{{ $contact->phone }}</a></td>
                                    <td><a class="text-dark fw-bold" href="{{ route('contacts.show', $contact) }}">{{ $contact->phone2 }}</a></td>
                            </tr>
                            <tr>
                                <td>E-mail</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->email2 }}</td>
                            </tr>
                            <tr>
                                <td>Rođendan:</td>
                                <td>{{ $contact->birthday }}</td>
                            </tr>
                            @if (count($contact->companies)>1)
                            @foreach ($contact->companies as $company)
                            @if ($company->id != $contact->companies[count($contact->companies)-1]->id)
                                <tr>
                                    <td>Prethodna kompanija:</td>
                                    <td>
                                        <a href="{{ route('warehouseCompany.show', $company) }}" class="text-dark">{{ $company->name }}</a>
                                    </td>
                                    <td>
                                        {{ Carbon::parse($company->pivot->start_date)->translatedFormat('d.m.Y.') }} - {{ Carbon::parse($company->pivot->end_date)->translatedFormat('d.m.Y.') }}
                                    </td>
                                </tr>
                            @endif
                            @endforeach
                            @endif
                        </table>

                        <a href="{{ route('contacts.edit', $contact) }}" class=" btn btn-sm btn-primary w-100 mt-2"
                            type="submit">
                            Izmeni Podatke
                        </a>
                    </div>
                </div>
                <x-footer>
                    <a href="{{ route('contacts.index') }}" class="btn btn-sm w-100 btn-outline-dark border-1 mb-2" type="submit">
                        Lista kontakata
                    </a>
                </x-footer>

        </content>
    </main>

@endsection
