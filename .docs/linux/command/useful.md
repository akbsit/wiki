# Полезные команды

Узнать установление пакеты PHP

```
dpkg --get-selections | grep -v deinstall | grep php<версия>
```

Очистить папку

```
rm -rf <путь до папки>/*
```

Выполнение PHP скрипта с настройками (пример)

```
php -d short_open_tag=On vendor/bin/phinx status
```