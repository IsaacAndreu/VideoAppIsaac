# Guia del projecte VideosApp

## Descripció del projecte
VideosApp és una aplicació desenvolupada per gestionar i visualitzar vídeos de manera estructurada. El projecte utilitza el framework Laravel per crear una aplicació web amb funcionalitats com:

- Gestió d'usuaris i equips.
- Visualització i organització de vídeos amb camps com títol, descripció, URL, i enllaços a vídeos relacionats.
- Formatació avançada de dates utilitzant la llibreria Carbon.
- Integració amb bases de dades SQLite per a l'emmagatzematge de dades.

## Sprint 1: Configuració inicial i estructuració
Durant el primer sprint es va treballar en la configuració bàsica del projecte i la implementació de les següents funcionalitats:

1. **Configuració del projecte Laravel:**
    - Inicialització del projecte amb Laravel Jetstream i autenticació amb equips.
    - Configuració del fitxer `.env` per gestionar les credencials i configuracions del sistema.

2. **Modelatge de dades:**
    - Creació de models com `User`, `Team`, i `Video` amb les seves respectives migracions.
    - Definició de relacions entre models (com la relació entre vídeos i equips).

3. **Helpers i tests:**
    - Implementació de helpers per crear usuaris i vídeos per defecte.
    - Creació de tests per verificar la creació d'usuaris i associacions a equips.

4. **Rutes i controladors:**
    - Implementació de les rutes per mostrar vídeos específics i vídeos testejats per un usuari.
    - Creació del controlador `VideosController` amb les funcions `show` i `testedBy`.

## Sprint 2: Millores i funcionalitats avançades
En el segon sprint, el focus va ser millorar la funcionalitat i afegir components visuals i documentació:

1. **Formatació de dates:**
    - Implementació de mètodes al model `Video` per retornar les dates en diferents formats: llegibles, humanitzats i com a timestamps.
    - Tests unitaris per verificar la formatació correcta de les dates utilitzant Carbon.

2. **Vistes Blade:**
    - Creació de la vista `show` per a vídeos, utilitzant el layout personalitzat `VideosAppLayout`.
    - Integració d'informació com títol, descripció, i enllaços als vídeos relacionats.

3. **Documentació:**
    - Creació d'un layout Markdown per a termes i condicions que inclou una guia completa del projecte.
    - Descripció detallada de les funcionalitats implementades en cada sprint.

4. **Proves i depuració:**
    - Correcció d'errors en la configuració de dates i relacions.
    - Execució de tests per assegurar que totes les funcionalitats treballen com s'esperava.

## **Sprint 3: Implementació de permisos i seguretat**
En aquest sprint s’ha implementat un sistema de permisos i rols per gestionar correctament l’accés a les funcionalitats de l’aplicació.

1. **Gestió de permisos i rols:**
    - Instal·lació i configuració del paquet `spatie/laravel-permission`.
    - Creació dels rols `super-admin`, `regular-user` i `video-manager` amb permisos específics.

2. **Modificacions al sistema d'usuaris:**
    - Assignació de rols als usuaris per defecte al `DatabaseSeeder`.
    - Implementació de la funció `isSuperAdmin()` al model `User`.

3. **Proves i validació:**
    - Creació del test `VideosManageControllerTest` per comprovar l’accés segons permisos.
    - Execució de `php artisan test` per validar el sistema de seguretat.

4. **Depuració i optimització:**
    - Correcció d’errors en la gestió de permisos i accés a vídeos.
    - Neteja de memòria cau i configuracions per evitar conflictes en els tests.
Gràcies per consultar aquesta guia! Si tens qualsevol dubte, no dubtis a preguntar. 😊
