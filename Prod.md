# Production


Um das Projekt in in einer Produktions Umgebung zu verwenden, müssen ein Paar Schritte befolgt werden die im Folgenden Dokument beschrieben werden.

## Composer Install

Anstatt ganz normal `composer install` auszuführen wird in einer Produktions Umgebung wird folgendes Kommando ausgeführt um die Abhängigkeiten zu installieren:

```shell
composer install --optimize-autoloader --no-dev
```

Die extra Argumente sorgen dafür, dass Bedingungen die nur in der Entwicklungsumgebung benötigt werden, nicht installiert und somit auch nicht mitgeladen werden.


## Caching

Laravel kann bestimmte Dinge Cachen um die Antwortzeit zu verkürzen. Die Caches erzeugt man mit folgenden Befehlen:

```shell
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## .env

In der `.env`-Datei muss `APP_ENV` auf `production` und `APP_DEBUG` auf `false` gesetzt werden. 

## frontend einbinden

Um das frontend in das Backend einzubinden, wird der Produktion Build benötigt. Alle Dateien, bis auf die `index.html` müssen in den public Ordner kopiert werden.
Der Inhalt der `index.html` muss in `resources/views/frontend.blade.php` kopiert werden.

In der `routes/web.php` ist eine Fallback Route eingerichtet, welche immer auf das Frontend zeigt.
