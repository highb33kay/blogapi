# Use the official PHP image as the base image
FROM richarvey/nginx-php-fpm:latest

# Set the working directory in the container
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
	libzip-dev \
	unzip \
	&& docker-php-ext-install zip pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Composer files for better caching
COPY composer.json composer.lock /var/www/html/

# Install application dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the application files to the container
COPY . /var/www/html/

# Generate the Composer autoloader
RUN composer dump-autoload --optimize

# Expose port 9000 and start PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
