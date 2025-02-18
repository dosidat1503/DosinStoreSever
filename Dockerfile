# Sử dụng PHP 8.2 với Apache
FROM php:8.2-apache

# Cài đặt các dependencies cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    zip \
    curl \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libssl-dev \
    sqlite3 \
    libsqlite3-dev \
    vim

# Cài đặt PHP extensions cần thiết
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cài đặt các dependency của Laravel
WORKDIR /var/www
COPY . .

# Chạy `composer install` để cài đặt Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Thiết lập quyền cho các thư mục cần thiết trong Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Kích hoạt module Apache mod_rewrite (yêu cầu cho Laravel)
RUN a2enmod rewrite

# Copy file cấu hình Apache (nếu cần)
# Nếu bạn có một file cấu hình Apache (vd: laravel.conf), bạn có thể copy nó vào container:
# COPY ./laravel.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80 cho Apache
EXPOSE 80

# Chạy Apache khi container được khởi động
CMD ["apache2-foreground"]
