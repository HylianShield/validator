PHPCMD=php -d suhosin.executor.include.whitelist=phar

base: composer precommit test

codecoverage:
	@vendor/bin/phpunit -c test/phpunit-coverage.xml

unittest:
	@vendor/bin/phpunit -c test/phpunit.xml

test: unittest

composer:
	@curl -sS https://getcomposer.org/installer | $(PHPCMD)

production:
	@$(PHPCMD) ./composer.phar self-update
	@$(PHPCMD) ./composer.phar install --no-dev --optimize-autoloader

update-production:
	@$(PHPCMD) ./composer.phar self-update
	@$(PHPCMD) ./composer.phar update --no-dev --optimize-autoloader

development:
	@$(PHPCMD) ./composer.phar self-update
	@$(PHPCMD) ./composer.phar install --dev

update-development:
	@$(PHPCMD) ./composer.phar self-update
	@$(PHPCMD) ./composer.phar update --dev

install: composer production

update: update-production

docs:
	@doxygen

precommit:
	@chmod a+x pre-commit
	@cd .git/hooks && rm -f pre-commit && ln -s ../../pre-commit && echo Installed pre-commit hook
