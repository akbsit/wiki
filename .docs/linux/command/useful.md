# Полезные команды

Просмотр IP:

```bash
ifconfig | grep "inet " | grep -v 127.0.0.1
```

Узнать установление пакеты PHP:

```bash
dpkg --get-selections | grep -v deinstall | grep php<версия>
```

Очистить папку:

```bash
rm -rf <путь до папки>/*
```

Выполнение PHP скрипта с настройками (пример):

```bash
php -d short_open_tag=On vendor/bin/phinx status
```

Узнать размеры файлов в текущей папке:

```bash
du -sh *
```

Сменить для папки владельца:

```bash
sudo chown -R <пользователь> <путь до папки>
```

Очистить почту:

```bash
mail -N
d *
quit
```

Найти запущенный процесс (занятый порт):

```bash
lsof -i tcp:<port>
```

Посмотреть открытые порты:

```bash
sudo lsof -PiTCP -sTCP:LISTEN
```

Убить процесс с помощью его id

```bash
kill -9 <id>
```
