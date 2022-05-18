# Strategietools-Backend


![](https://img.shields.io/github/v/release/ricom/toolbox-backend?style=flat-square) ![](https://img.shields.io/github/license/ricom/toolbox-backend?style=flat-square)

Das Projekt Strategietools basiert auf einer Idee aus der Software CRM-Navigator aus dem Jahre 2007. Die Strategietools
sollen jedem einen einfachen Zugang zu strategischen Werkzeugen bieten. Insbesondere ist der Einsatz in der Hochschule
geplant. Aber auch allen Interessierten stehen die Werkzeuge zur Verfügung.

Das Projekt wird an der Jade Hochschule in Wilhelmshaven
am [Fachbereich Management Information Technologie:link:](https://www.jade-hs.de/mit/) entwickelt.

### Werkzeuge

Für den Anfang sind folgende Strategietools geplant:

- Paarweiser Vergleich (CG)
- Nutzwertanalyse (CG)
- Portfolioanalyse (CG)
- SWOT-Analyse (CG)
- ABC-Analyse ([Geist5000](https://github.com/Geist5000))
- Sensitivitätsanalyse (HJP)
- AHP-Analyse (MS/RM)

### Weitere Informationen

[Interne Projektinformationen:link:](https://moodle.jade-hs.de/moodle/course/view.php?id=521&section=4)

## Versionen

- Composer: min Composer 2.0 ([Download:link:](https://getcomposer.org/download/))
- PHP: >= 8.0.2
- Laravel: 9.x
- MySQL: min 5.7.X

## Einrichtung

1. Installiere XAMPP oder einen anderen PHP-Webserver mit
   MySQL: [Download:link:](https://www.apachefriends.org/de/index.html)
2. Installiere Composer >= 2.0: [Download:link:](https://getcomposer.org/download/)

- Bei der Auswahl der PHP Version den Haken bei "Zur PATH variable hinzufügen" setzen

3. Installiere Git: [Download:link:](https://git-scm.com/downloads)

Zum Navigieren in der Kommandozeile können folgende Kommandos verwendet werden:

```shell
cd <Pfad> -- um in den nächsten Ordner zu navigieren: .. eingeben um einen Ordner nach oben zu navigieren
dir -- um den Inhalt des Ordners aufzulisten 
```

Dieses Projekt muss in das web-root Verzeichnis des Webservers geladen werden (bei XAMPP ist das web-root
Verzeichnis `htdocs`):

```shell
git clone https://github.com/ricom/toolbox-backend.git
cd toolbox-backend
```

Die folgenden Kommandos müssen alle in dem von Git erstellten Ordner ausgeführt werden.

Um alle Abhängigkeiten zu installieren, muss folgendes Kommando eingegeben werden:

```shell
composer install
```

Falls Fehler bei diesem Kommando auftreten kann `composer update` eingegeben werden. Anschließend muss die `.env` Datei
erstellt und ausgefüllt werden. In der `.env` Datei werden systemspezifische Konfigurationen festgelegt.   
Zum Erstellen sollte folgendes Kommando eingeben werden:

Windows:

``` shell
copy .env.example .env
```  

Linux:

``` shell
cp .env.example .env
```

Welche Einstellungen in der .env Datei getroffen werden müssen, ist [hier](ENV.md) dokumentiert.   
Anschließend sollte Apache und MySQL von XAMPP aus gestartet werden.  
Nun muss eine Datenbank mit dem Namen `toolbox` erstellt werden. Am leichtesten geht dies
mit [phpmyadmin:link:](http://localhost/phpmyadmin)

Laravel benötigt einen privaten Schlüssel in der `.env` Datei. Dieser kann mit dem folgenden Kommando erstellt werden:

```shell
php artisan key:generate
```

### Datenbanktabellen erstellen

Um die Tabellen zu erstellen, muss folgendes Kommando eingegeben werden:

```shell
php artisan migrate:fresh --seed
```

### Passport

Um für Passport(OAuth2 Bibliothek) die Keys zu erstellen, muss folgendes Kommando eingegeben werden:

```shell
php artisan passport:install
```

### Queue-Worker
(Dieser Schritt kann übersprungen werden, falls die Funktionen eines Queue-Workers nicht benötigt wird)

Für manche Funktionen des Backends (z.B. verschicken von Emails) wird ein Queue-Worker benötigt.
Ein Queue-Worker ist ein Programm, welches unabhängig vom Request und Response Lifecycle des PHP-Servers läuft.

Dadurch kann dieser dafür verwendet werden um Aufgaben zu erledigen, welche keine Response des Servers verzögern.

Ein Queue-Worker muss mit folgendem Kommando gestartet werden:
```shell
php artisan queue:work
```

Dieser läuft solange bis er gestoppt wird. Bei Änderungen im Quellcode oder in der [.env](ENV.md) Datei muss der Queue-Worker neu gestartet werden.

Die Einrichtung ist nun abgeschlossen.  
Zum Testen kann die [Webseite:link:](http://localhost/toolbox-backend/public/) lokal aufgerufen werden.

## Datenbank migrieren

Wenn bereits `php artisan passport:install` ausgeführt wurde und die Datenbank neu migriert
 werden muss, kann das Kommando 
 ```shell
 php artisan migrate:persistClients
 ``` 
 ausgeführt werden. Das Composer Kommando löscht die komplette Datenbank und erstellt sie neue und erstellt einen password Grant Client.

## Anonyme Konten Löschen

Um alte nicht mehr benötigte anoynyme User Konten aus der Datenbank zu entfernen muss das Kommand

```shell
php artisan users:purge
```

Standartmäßig werden alle anonymen Konten gelöscht, bei denen die letzte Aktivität älter als einen Monat ist.
Dieser Zeitraum kann angepasst werden. Im AppServiceProvider kann folgende methode aufgerufen werden:

```php
PurgeAnonymousUsersCommand::userPurgedBefore(Carbon::now()->subWeek());
```

## Dokumentation

Zu diesem Projekt wurde [barryvdh/laravel-ide-helper:link:](https://github.com/barryvdh/laravel-ide-helper) hinzugefügt.
Es wurden beim Erstellen der Model-Klassen die Dokumentation erstellt. Sollten die Model-Klassen bearbeitet werden, kann
die Dokumentation, wie folgt, automatisch aktualisiert werden:

```shell
php artisan ide-helper:models -W
```

[PHP-Doc:link:](https://www.phpdoc.org/) als Werkzeug zur Dokumentation.

## Guidelines für Beteiligte

- Alles was keine Dokumentation oder Kommentare sind, muss in der englischen Sprache angefertigt werden.
- Alle Dokumentationen sollten in der deutschen Sprache angefertigt werden.
- Variablen- und Methodenbezeichnungen werden in Camelcase geschrieben.
- Wenn möglich sollen Dependency Injection für Services verwendet werden.

## Bugs

Wenn ein Fehler gefunden wurde bitte als [Issue](https://github.com/ricom/toolbox-backend/issues) im Github Repository
erstellen.

## Testen

Um einfach testen zu können, kann durch die env variable `EMAIL_FILTER_DISABLED` der E-Mail Filter ausgestellt werden. 

## Lizenz

[GNU GPL 3.0:link:](https://www.gnu.org/licenses/gpl-3.0.de.html)

## Autoren

- [Gesit](https://github.com/Geist5000)
- [Rico Meiner](https://github.com/ricom)
  Weiterhin kann auf die Liste der Projektteilnehmer in Github verwiesen werden.
