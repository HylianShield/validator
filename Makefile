base: composer precommit test

codecoverage:
	@vendor/bin/phpunit -c test/phpunit-coverage.xml

unittest:
	@vendor/bin/phpunit -c test/phpunit.xml

composer:
	@curl -sS https://getcomposer.org/installer | sudo php
	@sudo mv composer.phar /usr/local/bin/composer
	@echo Moved composer.phar to /usr/local/bin/composer.
	@echo composer is now a global tool.

install:
	@composer install

update:
	@composer update

docs:
	@doxygen

precommit:
	@chmod a+x pre-commit
	@cd .git/hooks && rm -f pre-commit && ln -s ../../pre-commit && echo Installed pre-commit hook

test: unittest
