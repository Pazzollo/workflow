@extends('warehouse.layouts.app')

@php
    $title = 'Detalji o formatu papira';
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
                    <label for="name" class="form-label mx-1">Naziv formata</label>
                    <input type="text" class="form-control" name="name" value="{{ $dimension->name }}" disabled>
                </div>
                <div class="d-flex gap-2 mb-3">
                    <div>
                        <label for="width" class="form-label mx-1">Širina (mm)</label>
                        <input type="text" class=" w-100 form-control" value="{{ $dimension->width }}" disabled>
                    </div>
                    <div>
                        <label for="length" class="form-label mx-1">Širina (mm)</label>
                        <input type="text" class="w-100 form-control" value="{{ $dimension->length }}" disabled>
                    </div>
                </div>
                <div class="w-100 mb-3">
                    @error('description')
                        <p class="form-label mb-0 text-danger">{{ $message }}</p>
                    @enderror
                    <label for="description" class="form-label mx-1">Napomena</label>
                    <textarea type="text" class="form-control @error('description') border border-danger @enderror" value="{{ $dimension->description }}" disabled>{{ $dimension->description }}</textarea>
                </div>
            </div>

            <x-footer>
                @if (auth()->user()->role_id == 1)
                    <a href="{{ route('dimension.edit', $dimension) }}" class="btn btn-sm w-100 btn-outline-dark border-1 mb-2" type="submit">
                        Izmeni podatke o formatu
                    </a>
                @endif
                <a href="{{ route('dimension.index') }}" class="btn btn-sm w-100 btn-primary border-1 mb-2" type="submit">
                    Lista formata
                </a>
            </x-footer>

        </content>
    </main>

@endsection
