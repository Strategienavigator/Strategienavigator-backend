# Strategietools-Backend
## Projekt
Das Projekt Strategietools basiert auf einer Idee aus der Software CRM-Navigator aus dem Jahre 2007. Die Strategietools sollen jedem einen einfachen Zugang zu strategischen Werkzeugen bieten. Insbesonder ist der Einsatz Hochschule geplant. Aber auch allen Interessierten stehen die Werkzeuge zur Verfügung.

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
[Intere Projektinformationen:link:](https://moodle.jade-hs.de/moodle/course/view.php?id=521&section=4)


## Einrichtung

Composer: 
 - min Composer2
 
PHP:
 - 7.0

Laravel:
 - 8.x 

Um alle Abhängigkeiten zu installieren, muss folgendes Kommando eingegeben werden:
```shell
composer install
```  
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
Es wird davon ausgegangen, dass der User Zugriff auf eine Datenbank mit dem Namen `toolbox` Zugriff hat und diese existiert.
```sql
CREATE DATABASE toolbox;
```

Laravel benötigt einen privaten Schlüssel in der `.env` Datei. Dieser kann mit folgended Kommando erstellt werden: 
```shell
php artisan key:generate
```

### Datenbanktabellen erstellen
Um die Tabellen zum Erstellen muss folgendes Kommando eingegeben werden:
```shell
php artisan migrate --seed
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

Wenn ein Fehler gefunden wurde bitte als [Issue](https://github.com/ricom/toolbox-backend/issues) im Github Repository erstellen.

## Lizenz
[GPL 3.0:link:](https://www.gnu.org/licenses/gpl-3.0.de.html) 

## Autoren
- [Gesit](https://github.com/Geist5000)
- [Rico Meiner](https://github.com/ricom)

Weiterhin kann auf die Liste der Projektteilnehmer in Github verwiesen werden.
