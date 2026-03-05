FROM php:8.2-cli

# 1. System dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libpng-dev libonig-dev libxml2-dev \
    nodejs npm \
    && docker-php-ext-install \
    pdo_mysql mbstring exif pcntl bcmath gd

# 2. Working directory
WORKDIR /app

# 3. Copy source
COPY . .

# 4. Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 5. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 6. Install frontend dependencies
RUN npm install

# 7. Build Vite
RUN npm run build

# 8. Laravel cache
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# 9. Permissions
RUN chmod -R 775 storage bootstrap/cache || true

# 10. Railway port
EXPOSE 8080

# 11. Start server
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}