FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Install system dependencies and MySQL client
RUN apt-get update && \
    apt-get install -y \
        default-mysql-client \
        git \
        unzip \
        zip \
        curl && \
    docker-php-ext-install pdo pdo_mysql

# Copy Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Expose port for PHP built-in server
EXPOSE 8000

# Start PHP built-in web server using the "public" folder as document root
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
