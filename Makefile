PHPCMD=php -d suhosin.executor.include.whitelist=phar
BASE = "test/Tests/HylianShield/Validator/"
FLAGS = ""

# If a validator is supplied, we want to unit test that.
ifneq ($(strip $(VALIDATOR)),)
        FLAGS = $(BASE)$(VALIDATOR)"Test.php"
endif

base: composer precommit test

codecoverage:
	@vendor/bin/phpunit -c test/phpunit-coverage.xml $(FLAGS)

unittest:
	@vendor/bin/phpunit -c test/phpunit.xml $(FLAGS)

bench:
	@vendor/bin/athletic -p benchmark/Benchmarks -b benchmark/bootstrap.php

composer:
	@curl -sS https://getcomposer.org/installer | $(PHPCMD)

production:
	@$(PHPCMD) ./composer.phar self-update
	@$(PHPCMD) ./composer.phar install --no-dev --optimize-autoloader

development:
	@$(PHPCMD) ./composer.phar self-update
	@$(PHPCMD) ./composer.phar install --dev

install: composer production

update:
	@$(PHPCMD) ./composer.phar self-update
	@$(PHPCMD) ./composer.phar update --optimize-autoloader

docs:
	@doxygen

precommit:
	@chmod a+x pre-commit
	@cd .git/hooks && rm -f pre-commit && ln -s ../../pre-commit && echo Installed pre-commit hook

test: unittest
