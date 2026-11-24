# Sistema de Gestió de Biblioteca Digital (PHP POO)

Pràctica per al mòdul M0613-B2 - PHP orientat a objectes (2n DAW).

Aquest projecte consisteix en el desenvolupament d'un sistema complet de gestió d'una biblioteca desenvolupat en PHP 8 utilitzant programació orientada a objectes, seguint l'estàndard PSR-4 per a l'autoloading amb Composer, persistència en sessió i excepcions personalitzades.

---

## Requisits i Instal·lació

* PHP 8.2 o superior
* Composer

1. Clonar el repositori:
```bash
git clone https://github.com/Nicohrnnz/biblioteca-digital.git
cd biblioteca-digital
```

2. Generar les classes de l'autoloader amb Composer:
```bash
composer install
# o bé:
composer dump-autoload
```

---

## Instruccions d'Execució

Per arrancar el servidor local de desenvolupament:
```bash
php -S localhost:8000
```
Després, obrir el navegador a: http://localhost:8000

---

## Llista d'URLs operatives

* index.php: Pàgina d'inici amb el resum general del sistema i accessos directes.
* index.php?page=materials: Taula amb tots els materials.
* index.php?page=materials&type=llibre: Filtre de llibres (també funciona amb type=revista i type=dvd).
* index.php?page=material&id=X: Fitxa de detall d'un material i el seu historial d'auditoria.
* index.php?page=usuaris: Taula amb el llistat dels usuaris de la biblioteca.
* index.php?page=usuari&id=X: Perfil d'un usuari amb els materials que té prestats.
* index.php?page=usuari&id=X&action=prestecs: Historial de tots els préstecs fets per l'usuari.
* index.php?page=prestec&material_id=X&usuari_id=Y: Funció per realitzar un nou préstec.
* index.php?page=retorn&material_id=X: Retorn d'un material prestat i càlcul de multa si hi ha retard.
* index.php?page=prestecs: Llistat de tots els préstecs actius, marcant els que estan vençuts.
* index.php?page=reserva&material_id=X&usuari_id=Y: Funció per crear una reserva de material.
* index.php?page=reserves: Llistat de totes les reserves actives.
* index.php?page=estadistiques: Panell amb les estadístiques generals calculades.
* index.php?page=auditoria: Llistat de totes les accions registrades pel trait d'auditoria.
* index.php?page=demo_magic: Demostració dels mètodes màgics __toString, __call, __get i __set.
* index.php?page=demo_serialization: Prova de serialize() comprovant que $notificacions no es guarda.
* index.php?page=demo_exceptions: Prova provocant i capturant les 5 excepcions personalitzades.
* index.php?page=demo_autoload: Mostra les classes de App\ carregades per l'autoloader.
* index.php?page=reset: Destrueix la sessió i torna a crear les dades inicials de prova.

---

## Decisions de disseny i millores

* Autoloading PSR-4: S'ha configurat a composer.json associant App\ amb la carpeta src/.
* Millora de reserves sense duplicar codi: Com que la lògica de reservar a Llibre i DVD és la mateixa, hem creat el trait ReservableTrait per no repetir codi a les dues classes filles, complint el principi DRY.
* Mètodes màgics:
  * __call a Biblioteca: permet cridar getLlibres(), getRevistes(), getDVDs(), getMaterials(), getUsuaris() i getNom() sense haver-los de definir un per un.
  * __get i __set a Usuari: controlen l'accés a les propietats privades, permetent només modificar l'email si és vàlid.
  * __sleep i __wakeup a Usuari: per guardar les dades necessàries a la sessió i reiniciar les notificacions en un array buit en despertar l'objecte.
* Gestió d'errors: 5 excepcions pròpies que hereten d'Exception, ordenant els blocs catch del més específic al més general.

---

## Vídeo de demostració

Enllaç al vídeo (YouTube / Google Drive):
[Pendent d'afegir l'enllaç al vídeo de 2 minuts]
