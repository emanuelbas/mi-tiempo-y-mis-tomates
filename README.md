##Requerimientos:
PHP 7.1+

##Instalar PHP 7.2 para Debian/Ubuntu:
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install -y php7.2

##Instalar extensiones necesarias de PHP 7.2 para que funcione Symfony 4.1:
sudo apt-get install php7.2-xml
sudo apt-get install php7.2-curl
sudo apt-get install php7.2-mbstring
sudo apt-get install php7.2-zip

Instalar YARN
Instalar NodeJS
Instalar MySQL
Configurar usuario y contraseña de MySQL en el archivo ".env"

Adentro del proyecto ejecutar los comandos
yarn install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate


