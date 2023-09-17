# Useful commands

View IP:

```bash
ifconfig | grep "inet " | grep -v 127.0.0.1
```

Find out how to install PHP packages:

```bash
dpkg --get-selections | grep -v deinstall | grep php<version>
```

Clear folder:

```bash
rm -rf <path to folder>/*
```

Executing a PHP script with settings (example):

```bash
php -d short_open_tag=On vendor/bin/phinx status
```

Find out the file sizes in the current folder:

```bash
du -sh *
```

Change for owner folder:

```bash
sudo chown -R <user> <path to folder>
```

Clear mail:

```bash
mail -N
d *
quit
```

Find running process (busy port):

```bash
lsof -i tcp:<port>
```

View open ports:

```bash
sudo lsof -PiTCP -sTCP:LISTEN
```

Kill a process using its id

```bash
kill -9 <id>
```
