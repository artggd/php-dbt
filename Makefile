define docker
	docker $(1)
endef

define php
	@$(call docker, run --rm -it -u $(id -u):$(id -g) -v ${PWD}:/app --workdir="/app" php:8.1.2-cli $(1))
endef

define composer
	@$(call docker, run --rm -it -v ${PWD}:/app --workdir="/app" composer:latest $(1))
endef

install: ##@init Install dependencies
	$(call composer, install)

require: ##@tooling Require a backend dependency
	$(call composer, req)

require-dev: ##@tooling Require a backend dependency in dev only
	$(call composer, req --dev)

run:
	$(call php, php ./phpdbt)
