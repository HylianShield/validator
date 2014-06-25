PHPCMD=php -d suhosin.executor.include.whitelist=phar
PRECOMMIT=".git/hooks/pre-commit"

codecoverage:
	@vendor/bin/phpunit -c test/phpunit-coverage.xml

unittest:
	@vendor/bin/phpunit -c test/phpunit.xml

test: unittest

precommit:
	@rm -f $(PRECOMMIT)
	@echo "#!/bin/sh" > $(PRECOMMIT)
	@echo "make test" >> $(PRECOMMIT)
	@chmod a+x $(PRECOMMIT)
	@echo Installed $(PRECOMMIT)

composer:
	@$(PHPCMD) -r "readfile('https://getcomposer.org/installer');" | $(PHPCMD)

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

install-production: composer production

install-development: composer precommit development test

install: install-production

update: update-production
