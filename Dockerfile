FROM php:8.1-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    p7zip-full \
    libicu-dev \
    libssl-dev \
    pkg-config \
    bash \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    &&  mv composer.phar /usr/local/bin/composer

# Install the Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    &&  mv /root/.symfony5/bin/symfony /usr/local/bin

# Install the ZIP extension for PHP
RUN docker-php-ext-install zip

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
