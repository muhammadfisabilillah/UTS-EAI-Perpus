# Gunakan image PHP resmi dengan ekstensi yang diperlukan
FROM php:8.4-fpm

# Instal dependensi sistem
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Bersihkan cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instal ekstensi PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Ambil Composer terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur direktori kerja
WORKDIR /var/www

# Salin file proyek
COPY . /var/www

# Instal dependensi proyek
RUN composer install

# Atur izin folder
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 8001
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8001"]
