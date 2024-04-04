@extends('layouts.layout')

@section('title', 'Show')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">ID: {{$user->id}}</h5>
                <h6 class="card-subtitle mb-2 text-body-secondary">Benutzername: {{$user->useranme}}</h6>
                <p class="card-text">Email: {{$user->email}}</p>
                <p class="card-text">Role: {{$user->role->name}}</p>
                <a href="{{route('users.index')}}" class="card-link">back</a>
            </div>
        </div>
    </div>
@endsection



