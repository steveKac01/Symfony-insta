#---------------- VARIABLES --------------#
#-------DOCKER
DOCKER_COMPOSE = docker compose
DOCKER_COMPOSE_UP = $(DOCKER_COMPOSE) up -d
DOCKER_COMPOSE_STOP = $(DOCKER_COMPOSE) stop
#-------COMPOSER
COMPOSER = composer
COMPOSER_INSTALL = $(COMPOSER) install
#-------SYMFONY
SYMFONY = symfony
SYMFONY_CONSOLE = $(SYMFONY) console
SYMFONY_SERVER_START = $(SYMFONY) serve -d
SYMFONY_SERVER_STOP = $(SYMFONY) server:stop
#------------------------------------------#

##-------SYMFONY
sf-start: ## Start symfony server
	$(SYMFONY_SERVER_START)
.PHONY: sf-start

sf-stop: ## Stop symfony server
	$(SYMFONY_SERVER_STOP)
.PHONY: sf-stop

sf-dc: ## Create database
	$(SYMFONY_CONSOLE) d:d:c --if-not-exists
.PHONY: sf-dc

sf-dd: ## Drop database
	$(SYMFONY_CONSOLE) d:d:d --if-exists --force
.PHONY: sf-dd

sf-mm: ## Migrate migration
	$(SYMFONY_CONSOLE) d:m:m --no-interaction
.PHONY: sf-mm

sf-fixtures: ## Load fixtures
	$(SYMFONY_CONSOLE) d:f:l --no-interaction
.PHONY: sf-fixt

sf-url: ## Open project in a browser
	$(SYMFONY) open:local
.PHONY: sf-url

sf-cache: ## Clear the cache
	$(SYMFONY_CONSOLE) cache:clear
.PHONY: sf-cache

##
##-------DOCKER
dk-up: ## Start docker containers
	$(DOCKER_COMPOSE_UP)
.PHONY: dk-up

dk-stop: ## Stop docker containers
	$(DOCKER_COMPOSE_STOP)
.PHONY: dk-stop

##
##-------COMPOSER
cp-install: ## Composer install
	$(COMPOSER_INSTALL)
.PHONY: cp-install

##
##------GLOBAL PROJECT
init: cp-install dk-up ## Init project
.PHONY: init

start: dk-up sf-start sf-url ## Start project
.PHONY: start

stop: dk-stop sf-stop ## Stop project
.PHONY: stop

reset-db: 
	$(eval CONFIRM := $(shell read -p "Reset the database? [Y/N] " CONFIRM && echo $${CONFIRM:-N}))
	@if [ "$(CONFIRM)" = "Y" ]; then \
		$(MAKE) sf-dd; \
		$(MAKE) sf-dc; \
		$(MAKE) sf-mm; \
		$(MAKE) sf-fixtures; \
	fi 
.PHONY: reset-db ## Reset database

help: ## Display the list of all commands
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'