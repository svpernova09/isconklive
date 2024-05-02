.PHONY: clean
clean:
	rm -rf vendor/
	rm -rf node_modules/

.PHONY: clean
clean:
	rm -rf vendor/
	rm -rf node_modules/

.PHONY: clean_db
clean_db:
	php artisan migrate:fresh
	php artisan db:seed

.PHONY: test
test:
	php vendor/bin/phpunit

.PHONY: deploy
deploy:
	php vendor/bin/envoy run deploy

.PHONY: cicd-setup
cicd-setup:
	composer install
	php artisan key:generate --ansi
	php artisan migrate --force
	php artisan db:seed --force
