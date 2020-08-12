# laravel-docker

- **mysql** - `:3306`
- **httpd** - `:9999`


Running `docker-compose up -d --build php` to build environment apache-php-mysql

Running `docker-compose run --rm composer create-project laravel/laravel [ProjectName]` to create new project with laravel framework.
This process take a few minutes.

Open your browser with url: `localhost:9999/test` to check environment has built