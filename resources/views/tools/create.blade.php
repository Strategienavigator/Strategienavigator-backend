@extends('layouts.layout')

@section('title', 'Create')

@section('content')
    <div class="container">
        <form action={{ route('tools.store') }} method="post">
            @csrf
            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <input type="text" class="form-control" id="id" name="id" value="{{$counter}}" disabled>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name"  name="name" placeholder="Tool name">
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
                <textarea class="form-control" id="tutorial" name="tutorial" rows="3">Info Text</textarea>
            </div>
            <button type="submit" class="btn btn-info" >Erstellen</button>
        </form>
    </div>
@endsection


