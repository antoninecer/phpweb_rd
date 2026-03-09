FROM php:8.3-fpm

# Instalace systémových balíčků
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libicu-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip intl gd mbstring exif pcntl bcmath opcache

# Instalace Composeru
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Nastavení pracovního adresáře
WORKDIR /var/www

# Kopírování souborů Laravelu
COPY . /var/www

# Nastavení práv
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Startovací příkaz
CMD ["php-fpm"]

