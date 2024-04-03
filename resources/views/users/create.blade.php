<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


