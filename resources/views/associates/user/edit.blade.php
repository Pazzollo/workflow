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
<section style="background-color: #eee;">
    <div class="container pt-1 mt-3">
      {{-- <div class="row">
        <div class="col">
          <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">User</a></li>
              <li class="breadcrumb-item active" aria-current="page">User Profile</li>
            </ol>
          </nav>
        </div>
      </div> --}}

    <div class="row mt-2 mb-2">
        <div class="col-lg-4">
            <div class="card mb-4 pb-1">
                <div class="card-body text-center">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                    class="rounded-circle img-fluid" style="width: 150px;">
                <h5 class="my-3">{{ $user->name }}</h5>
                <p class="text-muted mb-1">{{ $user->role->name }}</p>
                {{-- <p class="text-muted mb-4">Bay Area, San Francisco, CA</p> --}}
                </div>
            </div>
          {{-- <div class="card mb-4 mb-lg-0">
            <div class="card-body p-0">
              <ul class="list-group list-group-flush rounded-3">
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="fas fa-globe fa-lg text-warning"></i>
                  <p class="mb-0">https://mdbootstrap.com</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="fab fa-github fa-lg text-body"></i>
                  <p class="mb-0">mdbootstrap</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                  <p class="mb-0">@mdbootstrap</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                  <p class="mb-0">mdbootstrap</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                  <p class="mb-0">mdbootstrap</p>
                </li>
              </ul>
            </div>
          </div> --}}
        </div>
        <div class="col-lg-8">
            <form method="POST" action={{ route('user.update', $user->id) }}>
                @csrf
                @method('PUT')
                <div class="card mb-4">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                        <p class="mb-1 mt-1">Firma</p>
                        </div>
                        <div class="col-sm-9">
                        <input type="text" class="form-control text-muted mb-1 mt-1" value="{{ $user->company->name }}" disabled></input>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-1 mt-1">Email</p>
                        </div>
                        <div class="col-sm-9">
                            <input type="email" class="form-control text-muted mb-1 mt-1" value="{{ $user->email }}" name="email"></input>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-1 mt-1">Telefon</p>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control text-muted mb-1 mt-1" value="{{ $user->phone1 }}" name="phone1"></input>
                        </div>
                        @error('phone1')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                        <p class="mb-1 mt-1">Telefon</p>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control text-muted mb-1 mt-1" value="{{ $user->phone2 }}" name="phone2"></input>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                        <p class="mb-1 mt-1">Nova lozinka</p>
                        </div>
                        <div class="col-sm-9">
                            <input type="password" class="form-control text-muted mb-1 mt-1" value="{{ $user->password }}" name="password"></input>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                        <p class="mb-1 mt-1">Ponovi lozinku</p>
                        </div>
                        <div class="col-sm-9">
                            <input type="password" class="form-control text-muted mb-1 mt-1" value="{{ $user->password }}" name="password_check"></input>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                        <p class="mb-1 mt-1">Address</p>
                        </div>
                        <div class="col-sm-9">
                        <p class="text-muted mb-1 mt-1">Bay Area, San Francisco, CA</p>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mb-2 gap-3">
                    <button type="submit" class="btn btn-primary">Izmeni</button>
                    <a href="{{ url()->previous() }}"name="cancel" class="btn btn-info">Nazad</a>
                </div>
            {{-- <div class="row">
                <div class="col-md-6">
                <div class="card mb-4 mb-md-0">
                    <div class="card-body">
                    <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status
                    </p>
                    <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                    <div class="progress rounded" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                    <div class="progress rounded" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                    <div class="progress rounded" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                    <div class="progress rounded" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                    <div class="progress rounded mb-2" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-md-6">
                <div class="card mb-4 mb-md-0">
                    <div class="card-body">
                    <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status
                    </p>
                    <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                    <div class="progress rounded" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                    <div class="progress rounded" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                    <div class="progress rounded" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                    <div class="progress rounded" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                    <div class="progress rounded mb-2" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                </div>
                </div>
            </div> --}}
            </form>
        </div>

    </div>
    </form>
    </div>
  </section>

@endsection
