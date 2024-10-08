@extends('layouts.app')

@section('title', 'Index')

@section('header')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    <h1> {{ __("Tools und Infotexte bearbeiten") }}</h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <a href="{{route('tools.create')}}" type="button" class="btn btn-primary">Erstellen</a>
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
                        <a href="{{ route('tools.show', $tool->id) }}" class="btn btn-warning">Anzeigen</a>
                    </td>
                    <td>
                        <a href="{{ route('tools.edit', $tool->id) }}" class="btn btn-success">Bearbeiten</a>
                    </td>
                    <td>
                        <form aaction="{{ route('tools.destroy', $tool->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick=" return confirm('Sind Sie sicher, dass Sie diesen Tool {{$tool->name}} löschen möchten ?');">Löschen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $tools->links() }}
    </div>
    <script>
        // Flash-Nachrichten nach 5 Sekunden ausblenden
        setTimeout(function() {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                flashMessage.style.display = 'none';
            }
        }, 5000); // 5000 Millisekunden = 5 Sekunden
    </script>
@endsection

