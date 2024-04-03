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
    <form action={{ route('users.update', $user->id) }} method="post">
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
            <select class="form-select" aria-label="Default select example" name="role">
               @foreach($roles as $role)
                   @if($role->id == $user->role_id)
                        <option selected value="{{$role->id}}">{{$role->name}}</option>
                    @else
                    <option value="{{$role->id}}">{{$role->name}}</option>
                    @endif
               @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-info" >update</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


