.PHONY: help build up down logs restart clean shell-admin shell-frontend shell-db

help:
	@echo "🐳 JYZA Docker - Comandos disponibles:"
	@echo ""
	@echo "Gestión de servicios:"
	@echo "  make build              - Construir imágenes"
	@echo "  make up                 - Iniciar servicios"
	@echo "  make down               - Detener servicios"
	@echo "  make restart            - Reiniciar servicios"
	@echo "  make clean              - Limpiar todo (cuidado: borra datos)"
	@echo ""
	@echo "Logs y debugging:"
	@echo "  make logs               - Ver logs de todos los servicios"
	@echo "  make logs-admin         - Ver logs del backend"
	@echo "  make logs-frontend      - Ver logs del frontend"
	@echo "  make logs-db            - Ver logs de la BD"
	@echo ""
	@echo "Acceso a containers:"
	@echo "  make shell-admin        - Entrar en el container de CakePHP"
	@echo "  make shell-frontend     - Entrar en el container de Astro"
	@echo "  make shell-db           - Entrar en MySQL"
	@echo ""
	@echo "URLs:"
	@echo "  Frontend: http://localhost:4321"
	@echo "  Backend:  http://localhost:8000"
	@echo "  PhpMyAdmin: http://localhost:8080"

build:
	docker-compose build

up:
	docker-compose up -d
	@echo "✅ Servicios iniciados"
	@echo "Esperando inicialización..."
	@sleep 10
	@docker-compose ps

down:
	docker-compose down
	@echo "✅ Servicios detenidos"

restart:
	docker-compose restart
	@echo "✅ Servicios reiniciados"

clean:
	docker-compose down -v
	@echo "✅ Todo limpiado"

logs:
	docker-compose logs -f

logs-admin:
	docker-compose logs -f jyza-admin

logs-frontend:
	docker-compose logs -f jyza-frontend-dev

logs-db:
	docker-compose logs -f mysql

shell-admin:
	docker-compose exec jyza-admin bash

shell-frontend:
	docker-compose exec jyza-frontend-dev sh

shell-db:
	docker-compose exec mysql mysql -u jyza_user -pjyza_password -D jyza_autoadministrable

ps:
	docker-compose ps

status:
	@docker-compose ps
	@echo ""
	@echo "Network:"
	@docker network ls | grep jyza

backup-db:
	@mkdir -p backups
	@docker-compose exec -T mysql mysqldump -u jyza_user -pjyza_password jyza_autoadministrable > backups/jyza_$(shell date +%Y%m%d_%H%M%S).sql
	@echo "✅ Backup creado en backups/"

restore-db:
	@if [ -z "$(FILE)" ]; then \
		echo "❌ Uso: make restore-db FILE=backups/jyza_YYYYMMDD_HHMMSS.sql"; \
	else \
		docker-compose exec -T mysql mysql -u jyza_user -pjyza_password jyza_autoadministrable < $(FILE); \
		echo "✅ Base de datos restaurada"; \
	fi
