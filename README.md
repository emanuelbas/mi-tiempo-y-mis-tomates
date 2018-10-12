## Requerimientos
PHP 7.1+
Composer

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

## Levantar la aplicaci�n 
Posicionarse en la carpeta del proyecto y ejecutar el comando
```
 php -S 127.0.0.1:8000 -t public 
 ```
 
Luego para acceder a la aplicaci�n 
http://localhost:8000
