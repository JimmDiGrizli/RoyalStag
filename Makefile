build:
	docker build . -t royalstag

up:
	docker run -v "$(shell pwd):/var/www" -it --rm royalstag /bin/ash

test:
	








docker run -v $(shell pwd):/var/www -it --rm royalstag composer install
	docker run -v $(shell pwd):/var/www -it --rm royalstag vendor/bin/phpcs --standard=PSR2 --encoding=utf-8 src 
	docker run -v $(shell pwd):/var/www -it --rm royalstag vendor/bin/phpunit --configuration ./phpunit.xml.dist

