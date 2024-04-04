@extends('layouts.layout')

@section('title', 'Edit')

@section('content')
    <div class="container">
        <form action={{ route('roles.update', $role->id) }} method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <input type="text" class="form-control" id="id" name="id" placeholder="{{$role->id}}" readonly>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name"  name="name" placeholder="{{$role->name}}">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{$role->description}}</textarea>
            </div>
            <button type="submit" class="btn btn-info" >update</button>
        </form>
    </div>
@endsection





