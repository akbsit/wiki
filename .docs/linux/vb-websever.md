# Установка и настройка веб-сервера на VirtualBox

Предустановленные программы:

* VirtualBox.

Характеристики:

* Linux lubuntu-16.04 desktop amd64;
* Apache 2.4;
* PHP 7;
* MySQL 5.7;
* PHPmyAdmin.

## Создаем виртуальную машину с настройками

* Оперативная память - 1024 мб;
* Вид памяти - динамический 7 гб;
* Система -> Материнская плата -> Порядок загрузки -> Устанавливаем "Ж.Д., CD";
* Система -> Материнская плата -> Чипсет -> Выбрать "ICH9";
* Система -> Материнская плата -> Дополнительные возможности -> Включить "I/O APIC";
* Система -> Процессор -> Устанавливаем "2 ядра";
* Носители -> Контроллер SATA -> Включить "Кешировать ввода/вывода";
* Аудио -> Выключить.

## Linux

Скачиваем с [официального сайта](https://lubuntu.net/downloads/) linux lubuntu-16.04 desktop amd64 и устанавливаем на виртуальную машину. После установки можно обновить предложенные пакеты и отключить обновление.

## Apache

Устанавливаем сервер:

```bash
sudo add-apt-repository -y ppa:ondrej/apache2
sudo apt update
sudo apt install apache2
```

Добавляем файл считывания по умолчанию:

```bash
sudo nano /etc/apache2/mods-enabled/dir.conf
```

> добавляем "index.php"

## PHP

Устанавливаем PHP:

```bash
sudo apt install python-software-properties
sudo add-apt-repository -y ppa:ondrej/php-7.0
sudo apt update
sudo apt install php7.0
```

Устанавливаем PHP пакеты:

```bash
sudo apt install libapache2-mod-php7.0
sudo apt install php7.0-intl
sudo apt install php7.0-cli
sudo apt install php7.0-common
sudo apt install php7.0-fpm
sudo apt install php7.0-curl
sudo apt install php7.0-gd
sudo apt install php7.0-mysql
sudo apt install php7.0-bz2
sudo apt install php7.0-mbstring
sudo apt install php7.0-zip
sudo apt install php7.0-xml
sudo apt install php7.0-json
sudo apt install php7.0-mcrypt
```

Проверяем работу PHP:

```bash
sudo chmod -R 777 /var/www/
```

> добавляем "index.php для теста и выводим phpinfo()"

## MySQL

Устанавливаем MySQL:

```bash
sudo add-apt-repository -y ppa:ondrej/mysql-5.7
sudo apt update
sudo apt install mysql-server-5.7
```

## PHPmyAdmin

Устанавливаем PHPmyAdmin:

```bash
sudo apt install phpmyadmin
```

Подключаем PHPmyAdmin к Apache:

```bash
sudo nano /etc/apache2/apache2.conf
```

> добавляем "Include /etc/phpmyadmin/apache.conf" в конец файла

## Завершение

Перезагружаем сервер:

```bash
sudo service apache2 restart
```

## Отключение/включение графической оболочки

Чтобы не тратить ресурсы на грфическую облочку можно отключить:

```bash
sudo systemctl set-default multi-user.target
```

Чтобы включить:

```bash
sudo systemctl set-default graphical.target
```

## Включаем mod_rewrite

```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

## Настройка общей папки

Настраиваем VirtualBox:

* Сеть -> Тип подключения -> Выбрать "Сетевой мост".
* Общие папки -> Добавить папку -> Устанавливаем путь до папки на host машине, указываем название папки на сервере "public" (непосредственно на сервере она будет именоваться "sf_public") и включаем "Авто-подключение";
* Загрузив сервер подключить Устройства -> "Подключить образ Диска дополнений гостевой ОС".

Устанавливаем необходимые пакеты на сервере:

```bash
sudo apt install dkms build-essential linux-headers-generic
```

Запускаем VBoxLinuxAdditions в папке с гостевым ПО:

```bash
sudo sh ./VBoxLinuxAdditions.run
```

Добавляем пользователя для работы с общей папкой:

```bash
sudo adduser <имя пользователя на сервере> vboxsf
sudo usermod -aG vboxsf www-data
```

Настраиваем пути до общей папки, где будут размещаться сайты:

```bash
sudo nano /etc/apache2/apache2.conf
```

```text
#<Directory /var/www> 
#…
#</Directory>
```

> Комментируем строки

```text
<Directory /media/sf_public>
    Options Indexes FollowSymLinks MultiViews
    AllowOverride All
    Order Allow,Deny
    Allow from all
    Require all granted
</Directory>
```

> В конец файла добавляем

```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```

> Заменяем DocumentRoot /var/www/html -> DocumentRoot /media/sf_public

Настройка общей папки закончена, далее отключаем "Диск дополнений гостевой ОС".

## Настраиваем доступ к MySQL с host машины

```bash
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
```

> Заменяем bind-address	= 127.0.0.1 -> bind-address	= 0.0.0.0

Перезапускаем MySQL сервер:

```bash
sudo service mysql restart
```

Подключаемся к базе данных пользователем root через mysql-client:

```bash
mysql -u root -p;
```

Выбираем схему MySQL по умолчанию:

```sql
use mysql;
```

Выводим список всех хостов и пользователей базы данных:

```sql
select host, user from user;
```

Изменяем host для пользователя root: 

```sql
update user set host='%' where user='root';
```

Обновляем привелегии:

```sql
flush privileges;
```

## Добавление виртуальных хостов (доменов)

Устанавливаем права на папку sites-available:

```bash
sudo chmod -R 777 /etc/apache2/sites-available/
```

Добавляем домен:

```bash
sudo cd /etc/apache2/sites-available/
sudo nano test.loc.conf
```

Содержимое файла test.loc.conf:

```text
<VirtualHost *:80>
    ServerName test.loc
    DocumentRoot /media/sf_public/test.loc/
</VirtualHost>
```

Регистрируем домен:

```bash
sudo a2ensite test.loc
```

Перезапускаем сервер:

```bash
service apache2 restart
```

На машине host добавляем домен (127.0.0.1 test.loc) в конец файла:

```bash
sudo nano /etc/hosts
```

## Статьи

* [Мастерим собственный локальный веб-сервер на VirtualBox](http://falbar.ru/article/masterim-sobstvennyj-lokalnyj-veb-server-na-virtualbox);
* [Устанавливаем Apache, PHP, MySQL и PHPMyAdmin на Linux](http://falbar.ru/article/ustanavlivaem-apache-php-mysql-i-phpmyadmin-na-linux);
* [Настраиваем общую папку на VirtualBox для локального веб-сервера](http://falbar.ru/article/nastraivaem-obshhuyu-papku-na-virtualbox-dlya-lokalnogo-veb-servera);
* [Настраиваем доступ к MySQL на VirtualBox из HOST машины](http://falbar.ru/article/nastraivaem-dostup-k-mysql-na-virtualbox-iz-host-mashiny).
