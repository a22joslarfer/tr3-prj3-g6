# Documentació bàsica del projecte

## Objectius:
L'objectiu del nostre projecte és desenvolupar una aplicació que permeti als usuaris cercar discoteques en el mapa del món sencer. L'aplicació mostrarà punts en el mapa que representen les discoteques i en fer clic a cada punt es mostrarà la informació detallada de la discoteca. A més, l'aplicació comptarà amb característiques com un cercador, inici de sessió i perfils d'usuari, tambe comptara amb una opció de Bereal.

## Arquitectura bàsica
L'arquitectura bàsica de la nostra aplicació es compon de dues parts principals: el backend desenvolupat amb Laravel i el frontend desenvolupat amb Nuxt.js.

### Tecnologies utilitzades:
- Backend: Laravel
- Frontend: Nuxt.js
- Base de dades: MYSQL
- API: Laravel API

### Interrelació entre els diversos components:
El backend s'encarrega de gestionar la lògica del negoci, així com de proporcionar una API RESTful perquè el frontend pugui comunicar-se amb ell. El frontend consumeix aquesta API per mostrar la informació de les discoteques en el mapa i permetre la interacció de l'usuari.

## Com crees l'entorn de desenvolupament
Per configurar l'entorn de desenvolupament, segueix els següents passos:
1. Clona el repositori des de GitHub.
2. Instal·la les dependències del frontend i del backend utilitzant npm o yarn.
3. Configura la connexió a la base de dades en l'arxiu de configuració corresponent.
4. Executa les migracions i seeders per inicialitzar la base de dades amb dades de prova si és necessari.
5. Inicia el servidor backend i el servidor frontend.

## Com desplegues l'aplicació a producció
Per desplegar l'aplicació en producció, segueix aquests passos:
1. Configura l'entorn de producció adequadament, incloent-hi la configuració del servidor web i la base de dades.
2. Compila el frontend utilitzant la comanda `npm run build` en el directori del projecte Nuxt.js.
3. Copia els fitxers compilats del frontend al servidor de producció.
4. Configura el servidor web per servir l'aplicació frontend i configura el proxy invers per al backend si és necessari.
5. Inicia el servidor backend en mode de producció.

## Llistat d'endpoints de l'API de backend

### Rutes:
- GET /api/discotecas: Obté totes les discoteques.
- GET /api/discotecas/{id}: Obté una discoteca per la seva ID.
- POST /api/discotecas: Crea una nova discoteca.
- PUT /api/discotecas/{id}: Actualitza una discoteca existent.
- DELETE /api/discotecas/{id}: Elimina una discoteca existent.

### Exemples de JSON de petició:
- GET http://127.0.0.1:8000/api/discotecas/2
{
  "id": 2,
  "coordenadas": "{\"lat\": 41.381150, \"lng\": 2.191650}",
  "imgUrl": "url2",
  "minEdad": 18,
  "horario": "23:59 - 06:00",
  "nombre_local": "Pacha Barcelona - Barcelona",
  "telefono": "+34 932 25 91 00",
  "descripcion": "Pacha Barcelona, conocida por su ambiente vibrante y sus famosas fiestas temáticas, es un destino imperdible en la vida nocturna de la ciudad."
}

- PUT http://127.0.0.1:8000/api/discotecas/2
{
  "id": 2,
  "coordenadas": "{\"lat\": 41.381150, \"lng\": 2.191650}",
  "imgUrl": "url2",
  "minEdad": 18,
  "horario": "23:59 - 06:00",
  "nombre_local": "opium",
  "telefono": "+34 932 25 91 00",
  "descripcion": "Pacha Barcelona, conocida por su ambiente vibrante y sus famosas fiestas temáticas, es un destino imperdible en la vida nocturna de la ciudad."
}

- DELETE http://127.0.0.1:8000/api/discotecas/2

{
  "id": 2,
  "coordenadas": "{\"lat\": 41.381150, \"lng\": 2.191650}",
  "imgUrl": "url2",
  "minEdad": 18,
  "horario": "23:59 - 06:00",
  "nombre_local": "opium",
  "telefono": "+34 932 25 91 00",
  "descripcion": "Pacha Barcelona, conocida por su ambiente vibrante y sus famosas fiestas temáticas, es un destino imperdible en la vida nocturna de la ciudad."
}
## ENDPOINT DE LARAVEL
### Rutes d'usuari
- `GET /csrf-token`
  - Retorna un token CSRF per a la protecció de formularis.
- `POST /auth`
  - Crida al mètode `auth` del `AuthController` per autenticar l'usuari.
- `GET /user` (middleware `auth:api`)
  - Retorna la informació de l'usuari autenticat.
- `POST /login`
  - Crida al mètode `login` del `userController` per iniciar sessió.
- `POST /register`
  - Crida al mètode `store` del `userController` per registrar un nou usuari.
- `GET /users`
  - Crida al mètode `getUsers` del ``userController`` per obtenir tots els usuaris.
- `GET /users/{id}`
  - Crida al mètode ``getUserById`` del ``userController`` per obtenir un usuari pel seu ID.
- `POST /users`
  - Crida al mètode ``create`` del ``userController`` per crear un nou usuari.
- `DELETE /users/{id}`
  - Crida al mètode ``delete`` del ``userController`` per eliminar un usuari pel seu ID.
- `PUT /users/{id}`
  - Crida al mètode ``update`` del ``userController`` per actualitzar un usuari pel seu ID.`
- `GET /generate-qr-code/{user}`
  - Crida al mètode ``generateQRCode`` del ``UserController`` per generar un codi QR per a un usuari.`
- ``GET /users/profile_photo/{id}``
  - Crida al mètode ``getProfilePhoto`` del ``userController`` per obtenir la foto de perfil d'un usuari pel seu ID.
- ``GET /users/seguidores/{id}``
  - Crida al mètode ``getFollowers`` del ``userController`` per obtenir els seguidors d'un usuari pel seu ID.
- ``PUT /update/users/{id}``
  - Crida al mètode ``updateCrud`` del ``userController`` per actualitzar un usuari pel seu ID.
### Rutes de discoteques
- ``GET /discotecas``
  - Crida al mètode ``getDiscotecas`` del ``discoController`` per obtenir totes les discoteques.
- ``GET /discotecas/{id}``
  - Crida al mètode ``getDiscoteca`` del ``discoController`` per obtenir una discoteca pel seu ID.
- ``POST /discotecas``
  - Crida al mètode ``createDiscoteca`` del ``discoController`` per crear una nova discoteca.
- ``PUT /discotecas/{id}``
  - Crida al mètode ``updateDiscoteca`` del ``discoController`` per actualitzar una discoteca pel seu ID.
- ``DELETE /discotecas/{id}``
  - Crida al mètode ``delete`` del ``discoController`` per eliminar una discoteca pel seu ID.
- ``GET /discotecas/nombre/{nombre_local}``
  - Crida al mètode ``getDiscotecasByName`` del ``discoController`` per obtenir discoteques pel nom.
- ``GET /discotecas/edad/{minEdad}``
  - Crida al mètode ``getDiscotecasByAge`` del ``discoController`` per obtenir discoteques per edat mínima.
- ``GET /discotecas/horario/{horario}``
  - Crida al mètode ``getDiscotecasBySchedule`` del ``discoController`` per obtenir discoteques per horari.
### Rutes de ressenyes
- ``POST /reviews``
  - Crida al mètode ``createReview`` del ``reviewController`` per crear una nova ressenya.
- ``GET /reviews``
  - Crida al mètode ``getReviews`` del ``reviewController`` per obtenir totes les ressenyes.
- ``GET /review/{id}``
  - Crida al mètode ``getReview`` del ``reviewController`` per obtenir una ressenya pel seu ID.
- ``PUT /reviews/{id}``
  - Crida al mètode ``update`` del ``reviewController`` per actualitzar una ressenya pel seu ID.
- ``DELETE /reviews/{id}``
  - Crida al mètode ``delete`` del ``reviewController`` per eliminar una ressenya pel seu ID.
- ``GET /reviews/user/{id}``
  - Crida al mètode ``getReviewsByUser`` del ``reviewController`` per obtenir les ressenyes d'un usuari pel seu ID.
- ``GET /reviews/disco/{id}``
  - Crida al mètode ``getReviewsByDisco`` del ``reviewController`` per obtenir les ressenyes d'una discoteca pel seu ID.
- ``GET /reviews/puntuacion/{puntuacion}``
  - Crida al mètode ``getReviewsByPuntuacion`` del ``reviewController`` per obtenir les ressenyes per puntuació.
### Rutes de categories de ressenyes
- ``GET /categorias_reviews``
  - Crida al mètode ``getCategorias`` del ``categoriasReviewController`` per obtenir totes les categories de ressenyes.
- ``GET /categorias_reviews/{nombre}``
  - Crida al mètode ``getCategoria`` del ``categoriasReviewController`` per obtenir una categoria pel seu nom.
### Rutes de seguidors
- ``GET /seguidores/{id}``
  - Crida al mètode ``getSeguidores`` del ``seguidoresController`` per obtenir tots els seguidors d'un usuari pel seu ID.
- ``GET /amigos/{id}``
  - Crida al mètode ``getAmigos`` del ``seguidoresController`` per obtenir tots els amics d'un usuari pel seu ID.
- ``POST /seguidores``
  - Crida al mètode ``addSeguidor`` del ``seguidoresController`` per afegir un nou seguidor.
- ``GET /seguidores/{seguidor_id}/{seguido_id}``
  - Crida al mètode ``checkIfSeguidor`` del ``seguidoresController`` per comprovar si un usuari segueix a un altre usuari.
### Rutes de BeReal
- ``POST /inTime``
  - Crida al mètode ``createBereal`` del ``BeRealController`` per crear un nou BeReal.
- ``GET /inTime/{id}``
  - Crida al mètode ``show`` del ``BeRealController`` per obtenir i mostrar un BeReal pel seu ID.
- ``GET /inTimes``
  - Crida al mètode ``index`` del ``BeRealController`` per obtenir i mostrar tots els BeReals.
- ``POST /inTime/{id}/commentari``
  - Crida al mètode ``addComentari`` del ``BeRealController`` per crear un nou comentari en un BeReal.
- ``POST /inTime/{id}/commentaris``
  - Crida al mètode ``getComentaris`` del ``BeRealController`` per obtenir tots els comentaris d'un BeReal pel seu ID.
- ``DELETE /inTime/{id}``
  - Crida al mètode ``delete`` del ``BeRealController`` per eliminar un BeReal pel seu ID.
- ``PUT /inTime/{id}``
  - Crida al mètode ``update`` del ``BeRealController`` per actualitzar un BeReal pel seu ID.
### Rutes per a comentaris de BeReal
- ``GET /comentarios/{id_bereal}``
  - Crida al mètode ``index`` del ``comentariosController`` per mostrar tots els comentaris a partir de l'ID del BeReal.
- ``POST /comentarios``
  - Crida al mètode ``store`` del ``comentariosController`` per crear un nou comentari.
-`` GET /comentarios/show/{id}``
  - Crida al mètode ``show`` del ``comentariosController`` per mostrar un comentari específic.
- ``DELETE /comentarios/{id}``
  - Crida al mètode ``destroy`` del ``comentariosController`` per eliminar un comentari pel seu ID.
- ``GET /comentarios``
  - Crida al mètode ``indexComentarios`` del ``comentariosController`` per mostrar tots els comentaris.
- ``PUT /comentarios/{id}``
  - Crida al mètode ``update`` del ``comentariosController`` per actualitzar un comentari pel seu ID.
### Rutes de ciutats
- ``GET /ciudades``
  - Crida al mètode ``index`` del ``CiudadController`` per obtenir totes les ciutats.






















































## DESCRIPCIÓ DOCKER-COMPOSE
### Versio
- versió: 3.8
- s'especifica la versió 3.8 de Docker Compose
### Serveis
#### Laravel
- utilitza la imatge: php:8.3-fpm
- nom del contenidor: `laravel`
- working_dir: /var/www
  - Directori de treball:`/var/wwww`
- volumes:
  - ./backend:/var/www
    - Munta el directori ./backend a /var/www dins del contenidor
- command:
  - bash -c "apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip unzip git libonig-dev libxml2-dev && docker-php-ext-install pdo pdo_mysql gd && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && composer install && php artisan key:generate && php artisan serve --host=0.0.0.0 --port=8000"
    - Actualitza els paquets del sistema, instal·la les dependències necessàries, instal·la extensions PHP, instal·la Composer, instal·la dependències de Composer, genera una clau d'aplicació i serveix l'aplicació Laravel
- ports: 
  - "8000:8000"
    - Mapeja el port 8000 del contenidor al port 8000 de l'amfitrió 
- depends_on:
  - db
    - Depen del servei `db`
### Nuxt-app
- image: node:18-bullseye
  - Utilitza la imatge `node_18-bullseye`
- container_name: nuxt
  - Nom del contenidor: `nuxt`
- working_dir: /app
  - Directori de treball: `/app`
- enviroment
  - CHOKIDAR_USEPOLLING=true
    - Defineix `CHOKIDAR_USEPOLLING=true` per permetre polling en Chokidar (útil per a desenvolupament en Windows o Docker)
- volumes
  - ./frontend:/app
    - Munta el directori `./frontend` a `/app` dins del contenidor
- command: 
  - sh -c "npm install && npm run dev"
    - Installa les dependències de npm i executa el servidor de desenvolupament de Nuxt.js.
- ports:
  - "3000:3000"
    - Mapeja el port 3000 del contenidor al port 3000 de l'amfitrió
### db
- image:mysql:8.0.26
  - Utilitza la imatge `mysql:8.0.26`
- container_name: mysql_db
  - Nom del contenidor: `mysql_db`
- volumes: 
  - db-data2:/var/lib/mysql
    - Utilitza un volum anomenat `db-data2` per persistir les dades a /`var/lib/mysql`
- enviroment:
  - MYSQL_ROOT_PASSWORD: root
    - Defineix la contrasenya de root de MySQL
  - MYSQL_DATABASE: a22hugtrigon_projectofinal
    - Defineix el nom de la base de dades
  - MYSQL_USER: a22hugtrigon_projectofinal
    - Defineix l'usuari de la base de dades
  - MYSQL_PASSWORD: InsPedralbes2022
    - Defineix la contrasenya de l'usuari de la base de dades
- ports: 
  - "3306:3306"
    - Mapeja el port 3306 del contenidor al port 3306 de l'amfitrió

    Aquesta bd nómes l'utilitzem en desenvolupamnet, i en producció no es necesaria, tenia una bd al labs
### phpmyadmin
- image: phpmyadmin/phpmyadmin
  -Utilitza la imatge `phpmyadmin/phpmyadmin`
- container_name: phpmyadmin
  - Nom del contenidor: `phpmyadmin`
- environment:
  - PMA_HOST: db
    - Defineix la configuració de connexió a la base de dades MySQL
  - PMA_PORT: 3306
    - Defineix el port de connexió a la base de dades MySQL
  - PMA_USER: a22hugtrigon_projectofinal
    - Defineix l'usuari de connexió a la base de dades MySQL
  - PMA_PASSWORD: InsPedralbes2022
    - Defineix la contrasenya de l'usuari de la base de dades MySQL
- ports: 
  - "8080:8080"
    - Mapeja el port 80 del contenidor al port 8080 de l'amfitrió
  - depends_on:
    - db
      - Depèn del servei `db`
### Volums
- volumes: 
  - db-data2:
    - Defineix un volum anomenat `db-data2` per emmagatzemar les dades de la base de dades MySQL de manera persistent.¡













