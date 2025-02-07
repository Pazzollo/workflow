@extends('associates.layouts.app')

@section('title', 'Novi saradnik')

@section('content')

@if (session('company'))
    <div class="alert alert-danger">
        {{ session('company') }}
    </div>
@endif

@if (session('transfer'))
    <div class="alert alert-success">
        {{ session('transfer') }}
    </div>
@endif

<div class="d-flex flex-column flex-shrink-0 p-3" style="max-width: 200px">

    <ul class="nav nav-pills flex-column mb-auto" style="position: fixed">
        <li class="nav-item">
            <button class="text-start btn btn-info w-100" type="button" style="pointer-events: none">
                Saradnici
            </button>
        </li>
        <hr>
        <li>
            <a href="{{ route('company.create') }}" class="btn bg-primary text-light mt-2 text-start w-100">
            Novi saradnik
            </a>
        </li>
        <li>
            <a href="{{ route('company.index', ['role' => 3]) }}" class="btn btn-info mt-2 text-start w-100">
            Kupci
            </a>
        </li>
        <li>
            <a href="{{ route('company.index', ['role' => 4]) }}" class="btn btn-info mt-2 text-start w-100">
            Dobavljači
            </a>
        </li>
    </ul>

</div>

@endsection
