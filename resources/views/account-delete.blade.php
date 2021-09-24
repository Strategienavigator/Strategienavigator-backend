<!DOCTYPE html>
<html lang="de">
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

    <p>Hallo {{$username}},<br/></p>
    <br/>
    <p>
        wir haben eine Anfrage zum löschen Ihres Benutzerkontos bekommen. Um Missbrauch zu vermeiden wird das Konto nach
        30 Tagen gelöscht.<br/>
        Wenn Sie sich innerhalb der 30 Tage anmelden, wird das Benutzerkonto wieder aktiviert und der Löschprozess wird abgebrochen.
    </p>
    <p>
        Mit freundlichen Grüßen<br/>
        Das {{config('app.name')}}-Team
    </p>
</div>
</body>
</html>
