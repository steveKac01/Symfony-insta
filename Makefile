#---------------- VARIABLES --------------#
#-------DOCKER
DOCKER_COMPOSE = docker-compose
DOCKER_COMPOSE_UP = $(DOCKER_COMPOSE) up -d
DOCKER_COMPOSE_STOP = $(DOCKER_COMPOSE) stop
#-------SYMFONY
SYMFONY = symfony
SYMFONY_CONSOLE = $(SYMFONY) console
SYMFONY_SERVER_START = $(SYMFONY) serve -d
SYMFONY_SERVER_STOP = $(SYMFONY) server:stop
#------------------------------------------#


#-------SYMFONY
sf-start:
	$(SYMFONY_SERVER_START)
.PHONY: sf-start

sf-stop:
	$(SYMFONY_SERVER_STOP)
.PHONY: sf-stop

sf-dc:
	$(SYMFONY_CONSOLE) d:d:c --if-not-exists
.PHONY: sf-dc

sf-dd:
	$(SYMFONY_CONSOLE) d:d:d --force
.PHONY: sf-dd

sf-mm:
	$(SYMFONY_CONSOLE) d:m:m --no-interaction
.PHONY: sf-mm


sf-fixtures:
	$(SYMFONY_CONSOLE) d:f:l --no-interaction
.PHONY: sf-fixt


#-------DOCKER
dk-up:
	$(DOCKER_COMPOSE_UP)
.PHONY: dk-up

dk-stop:
	$(DOCKER_COMPOSE_STOP)
.PHONY: dk-stop