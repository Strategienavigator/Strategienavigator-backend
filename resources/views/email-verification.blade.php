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
    Hallo,<br />
    <br />
    wir haben eine Anfrage zur Erstellung eines Benutzerkontos für die Strategietoolanwendung erhalten.<br />
    Bitte klicken Sie auf folgenden Link, um Ihre Registrierung abzuschließen:<br />
    <a href={{ config('app.frontend_url').'/'.$token}}>{{ config('app.frontend_url').'/'.$token}}</a>
    <br />
    <br />
    Mit freundlichen Grüßen<br />
    Das Strategietool-Team
</div>
</body>
</html>
