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