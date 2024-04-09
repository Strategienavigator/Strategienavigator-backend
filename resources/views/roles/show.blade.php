@extends('layouts.layout')

@section('title', 'Show')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">ID: {{$role->id}}</h5>
                <p class="card-text">Name: {{$role->name}}</p>
                <p class="card-text">Beschreibung: {{$role->description}}</p>
                <a href="{{route('roles.index')}}" class="card-link">back</a>
            </div>
        </div>
    </div>
@endsection




