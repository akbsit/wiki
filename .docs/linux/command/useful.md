# Полезные команды

Просмотр IP:

```
ifconfig | grep "inet " | grep -v 127.0.0.1
```

Узнать установление пакеты PHP:

```
dpkg --get-selections | grep -v deinstall | grep php<версия>
```

Очистить папку:

```
rm -rf <путь до папки>/*
```

Выполнение PHP скрипта с настройками (пример):

```
php -d short_open_tag=On vendor/bin/phinx status
```

Узнать размеры файлов в текущей папке:

```
du -sh *
```

Сменить для папки владельца:

```
sudo chown -R <пользователь> <путь до папки>
```

Очистить почту:

```
mail -N
d *
quit
```