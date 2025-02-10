@extends('warehouse.layouts.app')

@php
    $title = 'Rezervacije';
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

                    <div class="mb-3 w-100">
                        <a href="{{ route('reservation.create', ['id' => $material]) }}"
                            class="btn btn-warning btn-sm w-100">
                            Rezerviši
                        </a>
                    </div>
                    <div class="list-group">

                        @foreach ($reservations as $reservation)
                            @if ($reservation->reserved != 0)
                                <div class="list-group-item list-group-item-action bg-primary text-light px-2"
                                    aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        {{-- <small class="mb-0">{{ mb_substr($reservation->user->first_name, 0, 1) }}. --}}
                                            {{ $reservation->user->name }}</small>
                                        <small class="">{{ $reservation->created_at->format('d.m.Y.') }}</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small>{{ $reservation->description }}</small>
                                        <small>{{ number_format($reservation->quantity, 0, ',', '.') }} tabaka</small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <div class="w-100">
                                            <form action="{{ route('reservation.destroy', $reservation) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button name="delete" value="1"
                                                    class="btn btn-sm btn-danger mt-1 w-100">Poništi</button>
                                            </form>
                                        </div>
                                        <div class="w-100">
                                            <a href='{{ route('reservation.edit', $reservation) }}' class="btn btn-sm btn-light mt-1 w-100">Izmeni</a>
                                        </div>
                                        <div class="w-100">
                                            <form action="{{ route('reservation.destroy', $reservation) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button name="reserve" value="1"
                                                    class="btn btn-sm btn-warning mt-1 w-100">Potvrdi</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <x-footer />

        </content>
    </main>

@endsection
