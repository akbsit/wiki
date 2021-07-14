#!/bin/bash

echo "Docker status system:"
docker system df

echo "Clear system:"
docker system prune -af
echo "done."

echo "Clear containers:"
docker rm -f $(docker ps -a -q) &> /dev/null
echo "done."

echo "Clear images:"
docker rmi $(docker images -f dangling=true -q) &> /dev/null
echo "done."

echo "Clear networks:"
docker network prune -f &> /dev/null
echo "done."

echo "Clear volumes:"
docker volume rm $(docker volume ls -q --filter dangling=true) &> /dev/null
echo "done."

echo "Docker status system:"
docker system df
