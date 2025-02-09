@extends('warehouse.layouts.app')

@php
    $title = 'Unos nove vrste materijala';
@endphp

@section('title', $title)

@section('content')

    <x-functions />
    <x-modal :$finishes :$materialTypes />

    <div class="sticky-top bg-white">
        <x-header :search="false" :title="$title" />
        {{-- Ako ne želimo search ikonicu, vrednost :search ćemo staviti "false" --}}
    </div>
    <main class="d-flex" id="main">

        <x-sidebar id="sidebar" :links="[]" />
        <content id="content" class="mt-2 px-1 w-100">
            @if(!Auth::user())
                <a href="{{ route('auth.create') }}" class="btn w-100 btn-warning my-4">
                    Prijavi se
                </a>
            @else
            <x-error-message :message="session('error')" />
            <x-success-message :message="session('success')" />
                <form method="POST" action="{{ route('material_type.store') }}">
                    @csrf

                    <label for="name" class="form-label mb-0 text-danger">@error('name') {{ $message }} @enderror</label>
                    <div class="mb d-flex gap-2 justify-content-between">
                        <div class="w-50">
                            <input type="text" class="form-control @error('name') border border-danger @enderror" id="exampleInputPassword1" value="{{ old('name') ?? session('old_input') }}" name="name" placeholder="Naziv nove kategorije *">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary w-100">Unesi</button>
                        </div>
                    </div>

                </form>
            @endif
            <x-footer>
                <a href="{{ route('material_type.index') }}" class="btn btn-sm w-100 btn-outline-dark border-1 mb-2" type="submit">
                    Sve vrste materijala
                </a>
            </x-footer>
        </content>
    </main>

@endsection
