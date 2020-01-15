# Laravel API Template

Template to build REST APIs.

## Features

- Login (JWT)

## Packages

- [Laravel Modules](https://github.com/nWidart/laravel-modules)

## Pre-requisites

- Docker
- Docker Compose

## Environment

Exists some environment var that can be overwrite.

```
DOCKER_UID=1000
DOCKER_GID=1000
DOCKER_PORT=80
```

To change the application port change the `DOCKER_PORT` var. 

## Installation

Clone the project and access the root folder:

```shell script
git clone git@github.com:coopersystem-fsd/laravel-api-template.git myapp
cd myapp
``` 

Up the environment with `docker-compose`:

```shell script
docker-compose up -d
```

Access the container to execute the next steps:

```shell script
docker-compose exec --user=laravel laravelapi bash
```

Copy the `.env.example` file to `.env`:

```shell script
cp .env.example .env
```

Generate the application key:

```shell script
php artisan key:generate
```

Generate too the JWT auth key:

```shell script
php artisan jwt:secret
```

Create the database structure:

```shell script
php artisan migrate
```

## Uso

The application should be available in `http://localhost`.

**Warning** If you change the environment var `DOCKER_PORT` the application will run according to the port. E.g.:
 
```dotenv
DOCKER_PORT=8080
```
 
Application available in `http://localhost:8080`
