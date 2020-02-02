# Phinx команды

Создать миграцию:

```
php vendor\bin\phinx create <НазваниеМиграции>
```

Применить миграцию:

```
php vendor\bin\phinx migrate
```

Откатить миграцию:

```
php vendor\bin\phinx rollback
```

Откатить все миграции:

```
php vendor\bin\phinx rollback -t 0
```