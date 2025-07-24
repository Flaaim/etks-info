.PHONY: deploy build clean
PHP_EXEC = php

deploy: build
	@echo "🚀 Deploying..."
	@cd ../etks-prod && \
	git add . && \
	git commit --quiet -m "Update production" && \
	git push origin master
	@echo "✅ Done.."


build: run-php
	@echo "🔨 Building Jekyll site..."
	@bundle exec jekyll build -d ../etks-prod
	@echo "✅ Done"

run-php:
	@which $(PHP_EXEC) >/dev/null || (echo "❌ PHP not found"; exit 1)
	@echo "🚀 Running PHP script..."
	@$(PHP_EXEC) ./php/index.php
	@echo "✅ Done"





clean:
	@echo "🧹 Cleaning up..."
	@rm -rf ../etks-prod/*