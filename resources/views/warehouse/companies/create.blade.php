@extends('warehouse.layouts.app')

@php
    $title = 'Novi klijent';
@endphp

@section('title', $title)

@section('content')

    <x-functions />
    {{-- <x-modal :$finishes :$materialTypes /> --}}

    <div class="sticky-top bg-white">
        <x-header :search="false" :title="$title" />
        {{-- Ako ne želimo search ikonicu, vrednost :search ćemo staviti "false" --}}
    </div>
    <main class="d-flex" id="main">
        <x-sidebar id="sidebar" :links="[]" />
        <content id="content" class="mt-2 px-1">

            <x-error-message :message="session('error')" />
            <x-success-message :message="session('success')" />

            <form action="{{ route('warehouseCompany.store') }}" method="post" class="px-1">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Naziv firme *</label>
                    <input type="text" class="form-control form-control-sm" id="name" name="name">
                </div>
                <div class="mb-3 d-flex gap-2">
                    <div class="w-50">
                        <label for="phone1" class="form-label">Telefon *</label>
                        <input type="text" class="form-control form-control-sm" id="phone1" name="phone1">
                    </div>
                    <div class="w-50">
                        <label for="phone2" class="form-label">Telefon 2</label>
                        <input type="text" class="form-control form-control-sm" id="phone2" name="phone2">
                    </div>
                </div>
                <div class="mb-3 d-flex gap-2">
                    <div class="w-50">
                        <label for="email1" class="form-label">E-mail *</label>
                        <input type="email" class="form-control form-control-sm" id="email1" name="email1">
                    </div>
                    <div class="w-50">
                        <label for="email2" class="form-label">E-mail</label>
                        <input type="email" class="form-control form-control-sm" id="email2" name="email2">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Adresa *</label>
                    <input type="text" class="form-control form-control-sm" id="address" name="address">
                </div>
                <div class="mb-3 d-flex gap-2">
                    <div class="w-75">
                        <label for="city" class="form-label">Grad *</label>
                        <input type="text" class="form-control form-control-sm" id="city" name="city">
                    </div>
                    <div class="w-25">
                        <label for="zipcode" class="form-label">Poštanski broj</label>
                        <input type="text" class="form-control form-control-sm" id="zipcode" name="zipcode">
                    </div>
                </div>
                <div class="mb-3 d-flex gap-2">
                    <div class="w-50">
                        <label for="pib" class="form-label">PIB *</label>
                        <input type="text" class="form-control form-control-sm" id="pib" name="pib">
                    </div>
                    <div class="w-50">
                        <label for="mbr" class="form-label">Matični broj *</label>
                        <input type="text" class="form-control form-control-sm" id="mbr" name="mbr">
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="customer" name="customer">
                    <label class="form-check-label" for="flexCheckDefault">
                      Kupac
                    </label>
                  </div>
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="supplier" name="supplier">
                    <label class="form-check-label" for="flexCheckChecked">
                      Dobavljač
                    </label>
                  </div>
                <button type="submit" class="btn btn-primary btn-sm w-100 mb-3">Unesi</button>
            </form>

        <x-footer />

        </content>
    </main>

@endsection
