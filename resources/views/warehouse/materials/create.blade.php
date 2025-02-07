@extends('warehouse.layouts.app')

@php
    $title = 'Unos novog materijala';
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
            <form method="POST" action="{{ route('material.store') }}">
                @csrf
                <div class="mb-2">
                    <label for="exampleInputEmail1" class="form-label mb-0">Vrsta materijala *</label>
                    <select class="form-select @error('materialtype_id') border border-danger @enderror"
                        aria-label="Default select example" name="materialtype_id">
                        <option value="0">Izaberite vrstu materijala</option>

                        @foreach ($materialTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-2">
                    <label for="exampleInputPassword1" class="form-label mb-0">Brend *</label>
                    <input type="text" class="form-control @error('brand') border border-danger @enderror"
                        id="exampleInputPassword1" value="{{ old('brand') }}" name="brand">
                </div>

                <div class="mb-2">
                    <label for="exampleInputEmail1" class="form-label mb-0">Vrsta materijala *</label>
                    <select class="form-select @error('finish_id') border border-danger @enderror"
                        aria-label="Default select example" name="finish_id">
                        <option value="0">Izaberite tip premaza *</option>

                        @foreach ($finishes as $finish)
                            <option value="{{ $finish->id }}">{{ $finish->name }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="d-flex gap-2">
                    <div class="mb-2">
                        <label for="exampleInputPassword1" class="form-label mb-0">Širina *</label>
                        <input type="number" class="form-control @error('width') border border-danger @enderror"
                            id="exampleInputPassword1" value="{{ old('width') }}" name="width">
                    </div>
                    <div class="mb-2">
                        <label for="exampleInputPassword1" class="form-label mb-0">Dužina (smer tabaka) *</label>
                        <input type="number" class="form-control @error('length') border border-danger @enderror"
                            id="exampleInputPassword1" value="{{ old('length') }}" name="length">
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="mb-2">
                        <label for="exampleInputPassword1" class="form-label mb-0">Naziv formata *</label>
                        <input type="text"
                            class="form-control @error('dimension_name') border border-danger @enderror"
                            id="exampleInputPassword1" value="{{ old('dimension_name') }}" name="dimension_name">
                    </div>

                    <div class="mb-2">
                        <label for="exampleInputPassword1" class="form-label mb-0">Gramatura *</label>
                        <input type="number" class="form-control @error('weight') border border-danger @enderror"
                            id="exampleInputPassword1" value="{{ old('weight') }}" name="weight">
                    </div>
                </div>

                <div class="mb-2">
                    <label for="exampleInputPassword1" class="form-label mb-0">Debljina (u mikronima)</label>
                    <input type="number" class="form-control @error('tickness') border border-danger @enderror"
                        id="exampleInputPassword1" value="{{ old('tickness') }}" name="tickness">
                </div>

                <div class="mb-2">
                    <label for="exampleInputPassword1" class="form-label mb-0">Kratak opis</label>
                    <textarea class="form-control @error('description') border border-danger @enderror" name="description" id="description">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-sm btn-primary w-100">Unesi</button>
                <div id="buttons" class="pt-2">
                    <a href="{{ url()->previous() }}" class="btn btn-sm w-100 btn-secondary " type="submit">
                        Nazad
                    </a>
                </div>
            </form>
        </content>
    </main>
@endsection
