# Adventskalender
## Aufgabe
Ein Adventskalender als Bild, der anklickbar ist. 
Hinter jedem Türchen versteckt sich eine Datei.
Es soll geprüft werden, ob das Türchen bereits geöffnet werden darf.
Es soll geprüft werden, ob die Datei schon exisitiert, da sie vllt. erst verspätet hinzugefügt wird.
Das Programm soll auf einem Linux-Server mit PHP laufen.

## Vorraussetzungen
* WebServer mit PHP>=7.4
* Editor zum Anpassen der ```bin/config.php```

## Installation
* Repository auf Server ausrollen
* Dateien für Download auf selben Server bereitstellen
* Dateien für WebServer-User lesbar machen
* Dateipfade in ```bin/config.php``` im Array ```ADVENT_FILES``` nach pflegen. Schlüssel ist der jeweilige Tag.
* ausprobieren

## Tests
Es wurden PHPUnit-Tests geschrieben:

```
phpunit tests
```

## Contributes
[![Build Status](https://travis-ci.org/cyper85/adventskalender.svg?branch=main)](https://travis-ci.org/cyper85/adventskalender)

Image by <a href="https://pixabay.com/users/blende12-201217/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=2900406">Gerhard G.</a> from <a href="https://pixabay.com/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=2900406">Pixabay</a>