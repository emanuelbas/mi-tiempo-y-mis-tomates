## Requerimientos
* PHP 7.1+
* Composer
* Yarn
* MySQL
* NodeJS

## Instalaci�n para Debian/Ubuntu/Mint

### PHP 7.2
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

### NodeJS
```
sudo apt install curl
curl -sL https://deb.nodesource.com/setup_8.x | sudo bash -
sudo apt install nodejs
```

### YARN
```
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
sudo apt update
sudo apt install --no-install-recommends yarn
```

## Instalación para Windows

### PHP 7.2
https://windows.php.net/downloads/releases/php-7.2.11-Win32-VC15-x64.zip
### Composer 
https://getcomposer.org/Composer-Setup.exe
### NodeJS
https://nodejs.org/dist/v8.12.0/node-v8.12.0-x86.msi
### YARN
https://yarnpkg.com/latest.msi
### MySQL
https://dev.mysql.com/downloads/installer/

# Instalacion común para Windows/Linux
Configurar usuario y contraseña de MySQL en el archivo ".env"

Posicionarse en la carpeta del proyecto y ejecutar los comandos
```
yarn install
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

## Levantar la aplicaci�n
Posicionarse en la carpeta del proyecto y ejecutar el comando
```
 php -S 127.0.0.1:8000 -t public
 ```

Luego para acceder a la aplicación
http://localhost:8000
