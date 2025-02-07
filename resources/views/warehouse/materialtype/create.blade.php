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
            <div id="buttons" class="d-flex gap-2 sticky-bottom p-1 bg-light mt-4">
                <a href="{{ route('warehouse.index') }}" class="btn btn-sm w-100 text-light" style="background-color: #e25904">
                    Stanje materijala
                </a>
                <a href="{{ route('material.create') }}" class="btn btn-sm w-100 btn-success" type="submit">
                    Novi materijal
                </a>
            </div>
            <div id="buttons" class="pt-2 px-1">
                <a href="{{ url()->previous() }}" class="btn btn-sm w-100 btn-secondary " type="submit">
                    Nazad
                </a>
            </div>
        </content>
    </main>

@endsection
