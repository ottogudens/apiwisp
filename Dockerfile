FROM php:8.2-apache

# Instalar dependencias del sistema y extensiones de PHP necesarias (mysqli, gd, pdo_mysql, zip)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Eliminar cualquier simlink de MPM previo y forzar la activación exclusiva de mpm_prefork y rewrite
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load /etc/apache2/mods-enabled/mpm_*.conf \
    && a2enmod mpm_prefork rewrite

# Copiar el código de la aplicación al directorio web de Apache
COPY . /var/www/html/

# Permitir sobreescritura .htaccess en Apache
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Asignar permisos adecuados
RUN chown -R www-data:www-data /var/www/html

# Ajustar Apache al puerto dinámico proporcionado por Railway ($PORT) y arrancar
CMD sed -i "s/80/${PORT:-80}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && apache2-foreground
