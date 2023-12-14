# Use the official PHP image as the base image
FROM richarvey/nginx-php-fpm:latest

# Set the working directory in the container
WORKDIR /var/www/html

# Install dependencies
RUN apk --update --no-cache add \
	libzip-dev \
	unzip && \
	docker-php-ext-install zip pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Composer files for better caching
COPY composer.json composer.lock /var/www/html/

# Install application dependencies without dev dependencies
RUN composer install --no-scripts --no-autoloader --no-dev

# Remove unnecessary files
RUN rm -rf /var/www/html/docker-compose.yml /var/www/html/Dockerfile

# Copy the application files to the container
COPY . /var/www/html/

# Generate the Composer autoloader
RUN composer dump-autoload --optimize

# CMD directive is not necessary as richarvey/nginx-php-fpm sets it to run php-fpm

# EXPOSE directive is optional as the default Nginx configuration should already expose port 80

# Cleanup development packages
RUN apk del .build-deps
