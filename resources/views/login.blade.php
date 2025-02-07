@extends('layouts.app')

@section('content')
@error('error')
    {{ $message }}
@enderror
<div class="d-flex align-items-center py-4">
    <form class="form-signin m-auto" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
            @error('email')
                <div class="text-danger p-1">{{ $message }}</div>
            @enderror
        </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1">
            @error('email')
                <div class="text-danger p-1">{{ $message }}</div>
            @enderror
            </div>
        <button class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection

