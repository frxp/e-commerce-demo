setup:
	@echo "Setting up the project..."
	@cp .env.example .env
	@cp .env.example .env.testing
	@docker-compose build
	@docker-compose up -d
	@docker-compose exec php-fpm rm -rf vendor composer.lock
	@docker-compose exec php-fpm composer install
	@docker-compose exec php-fpm php artisan key:generate
	@docker-compose exec php-fpm php artisan migrate
	@docker-compose exec php-fpm php artisan db:seed
	@echo "Project is ready to use!"
	@echo "Open http://localhost:8001 to access"

down:
	@docker-compose down
