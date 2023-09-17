# Docker commands

## Common

Restarting the main service:

```bash
service docker restart
```

## Container

Delete all stopped containers:

```bash
docker container prune -f
```

Forcefully delete all containers, including running containers:

```bash
docker rm -f $(docker ps -a -q)
```

View load:

```bash
docker ps -q | xargs docker stats
docker ps -q | xargs docker stats --no-stream
```

## Images

View all images:

```bash
docker image ls -a
```

Docker images consist of several layers. Invalid images are the level of images that no longer have any relation to the tagged images. They waste disk space:

```bash
docker images -f dangling=true
```

Remove invalid images:

```bash
docker rmi $(docker images -f dangling=true -q)
```

Delete all unused images:

```bash
docker image prune -a -f
```
