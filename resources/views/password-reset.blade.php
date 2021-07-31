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
    wir haben eine Anfrage auf Zurücksetzung des Passwortes für Ihr Benutzerkonto erhalten.<br/>
    Bitte klicken Sie auf folgenden Link, um Ihr Passwort zurückzusetzen:<br/>
    <a href={{ config('app.frontend_url').'/'.$token}}>{{ config('app.frontend_url').'/'.$token}}</a>
    <br/>
    <br/>
    Dieser Link ist für eine Stunde gültig.<br/>
    Wenn Sie Ihr Passwort doch nicht vergessen haben, ignorieren Sie einfach diese E-Mail.
    <br/>
    <br/>
    Mit freundlichen Grüßen<br/>
    Das Strategietool-Team
</div>
</body>
</html>
