# Strategietools-Backend
## Projekt
Das Projekt Strategietools basiert auf einer Idee aus der Software CRM-Navigator aus dem Jahre 2007. Die Strategietools sollen jedem einen einfachen Zugang zu strategischen Werkzeugen bieten. Insbesonders ist der Einsatz in der Hochschule geplant. Aber auch allen Interessierten stehen die Werkzeuge zur Verfügung.

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
- Composer: min Composer 2.0 ([Download:link:](https://getcomposer.org/download/))
- PHP: 7.0  
- Laravel: 8.x
- MySQL: min 5.7.X  

## Einrichtung

1. Installiere XAMPP oder einen anderen PHP-Webserver mit MySQL: [Download:link:](https://www.apachefriends.org/de/index.html)  
2. Installiere Composer >= 2.0: [Download:link:](https://getcomposer.org/download/)
 - Bei der Auswahl der PHP Version den Haken bei "Zur PATH variable hinzufügen" setzen 
3. Installiere Git: [Download:link:](https://git-scm.com/downloads)

Zum Navigieren in der Kommandozeile können folgende Kommandos verwendet werden:
```shell
cd <Pfad> -- um in den nächsten Ordner zu navigieren: .. eingeben um einen Ordner nach oben zu navigieren
dir -- um den Inhalt des Ordners aufzulisten 
```

Dieses Projekt muss in das web-root Verzeichnis des Webservers geladen werden (bei XAMPP ist das web-root Verzeichnis `htdocs`):
```shell
git clone https://github.com/ricom/toolbox-backend.git
cd toolbox-backend
```

Die folgenden Kommandos müssen alle in dem von Git erstellten Ordner ausgeführt werden.

Um alle Abhängigkeiten zu installieren, muss folgendes Kommando eingegeben werden:
```shell
composer install
```
Falls Fehler bei diesem Kommando auftreten kann `composer update` eingegeben werden.
Anschließend muss die `.env` Datei erstellt und ausgefüllt werden. In der `.env` Datei werden systemspezifische Konfigurationen festgelegt.   
Zum Erstellen sollte folgendes Kommando eingeben werden:

Windows:
``` shell
copy .env.example .env
```  
Linux:  
``` shell
cp .env.example .env
```

In der `.env` Datei müssen auf jeden Fall die Punkte: `DB_USERNAME, DB_PASSWORD` ausgefüllt werden.  
Anschließend sollte Apache und MySQL von XAMPP aus gestartet werden.  
Nun muss in der Datenbank die Tabelle `toolbox` erstellt werden. Am leichtesten geht dies mit [phpmyadmin:link:](http://localhost/phpmyadmin)

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
Die Einrichtung ist nun abgeschlossen.  
Zum Testen kann die [Webseite:link:](http://localhost/toolbox-backend/public/) lokal aufgerufen werden.

## Dokumentation
Zu diesem Projekt wurde [barryvdh/laravel-ide-helper:link:](https://github.com/barryvdh/laravel-ide-helper) hinzugefügt. Es wurden beim Erstellen der Model-Klassen die Dokumentation erstellt. Sollten die Model-Klassen bearbeitet werden, kann die Dokumentation, wie folgt, automatisch aktualisiert werden:
```shell
php artisan ide-helper:models -W
```

[PHP-Doc:link:](https://www.phpdoc.org/) als Werkzeug zur Dokumentation.

## Guidelines für Beteiligte
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
