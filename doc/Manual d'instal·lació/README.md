# Manual d'instal·lació 

Aquest manual descriu els passos necessaris per configurar i executar un entorn de desenvolupament amb Laravel, MySQL, Nuxt.js i phpMyAdmin utilitzant Docker Compose.

## Requisits previs
Assegura't de tenir instal·lats els següents programes al teu sistema:
- Docker
- Docker Compose

## Fitxer docker-compose.yml
El que es realitza en el Docker Compose és crear les imatges de cada tecnologia que apliquem, en aquest cas: Nuxt, Laravel, Node i PHP. A la imatge de Laravel automatitzem tot allò que faríem manualment des del terminal, com ara composer install, php artisan migrate, php artisan key:generate i, per descomptat, php artisan serve per obrir el port. Per aixecar aquestes imatges haurem de fer compose up. En cas que vulguem actualitzar, farem compose restart i, si volem apagar el servei, farem compose down.

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
