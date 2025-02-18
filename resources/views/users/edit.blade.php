@extends('layouts.app')

@section('title', 'Bearbeiten')

@section('header')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    <h1> {{ __("Benutzer bearbeiten") }}</h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <form action={{ route('admin.users.update', $user->id) }} method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <input type="text" class="form-control" id="id" name="id" value="{{$user->id}}" readonly>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Benutzername</label>
                <input type="text" class="form-control" id="name"  name="name" value="{{$user->username}}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email"  name="email" value="{{$user->email}}">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Role</label>
                <select class="form-select" name="role">
                    @foreach($roles as $role)
                        @if($role->id == $user->role_id)
                            <option selected value="{{$role->id}}">{{$role->name}}</option>
                        @else
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <!-- Password fields: New additions for password change -->
            <div class="mb-3">
                <label for="password" class="form-label">Neues Passwort</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Neues Passwort">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Passwort bestätigen</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Passwort bestätigen">
            </div>

            <button type="submit" class="btn btn-info" >update</button>
        </form>
    </div>
@endsection


