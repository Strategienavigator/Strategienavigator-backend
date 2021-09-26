<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kein Frontend vorhanden</title>
</head>
<body>

<header><h1>Kein Frontend verfügbar.</h1></header>

<main>
    <p>
        <strong>Ups... da ist dem Admin wohl ein Fehler unterlaufen. Bitte kontaktiere <a
                href="mailto:{{config("mail.from.address")}}?subject=Fehlendes%20Frontend&body=Sehr%20geehrtes%20Strategienavigator-Team,%0A%0Aich%20muss%20ihnen%20leider%20mitteilen,%20dass%20sie%20auf%20Ihrer%20Website%20kein%20Frontend%20hochgeladen%20haben.%0A%0AMit%20freundlichen%20Gr%C3%BC%C3%9Fen%0A%0Aein%20Besucher">{{config("mail.from.address")}}</a>
            damit der Fehler möglichst schnell behoben wird.</strong>
    </p>

    <p>
        Danke für die Hilfe!
    </p>
</main>

</body>
</html>
