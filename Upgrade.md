# Upgrade von v0.2.2 zu v0.3.x

Am besten sollte dieser Upgrade Guide vor der Ausführung komplett gelesen werden.

Um das Upgrade durchzuführen, kann **nicht** die automatisierte Pipeline 
im [Strategienavigator/Strategienavigator-cd](https://github.com/Strategienavigator/Strategienavigator-cd) Repository verwendet werden.

Um die CD-Pipeline dennoch aktuell zu halten, ist es Ratsam zunächst eine Datei mit dem Namen `deploy-error` auf dem Server zu erstellen, anschließend alle Änderungen durchzuführen und zuletzt, die CD-Pipeline mit den, auf dem Server ausgecheckten commits laufen zu lassen. Danach sollte die `deploy-error` Datei auf dem Server wieder entfernt werden.

Nachdem die gewünschte Version des Backends ausgecheckt wurde, muss zunächst die Datenbank migriert werden.
```shell
php artisan migrate --force
```
Dieses Kommando wird eine Constraint Violation herbeiführen, welche durch fehlende Einträge in der `roles` Tabelle entsteht.

Diese kann mit dem RoleSeeder behoben werden:
```shell
php artisan db:seed RoleSeeder --force
```

Anschließend muss die `role_id` Spalte aus der `users` Tabelle gelöscht werden, damit die fehlgeschlagene Migration wiederholt werden kann.
Hierzu muss direkt auf die Datenbank zugegriffen werden, zum Beispiel über die Konsole wie folgt:
```shell
mysql -u <username> -p
```
Die Spalte kann wie folgt gelöscht werden:
```sql
ALTER TABLE users drop column role_id;
```
Nun kann die Datenbank wieder migriert werden:
```shell
php artisan migrate --force
```
Das sollte nun ohne Fehler durchlaufen.

Als letzten Schritt müssen den Usern noch die korrekte Rolle zugewiesen werden, weil die Datenbank-Migrationen jedem Nutzer die `user` Rolle zuweist.

Die SQL-Query weißt jedem User der `anonymous` ist, die auch die `Anonymous`-Rolle zu.
Dazu benötigt man wieder direkten Zugriff auf die Datenbank und muss folgende Update SQL-Query ausführen:
```sql
update users set role_id=4 where anonymous = TRUE;
```

Anschließend müssen wieder die Üblichen schritte zum Deployen durchgeführt werden:
```shell
php artisan optimize
php artisan view:cache
```
