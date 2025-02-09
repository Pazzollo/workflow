@extends('warehouse.layouts.app')

@php
    $title = 'Vrste materijala';
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

                @foreach ($materialTypes as $type)
                    <div class="d-flex py-1">
                        <div class="px-2 w-100">
                            <a href="{{ route('material_type.show', $type) }}"
                                class="fw-bold text-dark w-100 text-uppercase text-decoration-none">
                                {{ $type->name }}
                            </a>
                        </div>
                        @if (auth()->user()->role_id == 1)
                            <a href="{{ route('material_type.edit', $type) }}"
                                class=" btn btn-sm btn-outline-dark">
                                Izmeni
                            </a>
                        @endif
                    </div>
                @endforeach

                <x-footer>
                    @if (auth()->user()->role_id == 1)
                        <a href="{{ route('material_type.create') }}" class="btn btn-sm w-100 btn-outline-dark border-1 mb-2" type="submit">
                            Dodaj novu vrstu materijala
                        </a>
                    @endif
                </x-footer>

        </content>
    </main>

@endsection
