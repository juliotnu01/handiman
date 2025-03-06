# Usamos una imagen base de PHP 8.2 con Apache
FROM php:8.2-apache

# Instalamos dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalamos la extensión de Redis para PHP
RUN pecl install redis \
    && docker-php-ext-enable redis

# Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalamos Node.js para manejar Vue.js y Tailwind
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Configuramos el directorio de trabajo
WORKDIR /var/www/html

# Copiamos los archivos de la aplicación EXCEPTO node_modules
COPY . .

# Instalamos las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Instalamos las dependencias de Node.js DENTRO DEL CONTENEDOR
RUN npm install && npm run build

# Habilitamos el módulo rewrite de Apache
RUN a2enmod rewrite

# Configuramos Apache para apuntar al directorio público de Laravel
COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Reiniciamos Apache
RUN service apache2 restart

