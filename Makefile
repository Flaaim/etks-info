.PHONY: deploy build clean


deploy: build
	@echo "🚀 Deploying..."
	@cd ../etks-prod && \
	git add . && \
	git commit --quiet -m "Update production" && \
	git push origin master
	@echo "✅ Done.."


build:
	@echo "🔨 Building Jekyll site..."
	bundle exec jekyll build -d ../etks-prod

clean:
	@echo "🧹 Cleaning up..."
	@rm -rf ../etks-prod/*