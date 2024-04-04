@extends('layouts.layout')

@section('title', 'Index')

@section('content')
    <h1 class="text-center">Tools akti- und deaktivieren, infotexten bearbeiten </h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <a href="{{route('tools.create')}}" type="button" class="btn btn-primary">create</a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Status</th>
                <th scope="col">Tutorial</th>
                <th scope="col">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tools as $tool)
                <tr>
                    <th scope="row">{{$tool->id}}</th>
                    <td>{{$tool->name}}</td>
                    <td>
                        @if($tool->status)
                            An
                        @else
                            Aus
                        @endif


                    </td>
                    <td>{{$tool->tutorial}}</td>

                    <td class="mr-1">
                        <a href="tools/{{$tool->id}}" class="btn btn-warning">Anzeigen</a>
                    </td>
                    <td>
                        <a href="tools/{{$tool->id}}/edit" class="btn btn-success">Bearbeiten</a>
                    </td>
                    <td>
                        <form action="tools/{{$tool->id}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick=" return confirm('Sind Sie sicher, dass Sie diesen Tool {{$tool->name}} löschen möchten ?');">Löschen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

