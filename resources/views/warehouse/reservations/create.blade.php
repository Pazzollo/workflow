@extends('warehouse.layouts.app')

@php
    $title = 'Rezervacija materijala';
@endphp

@section('title', $title)

@section('content')

    <x-functions />
    {{-- <x-modal :$finishes :$materialTypes /> --}}

    <div class="sticky-top bg-white">
        <x-header :search="false" :title="$title" />
    </div>
    <main class="d-flex" id="main">

        <x-sidebar id="sidebar" :links="[]" />
        <content id="content" class="mt-2 px-1">

            <x-error-message :message="session('error')" />
            <x-success-message :message="session('success')" />

            <div class="card mb-1 border-2">
                <div class="px-2">
                    <x-card-header :$material />
                </div>
                <div class="card-body">

                    <x-description :$material />

                    <x-state :$material :$quantities :$reservations />

                    <form action="{{ route('reservation.store') }}" method="post">
                        @csrf
                        <div class="mb-2">
                            <input type="hidden" name="material_id" value="{{ $material->id }}">
                            {{-- <input type="hidden" name="user_id" value="{{ auth()->user()->id }}"> --}}
                            {{-- <input type="hidden" name="measure" value="tabaka"> --}}
                            <label for="quantity" class="form-label mb-0">Količina (u tabacima) *</label>
                            <input type="number" class="form-control @error('quantity') border border-danger @enderror" id="quantity" value="{{ old('quantity') }}" name="quantity">
                        </div>

                        <div class="mb-2">
                            <label for="company_id" class="form-label mb-0">Izaberite kupca ili mesto troška</label>
                            <select class="form-select @error('supplier_id') border border-danger @enderror"
                                aria-label="Default select example"
                                name="company_id">
                                <option value="0"></option>

                                @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="description" class="form-label mb-0">Opis (broj naloga ili razlog)*</label>
                            <input type="text" class="form-control @error('description') border border-danger @enderror" id="description" value="{{ old('description') }}" name="description">
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-sm w-100 text-light btn-primary" value="Out">
                                Rezerviši materijal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <x-footer />

        </content>
    </main>

@endsection
