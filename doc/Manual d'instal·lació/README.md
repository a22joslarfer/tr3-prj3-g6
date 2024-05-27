# Manual d'instal·lació per al docker-compose.yml

Aquest manual descriu els passos necessaris per configurar i executar un entorn de desenvolupament amb Laravel, MySQL, Nuxt.js i phpMyAdmin utilitzant Docker Compose.

## Requisits previs
Assegura't de tenir instal·lats els següents programes al teu sistema:
- Docker
- Docker Compose

## Fitxer docker-compose.yml
Lo que se realiza en el docker compose , es  crear las imagenes de cada tecnologia que aplicamos en este caso nuxt, laravel, node, php. en la imagen de laravel nos automatizamos ya lo que hariamos nosotros manualmente desde el terminal, como puede ser compose install, php artisan migrate, php aritan key y por supueto el php artisan serve para abrir el puerto.  Para levantar estas imagenes deberemos hacer compose up, en caso de que queramos actualizar haremos compose restart y en caso de querer apagar el servicio haremos compose down

**version**: '3.8'

**services**:  
  **laravel**-app:  
    **image**: php:8.3-fpm  
    **container_name**: laravel  
    **working_dir**: /var/www  
    **volumes**:  
      - ./backend:/var/www  
    **command**: >  
      bash -c "apt-get update && apt-get install -y   libpng-dev libjpeg-dev libfreetype6-dev zip unzip git   
      libonig-dev libxml2-dev && docker-php-ext-install pdo pdo_mysql gd  
      && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer  
      && composer install  
      && php artisan key:generate  
      && php artisan serve --host=0.0.0.0 --port=8000"  
    **ports**:  
      - "8000:8000"  
    **depends_on**:  
      - db  

  **nuxt**-app:    
    **image**: node:18-bullseye  
    **container_name**: nuxt  
    **working_dir**: /app  
    **environment**:  
      - CHOKIDAR_USEPOLLING=true  
    **volumes**:  
      - ./frontend:/app  
    **command**: sh -c "npm install && npm run dev"  
    **ports**:  
      - "3000:3000"  

  **db**:  
    **image**: mysql:8.0.26  
    **container_name**: mysql_db  
    **volumes**:  
      - db-data2:/var/lib/mysql  
    **environment**:  
      MYSQL_ROOT_PASSWORD: root  
      MYSQL_DATABASE: a22hugtrigon_projectofinal  
      MYSQL_USER: a22hugtrigon_projectofinal  
      MYSQL_PASSWORD: InsPedralbes2022  
    **ports**:  
      - "3306:3306"  

  **phpmyadmin**:  
    **image**: phpmyadmin/phpmyadmin  
    **container_name**: phpmyadmin  
    **environment**:  
      PMA_HOST: db  
      PMA_PORT: 3306  
      PMA_USER: a22hugtrigon_projectofinal  
      PMA_PASSWORD: InsPedralbes2022
    **ports**:  
      - "8080:80"  
    **depends_on**:  
      - db  

**volumes:**  
  db-data2:  
