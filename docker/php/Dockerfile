FROM php:8.2-fpm

# Instalar dependencias de sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    curl \
    unzip \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    libpq-dev \
    gnupg2 \
    ca-certificates \
    apt-transport-https \
    unixodbc-dev

# Instalar extensiones necesarias de PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar drivers SQLSRV
RUN curl -sSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor > /etc/apt/keyrings/microsoft.gpg && \
    echo "deb [signed-by=/etc/apt/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" > /etc/apt/sources.list.d/mssql-release.list && \
    apt-get update && ACCEPT_EULA=Y apt-get install -y msodbcsql18 mssql-tools18 && \
    pecl install pdo_sqlsrv && \
    docker-php-ext-enable pdo_sqlsrv

# Configurar zona horaria y otros
RUN echo "America/Lima" > /etc/timezone

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
