@extends('warehouse.layouts.app')

@php
    $title = 'Formati papira';
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

                @foreach ($dimensions as $dimension)
                    <div class="card mb-1 border-1">

                        <div class="px-2 py-1">
                            <div class="d-flex justify-content-around align-items-end gap-2">
                                <div class="text-dark w-100"><span class="fw-bold">{{ $dimension->name }}</span> - {{ $dimension->width }} x {{ $dimension->length }}</div>
                                <a href="{{ route('dimension.show', $dimension) }}"
                                    class=" btn btn-sm btn-outline-dark">
                                    Detalji
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <x-footer>
                    @if (auth()->user()->role_id == 1)
                        <a href="{{ route('dimension.create') }}" class="btn btn-sm w-100 btn-outline-dark border-1 mb-2" type="submit">
                            Dodaj novi format papira
                        </a>
                    @endif
                </x-footer>

        </content>
    </main>

@endsection
