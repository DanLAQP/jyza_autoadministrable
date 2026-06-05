#!/bin/bash

echo "🚀 Iniciando JYZA en Docker..."

# Verificar si Docker está instalado
if ! command -v docker &> /dev/null; then
    echo "❌ Docker no está instalado. Por favor instala Docker Desktop."
    exit 1
fi

# Verificar si docker-compose está disponible
if ! command -v docker-compose &> /dev/null; then
    echo "❌ docker-compose no está instalado."
    exit 1
fi

echo "📦 Construyendo imágenes..."
docker-compose build

echo "🔄 Iniciando servicios..."
docker-compose up -d

echo "⏳ Esperando a que MySQL esté listo..."
sleep 10

echo "✅ Servicios iniciados correctamente!"
echo ""
echo "🌐 Accesos disponibles:"
echo "   • Frontend (Astro):     http://localhost:4321"
echo "   • Backend (CakePHP):    http://localhost:8000"
echo "   • PhpMyAdmin:           http://localhost:8080"
echo ""
echo "📊 Variables de acceso a BD:"
echo "   • Host:     localhost"
echo "   • Usuario:  jyza_user"
echo "   • Password: jyza_password"
echo "   • Base de datos: jyza_autoadministrable"
echo ""
echo "🛑 Para detener los servicios: docker-compose down"
echo "📋 Para ver logs: docker-compose logs -f"
