# Use PHP 8.2 base image with Apache
FROM php:8.2-apache

# Enable Apache modules
RUN a2enmod rewrite

# Install required extensions and tools
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    nano \
    less \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Update Apache root to /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 80

# Run Laravel migration + serve app
CMD php artisan config:clear && php artisan migrate --force && apache2-foreground
