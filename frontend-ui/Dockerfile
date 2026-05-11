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

# Copy Node.js and npm from official image
COPY --from=node:20 /usr/local/bin/node /usr/local/bin/node
COPY --from=node:20 /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

# Ambil Composer terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur direktori kerja
WORKDIR /var/www

# Salin file proyek
COPY . /var/www

# Instal dependensi proyek
RUN composer install
RUN npm install
RUN npm run build

# Atur izin folder
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 8003
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8003"]
