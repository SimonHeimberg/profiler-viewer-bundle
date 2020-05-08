# run "make" or "make help" to see the help

.DEFAULT_GOAL := help

help:
	@awk 'BEGIN {FS = ":.*?## "}; /^[a-zA-Z-]+:.*?## .*$$/ {printf "\x1b[32m%-15s\x1b[0m %s\n", $$1, $$2}' Makefile | sort
.PHONY: help

# commit checks

check-lastCommit: ## check last done (HEAD) commit
	pre-commit run --source HEAD~ --origin HEAD
.PHONY: check-lastCommit

check-changes: ## check changed files
	pre-commit run --files $(git diff --name-only)
.PHONY: check-changes

check-precommit: ## check all added files (after git add)
	pre-commit run
.PHONY: check-precommit

check-branch: ## checks all files changed since origin/development
	pre-commit run --source origin/development~ --origin HEAD
.PHONY: check-branch

# validate targets

validate-stan: ## runs phpstan (missing variables, wrong case, ...)
	./vendor/bin/phpstan analyse
.PHONY: validate-stan

validate-codestyle: ## runs phpcs (code style)
	./vendor/bin/phpcs --colors .
.PHONY: validate-codestyle

validate-cs-fixer: ## runs php-cs-fixer (code style)
	./vendor/bin/php-cs-fixer fix -v --ansi --dry-run --diff
.PHONY: validate-cs-fixer

validate-all: validate-codestyle validate-cs-fixer validate-stan ## runs all validation-* commands
.PHONY: validate-all

.phpstan_baseline.neon: make-phpstan-baseline
make-phpstan-baseline: ## updates ./.phpstan_baseline.neon, please check before committing
	vendor/bin/phpstan analyse --error-format baselineNeon $$(git ls-files '*.php') > .phpstan_baseline.neon || true
	@echo .phpstan_baseline.neon updated, please check it before committing
.PHONY: make-phpstan-baseline
