PHPCMD=php -d suhosin.executor.include.whitelist=phar
COMPFILE=./composer.phar
COMPCMD=$(PHPCMD) $(COMPFILE)
DOCCMD=vendor/bin/phpdoc
SOURCE=vendor/hylianshield/validator/src
OUTPUT=docs

composer:
	@if [ ! -f $(COMPFILE) ]; then \
		$(PHPCMD) -r "readfile('https://getcomposer.org/installer');" | \
		$(PHPCMD) -- --filename=$(COMPFILE); \
	fi
	@$(COMPCMD) self-update

dependencies: composer
	@$(COMPCMD) install --dev

install: dependencies

update: dependencies
	@$(COMPCMD) update --dev

dox:
	@$(DOCCMD) run -d $(SOURCE) -t $(OUTPUT)
