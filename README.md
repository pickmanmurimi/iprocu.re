# Senior Software Engineer - Mini Project (NodeJS/PHP)
## Lumen

### Api Documentation
https://documenter.getpostman.com/view/4401620/UVXkmZgD

# setup
### Requirements

- apache/Nginx
- php 8.^
- mysql:8.0
- sqlite
- Lumen dependencies and installation requirements are listed here, https://lumen.laravel.com/docs/8.x/installation#installation

## Environment Setup

This is a very simple api instance, all you really need to do is to copy the `.env.example` file and
paste it as `.env`.
You now just need to change the values for the following variables to match your environment.

```
#change the app url to match your host setup
APP_URL=http://iprocure.test

# basic database credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iprocure
DB_USERNAME=iprocure
DB_PASSWORD=

```

## Running the Project.

A lumen project is quite easy to get running, You basically need to run.

    composer install
Finally,

    php artisan serve
In case you do not have virtual hosts configured on your pc.
It is recommended you run this using a development environment like laravel valet or laragon.
