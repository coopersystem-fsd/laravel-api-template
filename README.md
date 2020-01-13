# Laravel API Template

Template base para construção de APIs.

## Features

- Login (JWT)

## Pacotes utilizados

- [Laravel Modules](https://github.com/nWidart/laravel-modules)

## Pre-requisitos

- Docker
- Docker Compose

## Ambiente

Existem algumas variáveis de ambiente que podem ser definidas:

```
DOCKER_UID=1000
DOCKER_GID=1000
DOCKER_PORT=80
```

Para alterar a porta onde aplicação será executada altere a variável `DOCKER_PORT`. 

## Instalação

Clone o projeto e acesse a pasta:

```shell script
git clone git@github.com:coopersystem-fsd/laravel-api-template.git myapp
cd myapp
``` 

Suba o ambiente utilizando o `docker-compose`:

```shell script
docker-compose up -d
```

Acesse o container para executar os próximos passos:

```shell script
docker-compose exec --user=laravel laravelapi bash
```

Após executar esse comando você deveria ter acesso ao `bash` dentro do container na pasta raíz do projeto.

Copie o arquivo `.env.example` para `.env`:

```shell script
cp .env.example .env
```

Gere a chave da aplicação:

```shell script
php artisan key:generate
```

Crie a estrutura do banco de dados executando o seguinte comando:

```shell script
php artisan migrate
```

## Uso

A aplicação deveria estar disponível em `http://localhost`.

**OBS** Se você alterou a variável de ambiente `DOCKER_PORT` a aplicação vai estar disponível em `http://localhost:PORTA`
