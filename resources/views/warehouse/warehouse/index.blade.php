@extends('warehouse.layouts.app')

@php
    $title = 'Stanje materijala';
@endphp

@section('title', $title)

@section('content')

    <x-functions />
    <x-modal :$finishes :$materials :$materialTypes />

    <div class="sticky-top bg-white">
        <x-header :search="true" :title="$title" />
        {{-- Ako ne želimo search ikonicu, vrednost :search ćemo staviti "false" --}}

    </div>
    <main class="d-flex" id="main">
        <x-sidebar id="sidebar" :links="[]" />

        <content id="content" class="mt-2 px-1">
            <x-error-message :message="session('error')" />
            <x-success-message :message="session('success')" />

            <div id="scroll">
                @foreach ($materials as $material)
                <div class="card mb-2 border-1 px-2 pb-2">
                    <x-card-header :$material />

                    <div class="card-body pt-3 pb-1 px-0">
                        <div class="d-flex justify-content-between">
                            <div
                                class="btn btn-sm {{ $quantities->where('material_id', $material->id)->sum('quantity') - $reservations->where('material_id', $material->id)->where('reserved', 1)->sum('quantity') <= 0 ? 'btn-danger' : 'btn-success' }}">
                                {{-- Ako je stanje sa rezervacijama negativno, dugme je crveno, u suprotnom je zeleno --}}

                                {{ number_format(($quantities->where('material_id', $material->id)->sum('quantity') - $reservations->where('material_id', $material->id)->where('reserved', 1)->sum('quantity')), 0, ',', '.') }} tabaka
                                {{-- Stanje materijala sa rezervacijama --}}
                            </div>
                            <div><a href="{{ route('material.show', $material) }}"
                                    class="btn btn-sm btn-primary">Detalji</a></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <x-footer />

        </content>

    </main>

@endsection
