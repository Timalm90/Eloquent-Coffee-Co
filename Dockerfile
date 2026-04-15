FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    curl \
    supervisor && \
    rm -rf /var/lib/apt/lists/*

# Configure & install PHP extensions
RUN docker-php-ext-configure gd --with-jpeg --with-freetype && \
    docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy app files
COPY . .

# Install PHP dependencies (at build time)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist && \
    chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Note: Do NOT run php artisan config:cache / route:cache / view:cache at build-time
# since those will bake in environment values. They will be executed by the entrypoint
# at container start so they pick up Render runtime environment variables.

# Nginx config
COPY ./docker/nginx.conf /etc/nginx/conf.d/default.conf

# Supervisor config (runs PHP-FPM + Nginx)
COPY ./docker/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Copy runtime entrypoint
COPY ./docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
