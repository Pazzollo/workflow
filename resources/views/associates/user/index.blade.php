<?php
use Illuminate\Support\Facades\Redirect;
?>

@extends('associates.layouts.app')

@section('title', 'Početna')

@section('content')

<style>
    .card-hover:hover {
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    }
</style>

@if (session('error'))
    <div class="alert alert-danger mt-3" style="max-width: 450px">
        {{ session('error') }}
    </div>
@endif

<table class="table table-sm table-hover table-striped- mt-3">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Ime i prezime</th>
            <th scope="col">Firma</th>
            <th scope="col">E-mail</th>
            <th scope="col">Telefon 1</th>
            <th scope="col">Telefon 2</th>
            <th scope="col">Pozicija</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
    @foreach ($users as $user)
    @if (Auth::user()->role_id == 1 || Auth::user()->company_id == $user->company->id)
        <tr>
            <td scope="col">{{ $user->id }}</td>
            <td scope="col">{{ $user->name }}</td>
            <td scope="col">{{ $user->company->name }}</td>
            <td scope="col">{{ $user->email }}</td>
            <td scope="col">{{ $user->phone1 }}</td>
            <td scope="col">{{ $user->phone2 }}</td>
            <td scope="col">{{ $user->role->name }}</td>
            <th scope="col">
                <a href="{{ route('user.show', $user) }}" class="btn btn-sm btn-primary me-1 {{ !(Auth::user()->role_id == 1 || Auth::user()->company_id == $user->company->id) ? 'disabled' : '' }}">Izmeni</a>
            </th>
        </tr>
    @endif
    @endforeach
    </tbody>
</table>

@endsection
