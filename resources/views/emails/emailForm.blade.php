@extends('layouts.layout')

@section('title', 'Create')

@section('content')
    <h1 class="text-center"> Email senden </h1>
    <div class="container">
        <form action={{ route('send.email') }} method="post">
            @csrf

            @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="subject"  name="subject" placeholder="">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Gruppe auswählen</label>
                <select class="form-select" aria-label="Default select example" name="group">
                    <option selected value="admin">Admin</option>
                    <option selected value="normal">Normal</option>
                    <option selected value="anonym">Anonym</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Nachricht</label>
                <textarea class="form-control" id="body" name="body" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-info" >senden</button>
        </form>
    </div>
@endsection





