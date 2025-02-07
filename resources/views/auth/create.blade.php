@extends('warehouse.layouts.app')

@section('content')
    <div id="wrapper">

        {{-- <x-modal /> --}}

        <x-header :search="false" :burger="false" :sign="false" />

        {{-- Ako ne želimo search ikonicu, vrednost :search ćemo staviti "false",
            isto važi i za hamburger meni --}}
        <main class="d-flex" id="main">

            <content id="" class="px-1 m-auto w-75">

                @if (session('error'))

                <div class="card mt-2 border border-danger">
                    <div class="card-body text-danger text-center">
                      {{ session('error') }}
                    </div>
                </div>

                @endif

                <h2 class="text-center pt-3 font-medium fs-3">Prijavite se</h2>

                <form action="{{ route('auth.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label mt-2">Email address</label>
                        <input value="{{ old('email') }}" type="email" name="email" class="form-control" id="email"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                    <button type="submit" class="btn w-100 btn-primary">Prijavi se</button>
                </form>
            </content>
        </main>
    </div>
@endsection
