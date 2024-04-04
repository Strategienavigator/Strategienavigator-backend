@extends('layouts.layout')

@section('title', 'Show')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">ID: {{$role->id}}</h5>
                <h6 class="card-subtitle mb-2 text-body-secondary">Name: {{$role->name}}</h6>
                <p class="card-text">Description: {{$role->description}}</p>
                <a href="{{route('roles.index')}}" class="card-link">back</a>
            </div>
        </div>
    </div>
@endsection




