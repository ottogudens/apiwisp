FROM php:8.2-apache

# Instalar dependencias del sistema sin instalar paquetes recomendados (evita mpm_event)
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Desactivar mpm_event y mpm_worker y habilitar solo mpm_prefork y rewrite
RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork rewrite

# Copiar el código de la aplicación al directorio web de Apache
COPY . /var/www/html/

# Permitir sobreescritura .htaccess en Apache
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Asignar permisos adecuados
RUN chown -R www-data:www-data /var/www/html

# Asegurar eliminación de cualquier mpm adicional en runtime, ajustar puerto dinámico $PORT y arrancar Apache
CMD rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.* \
    && sed -i "s/80/${PORT:-80}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf \
    && apache2-foreground
