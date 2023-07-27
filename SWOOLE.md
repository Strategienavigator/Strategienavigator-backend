# Swoole Setup

Swoole wird mit der Laravel Anwendung über [Octane](https://laravel.com/docs/9.x/octane) verwaltet.

Zuerst muss Swoole über pecl installiert werden (nur linux wird unterstützt):

Der Installer fragt danach welche Features aktiviert werden sollen:

Zu aktivierende Features:
- Keine

```shell
pecl install openswoole
```
Weitere Infos unter: [openswoole.com](https://openswoole.com/docs/get-started/installation).

Danach muss Octane installiert werden: [Laravel Doc](https://laravel.com/docs/9.x/octane).

Sonst wird die Laravel Anwendung wie in der [README](README.md) eingerichtet.
