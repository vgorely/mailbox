.PHONY: dependencies docs help ssh standards tests

COLOR_DEFAULT=\033[0m
COLOR_SUCCESS=\033[32m
COLOR_WARNING=\033[33m
COLOR_ERROR=\033[31m

#-----------------------------------------------------------------------------------------------------------------------
# Functions
#-----------------------------------------------------------------------------------------------------------------------

define container_app
	@docker-compose exec app /bin/sh -c "$(1)"
endef

#-----------------------------------------------------------------------------------------------------------------------
# Rules
#-----------------------------------------------------------------------------------------------------------------------

help:
	@echo "$(COLOR_WARNING)Available rules:"

	@echo "  $(COLOR_SUCCESS)db.import\t\t$(COLOR_DEFAULT)Import file to database"
	@echo "  $(COLOR_SUCCESS)db.migration.generate\t$(COLOR_DEFAULT)Generate database migration"
	@echo "  $(COLOR_SUCCESS)db.migration.reset\t$(COLOR_DEFAULT)Reset database migrations"
	@echo "  $(COLOR_SUCCESS)db.migration.run\t$(COLOR_DEFAULT)Run database migrations\n"

	@echo "  $(COLOR_SUCCESS)dependencies\t\t$(COLOR_DEFAULT)Install dependencies\n"

	@echo "  $(COLOR_SUCCESS)docs\t\t\t$(COLOR_DEFAULT)Build documentation\n"

	@echo "  $(COLOR_SUCCESS)ssh\t\t\t$(COLOR_DEFAULT)SSH into 'app' container\n"

	@echo "  $(COLOR_SUCCESS)standards\t\t$(COLOR_DEFAULT)Check code standards\n"

	@echo "  $(COLOR_SUCCESS)tests\t\t\t$(COLOR_DEFAULT)Run tests"

db.import:
	@echo "$(COLOR_SUCCESS)==> Importing file to database ...$(COLOR_DEFAULT)"
	${call container_app, bin/console db:import}

db.migration.generate:
	@echo "$(COLOR_SUCCESS)==> Generating database migration...$(COLOR_DEFAULT)"
	${call container_app, bin/console migrations:generate}

db.migration.reset:
	@echo "$(COLOR_SUCCESS)==> Resetting database migrations...$(COLOR_DEFAULT)"
	${call container_app, bin/console migrations:migrate first --no-interaction}

db.migration.run:
	@echo "$(COLOR_SUCCESS)==> Running database migrations...$(COLOR_DEFAULT)"
	${call container_app, bin/console migrations:migrate --no-interaction}

dependencies:
	@echo "$(COLOR_SUCCESS)==> Installing dependencies...$(COLOR_DEFAULT)"
	${call container_app, composer install --no-interaction --no-progress --optimize-autoloader --prefer-dist}

docs:
	@echo "$(COLOR_SUCCESS)==> Building documentation...$(COLOR_DEFAULT)"
	@mkdir -p public/docs
	@docker run --rm -it -v $(PWD):/data letsdeal/raml2html:6.2 \
		docs/api.raml > public/docs/api.html

ssh:
	@docker-compose exec app /bin/sh

standards:
	@echo "$(COLOR_SUCCESS)==> Checking code standards...$(COLOR_DEFAULT)"
	@docker run --rm -it -v $(PWD):/app rcrosby256/php-cs-fixer \
		fix --diff --dry-run

	@echo "$(COLOR_SUCCESS)==> Checking for code mess...$(COLOR_DEFAULT)"
	@docker run --rm -it -v $(PWD):/workspace shavenking/docker-phpmd \
		src text ruleset.xml --suffixes php

tests:
	@echo "$(COLOR_SUCCESS)==> Running tests...$(COLOR_DEFAULT)"
	${call container_app, vendor/bin/phpunit --coverage-html=public/tests}
