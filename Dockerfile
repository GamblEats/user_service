FROM php:8.0-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Copy API code into container
COPY . /var/www/api

# Set working directory
WORKDIR /var/www/api

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port
EXPOSE 8000

# Run PHP built-in web server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
