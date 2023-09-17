# General commands

## File system

View file system:

```bash
df -h
```

View directory contents:

```bash
ls -lQa
```

View memory:

```bash
free
```

## Net

View network connection:

```bash
ifconfig
```

## Others

View list of tasks:

```bash
jobs
```

Login as root:

```bash
sudo su -
```

View installed modules:

```bash
lsmod
```

View module description:

```bash
modinfo <module>
```

View system settings:

```bash
cat /proc/cpuinfo
cat /proc/mounts
```

View list of signals:

```bash
kill -l
```

View typed commands:

```bash
history
```

Execute the command from the history list:

```bash
history <number>
```

View process data:

```bash
ps auxwww
ps -efwww
vmstat
vmstat 3
```

View command help:

```bash
man <command>
man <section> <command|file>
```

Show command and execute:

```bash
!<number>
```
