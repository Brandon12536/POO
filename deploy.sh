#!/bin/bash

# Script de despliegue para Laravel OOP + Supabase
# Uso: ./deploy.sh [production|staging]

set -e

ENVIRONMENT=${1:-production}
IMAGE_NAME="laravel-oop-supabase"
CONTAINER_NAME="laravel-oop-app"

echo "🚀 Iniciando despliegue para entorno: $ENVIRONMENT"

# Verificar que Docker esté corriendo
if ! docker info > /dev/null 2>&1; then
    echo "❌ Error: Docker no está corriendo"
    exit 1
fi

# Verificar variables de entorno
if [ ! -f ".env" ]; then
    echo "❌ Error: Archivo .env no encontrado"
    echo "💡 Copia .env.example a .env y configura las variables"
    exit 1
fi

# Construir imagen Docker
echo "🔨 Construyendo imagen Docker..."
docker build -t $IMAGE_NAME:latest .

# Detener contenedor existente si existe
if docker ps -q -f name=$CONTAINER_NAME > /dev/null; then
    echo "🛑 Deteniendo contenedor existente..."
    docker stop $CONTAINER_NAME
    docker rm $CONTAINER_NAME
fi

# Ejecutar nuevo contenedor
echo "🚀 Iniciando nuevo contenedor..."
docker run -d \
    --name $CONTAINER_NAME \
    --restart unless-stopped \
    -p 80:80 \
    --env-file .env \
    $IMAGE_NAME:latest

# Verificar que el contenedor esté corriendo
sleep 10
if docker ps -q -f name=$CONTAINER_NAME > /dev/null; then
    echo "✅ Contenedor iniciado exitosamente"
    
    # Verificar que la aplicación responda
    if curl -f http://localhost/health > /dev/null 2>&1; then
        echo "✅ Aplicación respondiendo correctamente"
        echo "🌐 Swagger UI disponible en: http://localhost"
        echo "📚 API disponible en: http://localhost/api/employees"
    else
        echo "⚠️  Advertencia: La aplicación no responde en /health"
        echo "📋 Verificar logs: docker logs $CONTAINER_NAME"
    fi
else
    echo "❌ Error: El contenedor no se inició correctamente"
    echo "📋 Verificar logs: docker logs $CONTAINER_NAME"
    exit 1
fi

# Mostrar información útil
echo ""
echo "📊 Estado del despliegue:"
echo "🐳 Imagen: $IMAGE_NAME:latest"
echo "📦 Contenedor: $CONTAINER_NAME"
echo "🌐 URL: http://localhost"
echo "📚 Swagger: http://localhost/api/documentation"
echo ""
echo "🔧 Comandos útiles:"
echo "  Ver logs:     docker logs $CONTAINER_NAME"
echo "  Entrar al contenedor: docker exec -it $CONTAINER_NAME sh"
echo "  Detener:      docker stop $CONTAINER_NAME"
echo "  Reiniciar:    docker restart $CONTAINER_NAME"
echo ""
echo "✅ Despliegue completado exitosamente!"
