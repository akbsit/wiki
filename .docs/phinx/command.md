# Phinx команды

Создать миграцию:

```bash
php vendor\bin\phinx create <НазваниеМиграции>
```

Применить миграцию:

```bash
php vendor\bin\phinx migrate
```

Откатить миграцию:

```bash
php vendor\bin\phinx rollback
```

Откатить все миграции:

```bash
php vendor\bin\phinx rollback -t 0
```
