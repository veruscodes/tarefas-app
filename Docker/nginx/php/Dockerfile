FROM php:8.2-fpm AS backend

ARG user=laravel
ARG uid=1000

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    default-mysql-client

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www/html

COPY . .

RUN chown -R $user:$user /var/www/html

USER $user

RUN composer install --no-dev --optimize-autoloader

RUN php artisan key:generate

EXPOSE 9000

CMD ["php-fpm"]

FROM node:18-alpine AS frontend

WORKDIR /app

COPY package*.json ./
COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/

RUN npm install
RUN npm run build

FROM nginx:alpine

RUN rm /etc/nginx/conf.d/default.conf

COPY docker/nginx/tarefas.conf /etc/nginx/conf.d/

COPY --from=backend /var/www/html /var/www/html

COPY --from=frontend /app/public/build /var/www/html/public/build
COPY --from=frontend /app/public/index.html /var/www/html/public/index.html

RUN mkdir -p /var/log/nginx && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/storage

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]