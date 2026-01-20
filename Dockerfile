FROM dunglas/frankenphp:php8.2-bookworm

# Copiar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar extensiones PHP incluyendo GD
RUN install-php-extensions ctype curl dom fileinfo filter hash mbstring openssl pcre pdo session tokenizer xml pdo_mysql gd

# Configurar directorio de trabajo
WORKDIR /app

# Copiar archivos de la aplicación
COPY . /app

# Instalar dependencias de Composer
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Crear el Caddyfile
RUN echo $'{\n\
    frankenphp\n\
    admin off\n\
}\n\
\n\
:{$PORT:8080}\n\
\n\
root * /app/public\n\
php_server\n\
encode gzip\n\
file_server' > /etc/caddy/Caddyfile

# Exponer puerto
EXPOSE 8080

# Comando de inicio
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
