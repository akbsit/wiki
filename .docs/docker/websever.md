# Установка и настройка веб-сервера

За основу взята сборка генерируемая при помощи [инструмента](https://phpdocker.io/generator).

## Характеристики

* Nginx - `nginx:alpine`;
* Memcached- `memcached:alpine`;
* PHP - `phpdockerio/php72-fpm:latest`;
* MySQL - `mysql:8.0`.

## Разворачивание

Скачиваем [файлы](webserver) в папке `./webserver/` и размещаем у себя на локальной машине.

Далее настраиваем `docker-compose.yaml`:

```
memcached:
    container_name: <название контейнера>
```

```
mysql:
    container_name: <название контейнера>
    environment:
        - MYSQL_ROOT_PASSWORD=<пароль>
        - MYSQL_DATABASE=<название базы данных>
        - MYSQL_USER=<имя пользователя>
        - MYSQL_PASSWORD=<пароль пользователя>
```

```
webserver:
    container_name: <название контейнера>
```

```
php-fpm:
    container_name: <название контейнера>
```

После настройки в консоле переходим в папку с файлом `docker-compose.yaml` и запускаем билд:

```
docker-compose build --no-cache
`````

Запускаем контейнеры:

```
docker-compose up -d
```

После чего, если не было ошибок работу веб-сервера можно будет увидеть по адрессу `http://localhost:8081/`, отобразиться содержимое файла `./webserver/public/index.php`.

> Для подключения к базе данных через PHP нужно вместо `localhost` использовать `mysql`

## Полезные команды для работы с веб-сервером

Остановить контейнеры:

```
docker-compose down
```

Зайти в консоль контейнера:

```
docker-compose exec <название контейнера> /bin/bash
```

Посмотреть состояние контейнеров:

```
docker ps
docker ps -a
docker-compose ps
```