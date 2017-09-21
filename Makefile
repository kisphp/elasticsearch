.PONY: i t it

COMPOSER = $(shell which composer)
PHPUNIT = vendor/bin/phpunit
PHPCS = vendor/bin/php-cs-fixer
PHP = $(shell which php)

it: i t

i:
	$(COMPOSER) install -o -a

t:
	$(PHPUNIT) --coverage-clover=coverage.xml
	#$(PHPCS) fix -v
	#vendor/bin/php-cs-fixer fix --dry-run
