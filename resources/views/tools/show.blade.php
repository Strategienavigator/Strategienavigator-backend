@extends('layouts.layout')

@section('title', 'Show')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">ID: {{$tool->id}}</h5>
                <h6 class="card-subtitle mb-2 text-body-secondary">Name: {{$tool->name}}</h6>
                <p class="card-text">Status:  @if($tool->status == 1) An  @else Aus @endif</p>
                <p class="card-text">Tutorial: {{$tool->tutorial}}</p>
                <a href="{{route('tools.index')}}" class="card-link">back</a>
            </div>
        </div>
    </div>
@endsection



