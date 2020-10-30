APP_NAME ?= "rock_paper_scissors"

## Commands ##
## make start container
start:
	@bash scripts/app-start.sh $(APP_NAME)

## make stop container
stop:
	@bash scripts/app-stop.sh $(APP_NAME)

## make start of the game
game-start:
	docker-compose -p $(APP_NAME) exec php bin/console app:game:start

## make test of the game
test:
	docker-compose -p $(APP_NAME) exec php composer test
%:
@:
