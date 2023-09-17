# Installing and configuring a web server on VirtualBox

Pre-installed programs:

* VirtualBox.

Characteristics:

* Linux lubuntu-16.04 desktop amd64;
* Apache 2.4;
* PHP 7;
* MySQL 5.7;
* PHPmyAdmin.

## Create a virtual machine with settings

* RAM - 1024 MB;
* Memory type - dynamic 7 GB;
* System -> Motherboard -> Boot order -> Install "HD, CD";
* System -> Motherboard -> Chipset -> Select "ICH9";
* System -> Motherboard -> Additional features -> Enable "I/O APIC";
* System -> Processor -> Install "2 cores";
* Media -> SATA Controller -> Enable "Caching I/O";
* Audio -> Turn off.

## Linux

Download from [official website](https://lubuntu.net/downloads/) linux lubuntu-16.04 desktop amd64 and install it on a virtual machine. After installation, you can update the suggested packages and disable the update.

## Apache

Installing the server:

```bash
sudo add-apt-repository -y ppa:ondrej/apache2
sudo apt update
sudo apt install apache2
```

Add a default readout file:

```bash
sudo nano /etc/apache2/mods-enabled/dir.conf
```

> add "index.php"

## PHP

Install PHP:

```bash
sudo apt install python-software-properties
sudo add-apt-repository -y ppa:ondrej/php-7.0
sudo apt update
sudo apt install php7.0
```

Install PHP packages:

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

Checking the operation of PHP:

```bash
sudo chmod -R 777 /var/www/
```

> add "index.php for testing and output phpinfo()"

## MySQL

Install MySQL:

```bash
sudo add-apt-repository -y ppa:ondrej/mysql-5.7
sudo apt update
sudo apt install mysql-server-5.7
```

## PHPmyAdmin

Install PHPmyAdmin:

```bash
sudo apt install phpmyadmin
```

Connect PHPmyAdmin to Apache:

```bash
sudo nano /etc/apache2/apache2.conf
```

> add "Include /etc/phpmyadmin/apache.conf" to the end of the file

## Completion

Reboot the server:

```bash
sudo service apache2 restart
```

## Disable/enable the graphical shell

In order not to waste resources on the graphical interface, you can disable:

```bash
sudo systemctl set-default multi-user.target
```

To turn on:

```bash
sudo systemctl set-default graphical.target
```

## Enable mod_rewrite

```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

## Setting up a shared folder

Setting up VirtualBox:

* Network -> Connection type -> Select "Network Bridge".
* Public folders -> Add folder -> Set the path to the folder on the host machine, specify the name of the folder on the server "public" (directly on the server it will be called "sf_public") and enable "Auto-connect";
* After loading the server, connect Devices -> "Connect the Guest OS Additions Disk image."

Install the necessary packages on the server:

```bash
sudo apt install dkms build-essential linux-headers-generic
```

Run VBoxLinuxAdditions in the folder with the guest software:

```bash
sudo sh ./VBoxLinuxAdditions.run
```

Add a user to work with the shared folder:

```bash
sudo adduser <server username> vboxsf
sudo usermod -aG vboxsf www-data
```

We configure the paths to the shared folder where the sites will be located:

```bash
sudo nano /etc/apache2/apache2.conf
```

```text
#<Directory /var/www>
#…
#</Directory>
```

> Comment out the lines

```text
<Directory /media/sf_public>
    Options Indexes FollowSymLinks MultiViews
    AllowOverride All
    Order Allow,Deny
    Allow from all
    Require all granted
</Directory>
```

> Add to the end of the file

```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```

> Replace DocumentRoot /var/www/html -> DocumentRoot /media/sf_public

Setting up the shared folder is complete, then disable the “Guest OS Additions Disk”.

## Setting up access to MySQL from the host machine

```bash
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
```

> Replace bind-address = 127.0.0.1 -> bind-address = 0.0.0.0

Restart MySQL server:

```bash
sudo service mysql restart
```

Connect to the database as root via mysql-client:

```bash
mysql -u root -p;
```

Select the default MySQL schema:

```sql
use mysql;
```

We display a list of all hosts and users in the database:

```sql
select host, user from user;
```

Change the host for the root user:

```sql
update user set host='%' where user='root';
```

Updating privileges:

```sql
flush privileges;
```

## Adding virtual hosts (domains)

Set permissions for the sites-available folder:

```bash
sudo chmod -R 777 /etc/apache2/sites-available/
```

Add a domain:

```bash
sudo cd /etc/apache2/sites-available/
sudo nano test.loc.conf
```

Contents of the test.loc.conf file:

```text
<VirtualHost *:80>
    ServerName test.loc
    DocumentRoot /media/sf_public/test.loc/
</VirtualHost>
```

Register a domain:

```bash
sudo a2ensite test.loc
```

Restart the server:

```bash
service apache2 restart
```

On the host machine, add the domain (127.0.0.1 test.loc) to the end of the file:

```bash
sudo nano /etc/hosts
```
