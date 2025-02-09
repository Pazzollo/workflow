@extends('warehouse.layouts.app')

@php
    $title = 'Vrsta premaza';
@endphp

@section('title', $title)

@section('content')

    <x-functions />
    {{-- <x-modal :$finishes :$materialTypes /> --}}

    <div class="sticky-top bg-white">
        <x-header :search="false" :title="$title" />
        {{-- Ako ne želimo search ikonicu, vrednost :search ćemo staviti "false" --}}
    </div>
    <main class="d-flex" id="main">

        <x-sidebar id="sidebar" :links="[]" />
        <content id="content" class="mt-2 px-1">

            <x-error-message :message="session('error')" />
            <x-success-message :message="session('success')" />

            <div>
                <div class="w-100 mb-3">
                    <label for="name" class="form-label mx-1">Naziv premaza</label>
                    <input type="text" class="form-control" name="name" value="{{ $materialType->name }}" disabled>
                </div>
            </div>

            <x-footer>
                @if (auth()->user()->role_id == 1)
                    <a href="{{ route('material_type.edit', $materialType) }}" class="btn btn-sm w-100 btn-outline-dark border-1 mb-2" type="submit">
                        Izmeni podatke vrsti materijala
                    </a>
                @endif
                <a href="{{ route('material_type.index') }}" class="btn btn-sm w-100 btn-primary border-1 mb-2" type="submit">
                    Lista vrsti materijala
                </a>
            </x-footer>

        </content>
    </main>

@endsection
