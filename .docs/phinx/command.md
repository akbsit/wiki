# Phinx teams

Create migration:

```bash
php vendor\bin\phinx create <MigrationName>
```

Apply migration:

```bash
php vendor\bin\phinx migrate
```

Rollback migration:

```bash
php vendor\bin\phinx rollback
```

Roll back all migrations:

```bash
php vendor\bin\phinx rollback -t 0
```
