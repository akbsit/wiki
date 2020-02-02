# Настройка GIT на сервере (на примере timeweb)

Заходим на сервер через SSH:

```
ssh <пользователь>@<сервер>.timeweb.ru
```

Заходим в папку проекта, для примера <example.com>, и инициализируем там репозиторий:

```
cd <example.com>
git init
```

Установка настроек для GIT на сервере (если до этого не было):

```
git config --global user.name "<Имя Фамилия>"
git config --global user.email <example@mail.com>
```

Проверка настроек:

```
git config --list
```

Если папка с проектом пуста, то добавляем произвольный файл (например .gitignore)

Делаем первый коммит:

```
git add .
git commit -m "init"
```

Создаем в корне папку git и переходим в нее:

```
cd ~
mkdir git
cd git
```

Инициализируем bare-репозиторий:

```
git clone --bare ../<example.com> <example.com>.git
```

Возвращаемся в папку проекта и настраиваем remote для проекта:

```
cd ~/<example.com>
git remote add origin ../git/<example.com>.git
```

Добавляем хук post-update в bare-репозиторий и устанавливаем нужные права на файл:

```
cd ~/git/<example.com>.git/hooks
```

```
#!/bin/sh

cd /home/<первая буква пользователя>/<пользователь>/<example.com> || exit
unset GIT_DIR
git pull origin master

exec git-update-server-info
```

```
chmod +x post-update
```

Добавляем хук post-commit в репозиторий проекта:

```
cd ~/<example.com>/.git/hooks
```

```
#!/bin/sh
git push origin
```

```
chmod +x post-commit
```

Возвращаемся в папку проекта и пушимся:

```
cd ~/<example.com>
git push --set-upstream shared master
```

Теперь можно клонировать себе на ПК:

```
git clone ssh://<пользователь>@<сервер>.timeweb.ru/home/<первая буква пользователя>/<пользователь>/<example.com>/git/<example.com>.git ./
```

> Работа происходит как с обычным GIT репозиторием

> Продакшн является master веткой