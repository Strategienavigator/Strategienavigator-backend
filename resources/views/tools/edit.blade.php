@extends('layouts.layout')

@section('title', 'Edit')

@section('content')
    <div class="container">
        <form action={{ route('tools.update', $tool->id) }} method="post">
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
                    <option selected value="1">An</option>
                    <option selected value="0">Aus</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tutorial" class="form-label">Tutorial</label>
                <textarea class="form-control" id="tutorial" name="tutorial" rows="3">{{$tool->tutorial}}</textarea>
            </div>
            <button type="submit" class="btn btn-info" >update</button>
        </form>
    </div>
@endsection



