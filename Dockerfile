# Dockerfile simplificado para Laravel OOP + Supabase - Render.com
FROM php:8.3-fpm-alpine

# Instalar dependencias del sistema
RUN apk add --no-cache \
    nginx \
    curl \
    zip \
    unzip \
    git \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    icu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql \
        gd \
        mbstring \
        xml \
        intl \
        opcache \
        bcmath

# Configurar OPcache para producción
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=4000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.revalidate_freq=2" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.fast_shutdown=1" >> /usr/local/etc/php/conf.d/opcache.ini

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Crear usuario para Laravel
RUN addgroup -g 1000 -S laravel \
    && adduser -u 1000 -S laravel -G laravel

# Configurar Nginx inline
RUN echo 'user laravel;' > /etc/nginx/nginx.conf \
    && echo 'worker_processes auto;' >> /etc/nginx/nginx.conf \
    && echo 'pid /run/nginx.pid;' >> /etc/nginx/nginx.conf \
    && echo 'events { worker_connections 1024; }' >> /etc/nginx/nginx.conf \
    && echo 'http {' >> /etc/nginx/nginx.conf \
    && echo '    include /etc/nginx/mime.types;' >> /etc/nginx/nginx.conf \
    && echo '    default_type application/octet-stream;' >> /etc/nginx/nginx.conf \
    && echo '    sendfile on;' >> /etc/nginx/nginx.conf \
    && echo '    keepalive_timeout 65;' >> /etc/nginx/nginx.conf \
    && echo '    gzip on;' >> /etc/nginx/nginx.conf \
    && echo '    server {' >> /etc/nginx/nginx.conf \
    && echo '        listen 80;' >> /etc/nginx/nginx.conf \
    && echo '        root /var/www/html/public;' >> /etc/nginx/nginx.conf \
    && echo '        index index.php index.html;' >> /etc/nginx/nginx.conf \
    && echo '        location / { try_files $uri $uri/ /index.php?$query_string; }' >> /etc/nginx/nginx.conf \
    && echo '        location ~ \.php$ {' >> /etc/nginx/nginx.conf \
    && echo '            fastcgi_pass 127.0.0.1:9000;' >> /etc/nginx/nginx.conf \
    && echo '            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;' >> /etc/nginx/nginx.conf \
    && echo '            include fastcgi_params;' >> /etc/nginx/nginx.conf \
    && echo '            fastcgi_read_timeout 300;' >> /etc/nginx/nginx.conf \
    && echo '            fastcgi_send_timeout 300;' >> /etc/nginx/nginx.conf \
    && echo '        }' >> /etc/nginx/nginx.conf \
    && echo '        location /health { return 200 "OK"; add_header Content-Type text/plain; }' >> /etc/nginx/nginx.conf \
    && echo '        location /docs { alias /var/www/html/storage/api-docs; try_files $uri $uri/ =404; }' >> /etc/nginx/nginx.conf \
    && echo '        location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ { expires 1y; add_header Cache-Control "public, immutable"; }' >> /etc/nginx/nginx.conf \
    && echo '        location = / { return 301 /swagger/; }' >> /etc/nginx/nginx.conf \
    && echo '        location = /api/documentation { return 301 /swagger/; }' >> /etc/nginx/nginx.conf \
    && echo '    }' >> /etc/nginx/nginx.conf \
    && echo '}' >> /etc/nginx/nginx.conf

# Configurar directorios
WORKDIR /var/www/html
RUN chown -R laravel:laravel /var/www/html

# Copiar código fuente
COPY --chown=laravel:laravel . /var/www/html

# Cambiar a usuario laravel
USER laravel

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Cambiar de vuelta a root
USER root

# Crear directorios necesarios y configurar permisos correctos
RUN mkdir -p /run/nginx \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/app \
    && chmod -R 777 /var/www/html/storage \
    && chmod -R 777 /var/www/html/bootstrap/cache \
    && chown -R laravel:laravel /var/www/html/storage \
    && chown -R laravel:laravel /var/www/html/bootstrap/cache

# Variables de entorno por defecto
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV APP_NAME="Laravel OOP Supabase"
ENV APP_URL="https://poo-yrit.onrender.com"
ENV LOG_CHANNEL=stderr
ENV SESSION_DRIVER=file
ENV CACHE_STORE=file
ENV QUEUE_CONNECTION=sync
ENV L5_SWAGGER_GENERATE_ALWAYS=true

# Exponer puerto
EXPOSE 80

# Script de inicio mejorado inline
RUN echo '#!/bin/sh' > /start.sh \
    && echo 'set -e' >> /start.sh \
    && echo 'echo "🚀 Iniciando Laravel OOP + Supabase..."' >> /start.sh \
    && echo 'cd /var/www/html' >> /start.sh \
    && echo '# Configurar permisos correctos' >> /start.sh \
    && echo 'chown -R laravel:laravel /var/www/html/storage' >> /start.sh \
    && echo 'chown -R laravel:laravel /var/www/html/bootstrap/cache' >> /start.sh \
    && echo 'chmod -R 777 /var/www/html/storage' >> /start.sh \
    && echo 'chmod -R 777 /var/www/html/bootstrap/cache' >> /start.sh \
    && echo '# Configurar variables de entorno básicas' >> /start.sh \
    && echo 'export APP_NAME="Laravel OOP Supabase"' >> /start.sh \
    && echo 'export APP_URL="https://poo-yrit.onrender.com"' >> /start.sh \
    && echo '# Generar APP_KEY si no existe' >> /start.sh \
    && echo 'if [ -z "$APP_KEY" ]; then php artisan key:generate --force; fi' >> /start.sh \
    && echo '# Limpiar caches' >> /start.sh \
    && echo 'php artisan config:clear || echo "Config clear failed"' >> /start.sh \
    && echo 'php artisan cache:clear || echo "Cache clear failed"' >> /start.sh \
    && echo 'php artisan view:clear || echo "View clear failed"' >> /start.sh \
    && echo '# Publicar y generar documentación Swagger' >> /start.sh \
    && echo 'echo "📚 Publicando assets de Swagger..."' >> /start.sh \
    && echo 'php artisan vendor:publish --provider="L5Swagger\\L5SwaggerServiceProvider" --force || echo "Swagger publish failed"' >> /start.sh \
    && echo '# Crear Swagger UI standalone personalizado' >> /start.sh \
    && echo 'mkdir -p /var/www/html/public/swagger' >> /start.sh \
    && echo 'cat > /var/www/html/public/swagger/index.html << "EOF"' >> /start.sh \
    && echo '<!DOCTYPE html>' >> /start.sh \
    && echo '<html><head><title>Laravel OOP Demo API</title>' >> /start.sh \
    && echo '<link rel="stylesheet" type="text/css" href="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui.css" />' >> /start.sh \
    && echo '</head><body><div id="swagger-ui"></div>' >> /start.sh \
    && echo '<script src="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui-bundle.js"></script>' >> /start.sh \
    && echo '<script src="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui-standalone-preset.js"></script>' >> /start.sh \
    && echo '<script>SwaggerUIBundle({url: "/docs/api-docs.json", dom_id: "#swagger-ui", presets: [SwaggerUIBundle.presets.apis, SwaggerUIStandalonePreset], layout: "StandaloneLayout"});</script>' >> /start.sh \
    && echo '</body></html>' >> /start.sh \
    && echo 'EOF' >> /start.sh \
    && echo 'echo "🎨 Swagger UI standalone creado..."' >> /start.sh \
    && echo 'echo "📚 Generando documentación Swagger..."' >> /start.sh \
    && echo 'php artisan l5-swagger:generate --all || echo "Swagger generation failed"' >> /start.sh \
    && echo 'ls -la /var/www/html/storage/api-docs/ || echo "No api-docs directory"' >> /start.sh \
    && echo 'ls -la /var/www/html/resources/views/vendor/l5-swagger/ || echo "No swagger views"' >> /start.sh \
    && echo 'echo "✅ Laravel configurado correctamente"' >> /start.sh \
    && echo '# Iniciar servicios' >> /start.sh \
    && echo 'echo "🔧 Iniciando PHP-FPM..."' >> /start.sh \
    && echo 'php-fpm -D' >> /start.sh \
    && echo 'echo "🌐 Iniciando Nginx..."' >> /start.sh \
    && echo 'nginx -g "daemon off;"' >> /start.sh \
    && chmod +x /start.sh

# Comando de inicio
CMD ["/start.sh"]
