@extends('warehouse.layouts.app')

@php
    $title = 'Izmena podataka o kontaktu';
@endphp

@section('title', $title)

@section('content')
<div class="container">

    <x-functions />
    <x-search-companies />

    <div class="sticky-top bg-white">
        <x-header :search="true" :title="$title" />
        {{-- Ako ne želimo search ikonicu, vrednost :search ćemo staviti "false" --}}
    </div>
    <main class="d-flex" id="main">
        <x-sidebar id="sidebar" :links="[]" />
        <content id="content" class="mt-2 px-1">

            <x-error-message :message="session('error')" />
            <x-success-message :message="session('success')" />

            <x-contact-store-edit :$companies :$contact />

            <x-footer />

        </content>
    </main>

</div>
@endsection
