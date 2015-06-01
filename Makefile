vendor/autoload.php:
	composer install

sniff: vendor/autoload.php
	vendor/bin/phpcs --standard=PSR2 src -n

test: vendor/autoload.php
	vendor/bin/phpunit


buildfolder:
	mkdir -p build
	mkdir -p build/logs

test-coverage: vendor/autoload.php buildfolder
	vendor/bin/phpunit --coverage-clover build/logs/clover.xml
