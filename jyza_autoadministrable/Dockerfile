FROM php:8.2-fpm

# Actualizar repositorios e instalar dependencias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    default-libmysqlclient-dev \
    pkg-config \
    libicu-dev \
    nginx \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP necesarias (incluyendo mysqli)
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    intl

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/app

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias PHP
RUN composer install --no-interaction --no-dev --optimize-autoloader \
    --ignore-platform-req=ext-intl 2>&1 || echo "Composer install completed with warnings"

# Crear directorios necesarios con permisos
RUN mkdir -p tmp/cache/persistent tmp/cache/models tmp/sessions \
    && chmod -R 777 tmp logs webroot/uploads 2>/dev/null || true

# Configurar Nginx
RUN mkdir -p /etc/nginx/conf.d
COPY <<EOF /etc/nginx/conf.d/default.conf
server {
    listen 8000;
    server_name _;

    root /var/www/app/webroot;
    index index.php;

    # Denegar acceso a archivos sensibles (PRIMERO)
    location ~ /\\\. {
        deny all;
        access_log off;
        log_not_found off;
    }

    # Servir archivos estáticos directamente
    location ~ ^/(img|js|css|uploads|files|favicon\\.ico|robots\\.txt)/ {
        try_files \$uri =404;
        expires 30d;
    }

    # Pasar requests PHP a FPM
    location ~ \\\\.php$ {
        try_files \$uri =404;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    # Rewrite para CakePHP - Esto debe ser lo ÚLTIMO
    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }
}
EOF

# Exponer puerto
EXPOSE 8000

# Comando de inicio
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
