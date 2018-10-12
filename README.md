## Requerimientos
PHP 7.1+
Composer
Yarn
MySQL
NodeJS

## Instalaci�n para Linux

### PHP 7.2 para Debian/Ubuntu
```
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install -y php7.2
```

### Extensiones necesarias de PHP 7.2 para Symfony 4.1
```
sudo apt-get install php7.2-xml
sudo apt-get install php7.2-curl
sudo apt-get install php7.2-mbstring
sudo apt-get install php7.2-zip
```

## Dependencias de Symfony
Posicionarse en la carpeta del proyecto y ejecutar el comando

```
composer install
```
Instalar YARN
Instalar NodeJS
Instalar MySQL
Configurar usuario y contraseña de MySQL en el archivo ".env"

Adentro del proyecto ejecutar los comandos
yarn install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

## Levantar la aplicaci�n
Posicionarse en la carpeta del proyecto y ejecutar el comando
```
 php -S 127.0.0.1:8000 -t public
 ```

Luego para acceder a la aplicaci�n
http://localhost:8000
