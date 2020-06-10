FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
COPY . /var/www
WORKDIR /var/www
COPY docker-compose/php/php.ini /usr/local/etc/php/conf.d/99-overrides.ini

# Install NodeJS
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs

RUN chown $user:$user /var/www/.env
RUN chown -R $user:$user /var/www/
#RUN chown -R $user:$user /var/www/storage/
#RUN chown -R $user:$user /var/www/bootstrap/

USER $user

RUN composer install
RUN npm install
RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan key:generate
