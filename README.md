## Objetivo del proyecto

El objetivo de Mi tiempo y mis tomates es crear una plataforma web que permite al usuario utilizar la [técnica de pomodoro](https://es.wikipedia.org/wiki/Técnica_Pomodoro) para aumentar su productividad personal. Se puede dar inicio a cada Pomodoro y la aplicación emite una alarma cuando debe iniciarse el período de descanso. Luego vuelve a emitir una alarma para iniciar otro Pomodoro. Puedo indicar el nombre de una tarea y la cantidad de Pomodoros que estimo me va a llevar completarla. 
Se fortalece la web con una aplicación de escritorio la cual durante el tiempo de ejecución de un Pomodoro registra el tiempo en que una aplicación o un sitio web está en foco para poder analizar luego las razones de mi aumento o disminución de productividad

En definitiva, estas implementaciones quieren acercar al usuario a una experiencia de navegación sencilla y agradable, ofreciéndole características de la tecnica de pomodoro para ayudarlo a administrar el tiempo que utiliza en realizar tareas

## Lista de user stories realizadas

- [x] Registrar usuario
- [x] Iniciar sesión
- [x] Ver tareas
- [x] Crear tarea
- [x] Configurar pomodoros
- [x] Configurar cuenta
- [x] Cerrar sesión
- [x] Iniciar tarea
- [x] Cancelar tarea
- [x] Finalizar tarea
- [x] Pausar y reanudar tarea
- [x] Retomar tarea
- [x] Medir el tiempo de uso de aplicaciones
- [x] Medir el tiempo de uso de sitios web
- [x] Visualizar tiempo de trabajo o descanso
- [x] Eliminar tarea
- [x] Enviar email con estadísticas periodicamente

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

### Composer
```
sudo apt update
sudo apt install curl php-cli php-mbstring git unzip
cd ~
curl -sS https://getcomposer.org/installer -o composer-setup.php
php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

```

### Extensiones necesarias de PHP 7.2 para Symfony 4.1
```
sudo apt-get install php7.2-xml
sudo apt-get install php7.2-curl
sudo apt-get install php7.2-mbstring
sudo apt-get install php7.2-zip
sudo apt-get install php7.2-mysql
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

### MySQL
https://www.digitalocean.com/community/tutorials/how-to-install-mysql-on-ubuntu-18-04
```
sudo apt update
sudo apt install mysql-server
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
php bin/console doctrine:database:create (crea la base de datos, DEBE estar configurado el archivo ".env" para que funcione)
php bin/console doctrine:migrations:migrate (crea las tablas de la base de datos en base a los modelos)
php bin/console doctrine:fixtures:load (carga las tablas con datos mock)
```

## Levantar la aplicaci�n
Posicionarse en la carpeta del proyecto y ejecutar el comando
```
yarn dev --watch (esto crea un proceso para que se actualice el "paquete" de la aplicación de archivos JS y CSS mientras se van cambiando, NO se debe cerrar el proceso)
php -S 127.0.0.1:8000 -t public (para "servir" la aplicación)
```

Luego para acceder a la aplicación
http://localhost:8000


## Levantar la aplicaci�n
Para purgar la base de datos y restaurarla por defecto:
```
yes | ./renewDB.sh
```