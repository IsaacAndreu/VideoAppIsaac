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
      Sprint 4: Implementació del CRUD de Vídeos i Gestió Avançada
      Controladors i Funcions:

# Sprint 4: Implementació del CRUD de Vídeos i Gestió Avançada

## 1. Controladors i Funcions

- **VideosManageController**
    - S'han creat totes les funcions necessàries per al CRUD:
        - `index()`: Mostra la llista de vídeos per a gestió (pàgina protegida).
        - `create()`: Mostra el formulari per crear un nou vídeo.
        - `store()`: Desa el vídeo nou validant els camps (títol, descripció, URL).
        - `edit()`: Mostra el formulari per editar un vídeo existent amb dades pre-omplertes.
        - `update()`: Actualitza el vídeo existent.
        - `destroy()`: Elimina el vídeo de la base de dades.
        - `testedBy()`: Mostra els vídeos testejats per un usuari concret.
- **VideosController@index**
    - S'ha modificat per mostrar tots els vídeos en una pàgina pública amb un format visual similar a la pàgina principal de YouTube.

## 2. Vídeos per Defecte

- **DefaultVideos Helper**
    - S'ha actualitzat el helper per crear **3 vídeos per defecte** amb títol, descripció, URL i data de publicació.
- **DatabaseSeeder**
    - S'ha modificat per cridar `DefaultVideos::crearVideosPerDefecte()` i assegurar que els vídeos es carreguin correctament juntament amb els usuaris i permisos.

## 3. Vistes per al CRUD

- **Vistes Creats:**
    - `resources/views/videos/manage/index.blade.php`: Taula amb la llista de vídeos i opcions per editar i eliminar.
    - `resources/views/videos/manage/create.blade.php`: Formulari per crear un nou vídeo, incloent els atributs `data-qa` en els camps per facilitar els tests.
    - `resources/views/videos/manage/edit.blade.php`: Formulari per editar un vídeo existent, amb dades pre-omplertes.
    - `resources/views/videos/manage/delete.blade.php`: Vista de confirmació d'eliminació del vídeo.
- **Vista Pública:**
    - `resources/views/videos/index.blade.php`: Mostra tots els vídeos en una disposició de graella amb miniatures incrustades, similar a la pàgina principal de YouTube, amb enllaços per veure el detall de cada vídeo.

## 4. Tests i Validació

- **Tests de VideoTest:**
    - `user_without_permissions_can_see_default_videos_page`: Comprova que un usuari sense permisos addicionals pot veure la pàgina pública d’índex de vídeos.
    - `user_with_permissions_can_see_default_videos_page`: Comprova que un usuari amb permisos (video-manager o super-admin) pot veure la pàgina pública.
    - `not_logged_users_can_see_default_videos_page`: Verifica que els convidats (no autenticats) poden accedir a la pàgina pública.
- **Tests de VideosManageControllerTest:**
    - Funcions d'autenticació: `loginAsVideoManager()`, `loginAsSuperAdmin()`, `loginAsRegularUser()`.
    - Comprovació de permisos per gestionar vídeos:
        - Accés a la pàgina de creació, emmagatzematge, edició, actualització i eliminació de vídeos.
        - Verificació que usuaris sense permisos o convidats reben l'error 403 o redirecció adequats.

## 5. Rutes i Middleware

- **Rutes Públiques:**
    - `/videos`: Pàgina d'índex pública, accessible per a tothom.
    - `/videos/{id}` i `/videos/testedBy/{userId}`: Accés protegit per `can:view videos`.
- **Rutes de Gestió (CRUD):**
    - S'organitzen sota el prefix `manage/videos` i només són accessibles per usuaris autenticats amb el permís `manage videos`.
    - Inclouen rutes per mostrar, crear, editar, actualitzar i eliminar vídeos.

## 6. Layout – Navbar i Footer

- **Plantilla Principal:**
    - S'ha creat un layout a `resources/views/layouts/videosapp.blade.php` que inclou un navbar amb enllaços a la pàgina pública d’índex i a la gestió de vídeos (només per usuaris amb permisos).
    - També s'ha afegit un footer amb informació de copyright.
    - Aquesta plantilla facilita la navegació entre les diferents seccions de l'aplicació.

## 7. Documentació i Qualitat del Codi

- **Documentació:**
    - S'ha afegit documentació a `resources/markdown/terms` que descriu les funcionalitats implementades en aquest sprint.
- **Anàlisi Estàtica:**
    - S'ha comprovat la qualitat del codi amb Larastan per assegurar que tot compleix amb les millors pràctiques i no hi ha errors.

## **Sprint 5: Gestió d’Usuaris i Permisos Avançats**

En aquest sprint s’ha completat la funcionalitat CRUD d’usuaris, afegint un nou controlador dedicat, vistes específiques i un sistema de permisos per controlar qui pot gestionar usuaris. També s’han afegit proves unitàries i d’integració per validar el correcte funcionament.

1. **Controladors i Funcions**
    - **UsersController**
        - `index()`: Mostra la llista d’usuaris (restringit a usuaris loguejats).
        - `show($id)`: Detall d’un usuari concret i els seus vídeos.
    - **UsersManageController** (CRUD avançat d’usuaris)
        - `index()`: Mostra la llista d’usuaris per gestionar (requereix el permís `manage users`).
        - `create()`: Formulari per crear un nou usuari.
        - `store()`: Desa un usuari nou validant camps (nom, email, contrasenya).
        - `edit($id)`: Formulari per editar un usuari existent.
        - `update($id)`: Actualitza les dades de l’usuari (nom, email, contrasenya).
        - `delete($id)`: Vista de confirmació d’eliminació.
        - `destroy($id)`: Elimina l’usuari de la base de dades.
        - `testedBy($id)`: (Opcional) Mostra els tests realitzats per un usuari concret.

2. **CRUD d’Usuaris**
    - **Vistes**
        - `users/manage/index.blade.php`: Taula amb la llista d’usuaris i opcions per editar i eliminar.
        - `users/manage/create.blade.php`: Formulari per crear un usuari nou amb camps `data-qa`.
        - `users/manage/edit.blade.php`: Formulari per editar un usuari existent.
        - `users/manage/delete.blade.php`: Vista de confirmació d’eliminació.
        - `users/index.blade.php`: Llista pública (o restringida a usuaris loguejats) amb opció de cerca per nom o email.
        - `users/show.blade.php`: Mostra el detall de l’usuari i els seus vídeos associats.
    - **Permissos**
        - Només usuaris amb `manage users` poden accedir a `/manage/users` (crear, editar, eliminar).
        - Resta d’usuaris pot accedir només a `/users` (índex i detall), segons la configuració.
    - **Rutes i Middleware**
        - El CRUD d’usuaris es defineix sota el prefix `manage/users`, protegit pel middleware `can:manage users`.
        - Les rutes d’índex i show d’usuaris requereixen estar loguejat (`auth:sanctum` + `verified`).

3. **Tests i Validació**
    - **UserTest**
        - `user_without_permissions_can_see_default_users_page`: Verifica que un usuari sense permisos addicionals pot accedir a la llista d’usuaris.
        - `user_with_permissions_can_see_default_users_page`: Comprova que un usuari amb `manage users` també hi pot accedir.
        - `not_logged_users_cannot_see_default_users_page`: Assegura que un convidat no pot veure la llista (o rep redirecció).
        - `user_without_permissions_can_see_user_show_page`: Un usuari sense perms extra pot veure el detall d’un usuari (si així ho configures).
        - `user_with_permissions_can_see_user_show_page`: Un usuari amb `manage users` pot veure el detall.
        - `not_logged_users_cannot_see_user_show_page`: Un convidat rep un 403 o redirecció.
    - **UsersManageControllerTest**
        - Inclou funcions de login per cada rol (`loginAsVideoManager()`, `loginAsSuperAdmin()`, `loginAsRegularUser()`).
        - Proves per verificar que només qui tingui `manage users` pot crear, editar, o eliminar usuaris.
        - Es comprova que els usuaris sense permís obtenen error 403 i els convidats un redirect a `/login`.

4. **Navbar i Navegació**
    - S’ha afegit al layout principal (`videosapp.blade.php`) un enllaç **“Gestionar Usuaris”** només visible per a qui tingui `manage users`.
    - S’han unificat els estils amb Tailwind i les classes utilitzades al dashboard de Jetstream.

5. **Permisos i DatabaseSeeder**
    - El permís `manage users` s’ha afegit (al helper `VideoPermissionsHelper` o a un helper a part) i s’ha assignat al rol `super-admin`.
    - El `DatabaseSeeder` executa aquests helpers per assegurar que el rol `super-admin` i el permís `manage users` quedin sincronitzats.

6. **Conclusió**  
   Amb aquests canvis, el projecte **VideosApp** permet gestionar usuaris de manera totalment integrada, restricció d’accés al CRUD, i visualització pública o privada dels usuaris segons la configuració. Això completa la gestió avançada d’entitats (vídeos i usuaris) i consolida la seguretat via rols i permisos dins de l’aplicació.

