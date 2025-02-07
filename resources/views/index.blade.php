@extends('layouts.app')

@section('content')

    {{-- <x-modal :finishes /> --}}

    <x-header :search="true" />
    {{-- Ako ne želimo search ikonicu, vrednost :search ćemo staviti "false" --}}
    <main class="d-flex" id="main">

        <x-sidebar id="sidebar" :links="[]" />
        <content id="content" class="mt-2 px-1">
            @if(!Auth::user())
            <a href="{{ route('auth.create') }}" class="btn w-100 btn-warning my-4">
                Prijavi se
            </a>
            @endif
        </content>
    </main>

@endsection
