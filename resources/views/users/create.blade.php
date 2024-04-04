@extends('layouts.layout')

@section('title', 'Create')

@section('content')
    <div class="container">
        <form action={{ route('users.store') }} method="post">
            @csrf
            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <input type="text" class="form-control" id="id" name="id" value="{{$counter}}" disabled>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Benutzername</label>
                <input type="text" class="form-control" id="name"  name="name" placeholder="">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email"  name="email" placeholder="">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Passwort</label>
                <input type="password" class="form-control" id="email"  name="password" placeholder="">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Rolle</label>
                <select class="form-select" aria-label="Default select example" name="role">
                    @foreach($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-info" >Erstellen</button>
        </form>
    </div>
@endsection



