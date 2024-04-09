@extends('layouts.layout')

@section('title', 'Index')

@section('content')
    <h1 class="text-center">Rollen verwalten</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <a href="{{route('roles.create')}}" type="button" class="btn btn-primary">create</a>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Beschreibung</th>
                <th scope="col">Aktionen</th>
                <th colspan="3"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr>
                    <th scope="row">{{$role->id}}</th>
                    <td>{{$role->name}}</td>
                    <td>{{$role->description}}</td>

                    <td class="mr-1">
                        <a href="roles/{{$role->id}}" class="btn btn-warning">Anzeigen</a>
                    </td>
                    <td>
                        <a href="roles/{{$role->id}}/edit" class="btn btn-success">Bearbeiten</a>
                    </td>
                    <td>
                        <form action="roles/{{$role->id}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick=" return confirm('Sind Sie sicher, dass Sie diese Rolle {{$role->name}} löschen möchten ?');">Löschen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection





