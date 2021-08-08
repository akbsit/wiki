# Docker команды

## Общие

Перезапуск главного сервиса:

```bash
service docker restart
```

## Контейнера

Удалить все остановленные контейнера:

```bash
docker container prune -f
```

Принудительно удалить все контейнеры, включая запущенные контейнеры:

```bash
docker rm -f $(docker ps -a -q)
```

Просмотр нагрузки:

```bash
docker ps -q | xargs docker stats
docker ps -q | xargs docker stats --no-stream
```

## Образы

Посмотреть все оброзы:

```bash
docker image ls -a
```

Образы Docker состоят из нескольких уровней. Недействительные образы – это уровень образов, которые больше не имеют никакого отношения к образам с метками. Они впустую потребляют дисковое пространство:

```bash
docker images -f dangling=true
```

Удалить недействительные образы:

```bash
docker rmi $(docker images -f dangling=true -q)
```

Удалить все неиспользуемые образы:

```bash
docker image prune -a -f
```
