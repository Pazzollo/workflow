@extends('warehouse.layouts.app')

@php
    $title = 'Unos novog tipa premaza';
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
        <content id="content" class="mt-2 px-1">

            <x-error-message :message="session('error')" />
            <x-success-message :message="session('success')" />

            <form method="POST" action="{{ route('finish.store') }}">
                @csrf

                <label for="name" class="form-label mb-0 text-danger">@error('name') {{ $message }} @enderror</label>
                <div class="mb d-flex gap-2 justify-content-between">
                    <div class="w-100">
                        <input type="text" class="form-control @error('name') border border-danger @enderror" value="{{ old('name') ?? session('old_input') }}" name="name" placeholder="Naziv novog premaza *">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary w-100">Unesi</button>
                    </div>
                </div>

            </form>

            <x-footer>

                <a href="{{ route('finish.index') }}" class="btn btn-sm w-100 btn-outline-dark border-1 mb-2" type="submit">
                    Svi tipovi premaza
                </a>

            </x-footer>

        </content>
    </main>

@endsection
