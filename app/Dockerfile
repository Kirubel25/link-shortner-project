# Use official PHP 8.2 image with FPM (FastCGI Process Manager)
FROM php:8.2-fpm

# Install required dependencies and PHP extensions (e.g., git, unzip, PDO, MySQL)
RUN apt-get update && apt-get install -y \
    sudo \
    nano \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Install Composer (Dependency manager for PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory inside the container
WORKDIR /var/www/html

# Copy all project files into the container
COPY . .

# Install Laravel dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Expose port 9000 (default PHP-FPM port)
EXPOSE 9000

# Command to run PHP-FPM when container starts
CMD ["php-fpm"]
