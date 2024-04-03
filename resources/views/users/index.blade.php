<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Roles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<h1 class="text-center">Benutzer verwalten</h1>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container">
    <a href="{{route('users.create')}}" type="button" class="btn btn-primary">Erstellen</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Benutzername</th>
                <th scope="col">Email</th>
                <th scope="col">Rolle</th>
                <th scope="col">Aktionen</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->username}}</td>
                <td>{{$user->email}}
                <td>{{$user->role->name}}</td>

                <td class="mr-1">
                    <a href="users/{{$user->id}}" class="btn btn-warning">Anzeigen</a>
                </td>
                <td>
                    <a href="users/{{$user->id}}/edit" class="btn btn-success">Bearbeiten</a>
                </td>
                <td>
                    <form action="users/{{$user->id}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick=" return confirm('Sind Sie sicher, dass Sie diesen Benutzer {{$user->username}} löschen möchten ?');">löschen</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

