@extends('warehouse.layouts.app')

@php
    $title = 'Novi format papira';
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

            <form method="POST" action="{{ route('dimension.store') }}">
                @csrf

                <div>
                    <div class="w-100 mb-3">
                        <label for="name" class="form-label mx-1">Naziv novog formata *</label>
                        <input type="text" class="form-control @error('name') border border-danger @enderror"
                            value="{{ old('name') ?? session('old_input') }}" name="name"
                            placeholder="Unesi naziv novog formata">
                        @error('name')
                            <p class="form-label mb-0 text-danger fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="d-flex gap-2 mb-3">
                        <div>
                            <label for="width" class="form-label mx-1">Širina (mm) *</label>
                            <input type="text" class=" w-100 form-control @error('width') border border-danger @enderror"
                                value="{{ old('width') ?? session('old_input') }}" name="width"
                                placeholder="Unesi širinu formata">
                            @error('width')
                                <p class="form-label mb-0 text-danger fs-6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="length" class="form-label mx-1">Širina (mm) *</label>
                            <input type="text" class="w-100 form-control @error('length') border border-danger @enderror"
                                value="{{ old('length') ?? session('old_input') }}" name="length"
                                placeholder="Unesi širinu formata">
                            @error('length')
                                <p class="form-label mb-0 text-danger fs-6">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="w-100 mb-3">
                        @error('description')
                            <p class="form-label mb-0 text-danger">{{ $message }}</p>
                        @enderror
                        <label for="description" class="form-label mx-1">Napomena</label>
                        <textarea type="text" class="form-control @error('description') border border-danger @enderror"
                            value="{{ old('description') ?? session('old_input') }}" name="description" placeholder="Napomena"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-sm mt-4 w-100">Unesi</button>
            </form>

            <x-footer>
                <a href="{{ route('dimension.index') }}" class="btn btn-sm w-100 btn-outline-dark border-1 mb-2"
                    type="submit">
                    Lista formata
                </a>
            </x-footer>
        </content>
    </main>

@endsection
