@extends('warehouse.layouts.app')

@php
    $title = 'Lista Materijala';
@endphp

@section('title', $title)

@section('content')

    <x-functions />
    <x-modal :$finishes :$materialTypes />

    <div class="sticky-top bg-white">
        <x-header :search="true" :title="$title" />
        {{-- Ako ne želimo search ikonicu, vrednost :search ćemo staviti "false" --}}
    </div>
    <main class="d-flex" id="main">
        <x-sidebar id="sidebar" :links="[]" />
        <content id="content" class="mt-2 px-1">
            @if(!Auth::user())
                <a href="{{ route('auth.create') }}" class="btn w-100 btn-warning my-4">
                    Prijavi se
                </a>
            @else

            <x-error-message :message="session('error')" />
            <x-success-message :message="session('success')" />

                @foreach ($materials as $material)
                    <div class="card mb-2 border-1 px-2 pb-2">
                        <x-card-header :material="$material" />

                        <div class="d-flex gap-2">
                            <a href="{{ route('material.edit', $material) }}" class=" btn btn-sm btn-outline-dark w-100"
                                type="submit">
                                Izmena
                            </a>
                            <a href="{{ route('warehouse.create', ['id' => $material]) }}" class=" btn btn-sm btn-primary w-100"
                                type="submit">
                                Promena stanja
                            </a>
                            <a href="{{ route('material.show', $material) }}" class="btn btn-sm btn-secondary w-100"
                                type="submit">
                                Stanje
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
            
            <x-footer />

        </content>
    </main>

@endsection
