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
    Hallo Admin,<br/>
    <br/>
    Dies ist eine Mitteilung, weil es ein ungewöhnlich hohes aufkommen an Benutzerkonten und/oder Speicherständen gibt.<br/>
    Sie sollten den Sachverhalt wahrscheinlich überprüfen. Es folgen die genauen Zahlen, welche für diese Meldung gesorgt haben:
    <br/>
    <br/>
    <table>
        <thead>
        <tr>
            <th>Typ</th>
            <th>Anzahl</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Alle Benutzerkonten</td>
            <td>{{$userCount}}</td>
        </tr>
        <tr>
            <td>Erstellte Benutzerkonten innerhalb der letzten Woche</td>
            <td>{{$userLastWeekCount}}</td>
        </tr>
        <tr>
            <td>Alle Speicherstände</td>
            <td>{{$saveCount}}</td>
        </tr>
        <tr>
            <td>Erstellte Speicherstände innerhalb der letzten Woche</td>
            <td>{{$saveLastWeekCount}}</td>
        </tr>
        </tbody>

    </table>
    <br/>
    <br/>
    Mit freundlichen Grüßen<br/>
    Das {{config('app.name')}}-System
</div>
</body>
</html>
