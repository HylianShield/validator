PHPCMD=php -d suhosin.executor.include.whitelist=phar
COMPFILE=./composer.phar
COMPCMD=$(PHPCMD) $(COMPFILE)
DOCCMD=vendor/bin/apigen

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
	@$(DOCCMD) --config apigen.neon
