@extends('layouts.app')

@section('title', 'Bearbeiten')

@section('header')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    <h1> {{ __("Tool bearbeiten") }}</h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <form action={{ route('admin.tools.update', $tool->id) }} method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <input type="text" class="form-control" id="id" name="id" value="{{$tool->id}}" disabled>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name"  name="name" value="{{$tool->name}}">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" aria-label="Default select example" name="status">
                    <option value="1" {{ $tool->status == 1 ? 'selected' : '' }}>An</option>
                    <option value="0" {{ $tool->status ==0 ? 'selected' : '' }}>Aus</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tutorial" class="form-label">Tutorial</label>
                <textarea class="form-control" id="tutorial" name="tutorial" rows="3">{{$tool->tutorial}}</textarea>
            </div>
            <button type="submit" class="btn btn-info" >Aktualisieren</button>
            <a href="{{ route('admin.tools.index') }}" class="btn btn-warning">Zurück</a>
        </form>
    </div>
@endsection



