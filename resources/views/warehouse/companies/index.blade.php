@extends('warehouse.layouts.app')

@php
    if(isset($_GET['role'])) {
        $_GET['role'] == 3 || $_GET['role'] == 4 ? $title = $_GET['role'] == 3 ? 'Lista kupaca' : 'Lista dobavljača' : $title = 'Lista saradnika';
    }
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

                @foreach ($companies as $company)
                    <div class="card mb-2 border-1 px-2 pb-2">

                        <div class="">
                            <div class="d-flex justify-content-around align-items-end mt-2 gap-2">
                                <div class="text-dark w-100"><span class="fw-bold">{{ $company->name }}</span> - {{ $company->city }}</div>
                                <a href="{{ route('warehouseCompany.show', $company) }}"
                                    class=" btn btn-sm btn-outline-dark">
                                    Detalji
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <x-footer>
                    <a href="{{ route('warehouseCompany.index', ['role' => ($_GET['role'] == 4 ? 3 : 4)]) }}" class="btn btn-sm w-100 btn-outline-dark border-1 mb-2" type="submit">
                        {{ $_GET['role'] == 4 ? 'Lista kupaca' : 'Lista dobavljača' }}
                    </a>
                </x-footer>

        </content>
    </main>

@endsection
