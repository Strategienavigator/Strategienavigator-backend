# Strategietools-Backend
## Projekt
Das Projekt Strategietools basiert auf einer Idee aus der Software CRM-Navigator aus dem Jahre 2007. Die Strategietools sollen jedem einen einfachen Zugang zu strategischen Werkzeugen bieten. Insbesonders ist der Einsatz Hochschule geplant. Aber auch allen Interessierten stehen die Werkzeuge zur Verfügung.

Das Projekt wird an der Jade Hochschule in Wilhelmshaven am Fachbereich Management Information Technologie entwickelt.

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
- Composer: min Composer2 ([Download](https://getcomposer.org/download/))
- PHP: 7.0  
- Laravel: 8.x
- MySQL: min 5.7.X  

## Einrichtung

1. Installiere XAMPP oder einen anderen PHP-Webserver mit MySQL: [Download](https://www.apachefriends.org/de/index.html)  
2. Installiere Composer2: [Download](https://getcomposer.org/download/)
 - Bei der Auswahl der PHP version den Haken bei "Zur PATH variable hinzufügen" setzten 
3. Installiere Git: [Download](https://git-scm.com/downloads)

Zum Navigieren in der Kommandozeile können folgende Kommandos verwendet werden:
```shell
cd <Pfad> -- um in den nächsten Ordner zu navigieren: .. eingeben um einen Ordner nach oben zu navigieren
dir -- um den Inhalt des Ordners aufzulisten 
```

Dieses Projekt muss in das web root Verzeichnis des Webservers geladen werden (bei xampp ist das web-root Verzeichnis `htdocs`):
```shell
git clone https://github.com/ricom/toolbox-backend.git
cd toolbox-backend
```

Die folgenden Kommandos müssen alle in dem von git erstellten Ordner ausgeführt werden.

Um alle Abhängigkeiten zu installieren, muss folgendes Kommando eingegeben werden:
```shell
composer install
```
Falls fehler bei diesem Kommando auftreten kann `composer update` eingegeben wird.
Anschließend muss die `.env` Datei erstellt und ausgefüllt werden. Zum Erstellen, folgendes Kommando eingeben:

Windows:
``` shell
copy .env.example .env
```  
Linux:  
``` shell
cp .env.example .env
```

In der `.env` Datei müssen auf jeden Fall die Punkte: `DB_USERNAME, DB_PASSWORD` ausgefüllt werden.  
Anschließend sollte Apache und Mysql von XAMPP aus gestartet werden.  
Nun musst du in der Datenbank die tabelle `toolbox` erstellen. Am leichtesten geht das mit phpmyadmin(`localhost/phpmyadmin`)

Laravel benötigt einen privaten Schlüssel in der `.env` Datei. Dieser kann mit folgenden Kommando erstellt werden: 
```shell
php artisan key:generate
```

Die Einrichtung ist nun abgeschlossen
### Datenbanktabellen erstellen
Um die Tabellen zum Erstellen muss folgendes Kommando eingegeben werden:
```shell
php artisan migrate:fresh --seed
```

### Pasport
Um für Passport die Keys zu erstellen, muss folgendes Kommando eingegeben werden:
```shell
php artisan passport:install
```


## Dokumentation
Zu diesem Projekt wurde [barryvdh/laravel-ide-helper:link:](https://github.com/barryvdh/laravel-ide-helper) hinzugefügt. Es wurden beim Erstellen der Model-Klassen die Dokumentation erstellt. Sollten die Model-Klassen bearbeitet werden, kann die Dokumentation, wie folgt, automatisch aktualisiert werden:
```shell
php artisan ide-helper:models -W
```

[PHP-Doc:link:](https://www.phpdoc.org/) als Werkzeug zur Dokumentation.

## Guidlines für Beteiligte
- Alles was keine Dokumentation oder Kommentare sind, muss in der englischen Sprache angefertigt werden.
- Alle Dokumentationen sollten in der deutschen Sprache angefertigt werden.
- Variablen- und Methodenbezeichnungen werden in Camelcase geschrieben.

## Bugs

Wenn ein Fehler gefunden wurde bitte als [Issue](https://github.com/ricom/toolbox-backend/issues) im Github Repository erstellen.>

## Lizenz
[GPL 3.0:link:](https://www.gnu.org/licenses/gpl-3.0.de.html) 

## Autoren
- [Gesit](https://github.com/Geist5000)
- [Rico Meiner](https://github.com/ricom)
Weiterhin kann auf die Liste der Projektteilnehmer in Github verwiesen werden.
