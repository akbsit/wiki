# Настройка SSH подключения (на примере timeweb)

Если на ПК нет SSH, то генерируем ключи:

```bash
ssh-keygen
```

Первый способ (копируем SSH ключ на сервер):

```bash
ssh-copy-id -i ~/.ssh/id_rsa <пользователь>@<сервер>.timeweb.ru
```

Второй способ (копируем SSH ключ на сервер):

```bash
scp ~/.ssh/id_rsa.pub <пользователь>@<сервер>.timeweb.ru:~
```

Третий способ (на сервере, если ключ лежит в корне):

```bash
[ -d ~/.ssh ] || (mkdir ~/.ssh; chmod 700 ~/.ssh)
cat ~/id_rsa.pub >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
rm ~/id_rsa.pub
```
