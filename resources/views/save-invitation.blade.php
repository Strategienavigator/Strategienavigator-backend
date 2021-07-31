<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
<div>
    Hallo,<br/>
    <br/>
    Sie wurden von {{$invite_user}} eingeladen an einem Strategietool mitzuarbeiten.<br/>
    Bitte klicken Sie auf folgenden Link, um diese Einladung anzunehmen:<br/>
    <a href={{ config('app.frontend_url').'/'.$token}}>{{ config('app.frontend_url').'/'.$token}}</a>
    <br/>
    <br/>
    Wenn Sie diese Einladung nicht annehmen wollen ignorieren Sie einfach diese E-Mail.
    <br/>
    <br/>
    Mit freundlichen Grüßen<br/>
    Das Strategietool-Team
</div>
</body>
</html>
