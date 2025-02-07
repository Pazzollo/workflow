@extends('warehouse.layouts.app')

@php
    $title = 'Promene stanja';
@endphp

@section('title', $title)

@section('content')

    <x-functions />
    {{-- <x-modal :$finishes :$materialTypes /> --}}

    <div class="sticky-top bg-white">
        <x-header :search="false" :title="$title" />
    </div>
    <main class="d-flex overflow-auto" id="main">

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
                        <a href="{{ route('warehouse.create', ['id' => $material]) }}" class="btn btn-warning btn-sm w-100">
                            Ulaz - Izlaz materijala
                        </a>
                    </div>
                    <div class="list-group">

                        @php
                            $i = 0;
                            $tmp = 0;
                            $state[$i] = 0;
                            foreach (array_reverse($quantities->toArray()) as $quantity) {
                                $ammount[$i] = $quantity['quantity'];
                                $tmp += $ammount[$i];
                                $state[$i] = $tmp;
                                $i++;
                            }
                            $state = array_reverse($state);

                            $i = 0;
                        @endphp

                        @foreach ($quantities as $quantity)
                            <div class="list-group-item list-group-item-action"
                                style="background-color:  {{ $quantity->transfer == 'In' ? '#9df5da' : '#f28691' }}"
                                aria-current="true">
                                <div class="d-flex w-100 justify-content-between">
                                    <small class="mb-0">{{ $quantity->transfer == 'In' ? 'Ulaz' : 'Izlaz' }}</small>
                                    <small class="">{{ $quantity->created_at->format('d.m.Y.') }}</small>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small>{{ $quantity->company->name }}</small>
                                    <small>{{ $quantity->description }}</small>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0"><b>{{ number_format($quantity->quantity, 0, ',', '.') }}</b>
                                        {{ $quantity->measure }}</p>
                                    <p class="mb-0 d-flex align-items-end" style="font-size: 14px">
                                        {{ number_format($state[$i], 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </div>
                </div>
            </div>

            <x-footer />

        </content>
    </main>

@endsection
