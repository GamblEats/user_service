FROM php:8.0-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    libssl-dev \
    pkg-config \
    && rm -rf /var/lib/apt/lists/*

# Install the PHP extension for MongoDB
RUN pecl install mongodb
RUN docker-php-ext-enable mongodb

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
