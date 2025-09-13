# Usamos la imagen base de Ubuntu que pediste
FROM ubuntu:22.04

# Evitar preguntas interactivas durante la instalación
ARG DEBIAN_FRONTEND=noninteractive

# Instalar dependencias básicas y el PPA de PHP
RUN apt-get update && apt-get install -y \
    software-properties-common curl zip unzip git && \
    add-apt-repository ppa:ondrej/php -y && \
    apt-get update

# Instalar Nginx, Supervisor, y PHP 8.3 con sus extensiones comunes
RUN apt-get install -y nginx supervisor php8.3-fpm php8.3-mysql \
    php8.3-mbstring php8.3-xml php8.3-curl php8.3-bcmath

# Instalar Composer (gestor de dependencias de PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurar Nginx para que funcione con Laravel
COPY default.conf /etc/nginx/sites-available/default
RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log

# Configurar Supervisor para que gestione Nginx y PHP-FPM
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Crear el directorio para el socket de PHP-FPM y darle permisos
RUN mkdir -p /run/php && chown -R www-data:www-data /run/php

# Exponer el puerto 80 del contenedor
EXPOSE 80

# Comando que se ejecutará al iniciar el contenedor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]