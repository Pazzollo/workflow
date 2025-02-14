@extends('workflow.layouts.app')

@php
    $title = 'Radni nalozi';
@endphp

@section('title', $title)

@section('content')

    <x-functions />

    <div class="sticky-top bg-white">
        <button class="btn btn-secondary btn-sm m-2">{{ auth()->user()->name }}</button>

    </div>

    <main class="d-flex" id="main">

    </main>

@endsection
