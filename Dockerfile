# Use PHP 8.2 base image with Apache
FROM php:8.2-apache

# Enable Apache modules
RUN a2enmod rewrite

# Install required extensions and MySQL client
RUN apt-get update && apt-get install -y \
    sudo \
    nano \
    curl \
    less \
    unzip \
    git \
    default-mysql-client \
    && curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project
COPY . ./
# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Set Laravel public directory as Apache root
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf
# Expose Apache port
EXPOSE 80
