FROM php:8.2-cli

# 1. System dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install \
    pdo_mysql mbstring exif pcntl bcmath gd

# 2. Node.js (Node 20)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 3. Working directory
WORKDIR /app

# 4. Copy source
COPY . .

# 5. Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 6. Frontend build
RUN rm -rf node_modules package-lock.json
RUN npm install
RUN npm run build

# 7. Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 8. Railway PORT
EXPOSE 8080

# 9. Start command
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]