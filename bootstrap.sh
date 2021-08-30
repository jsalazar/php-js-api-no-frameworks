#!/usr/bin/env bash

apt-get update

# INSTALL OUR STACK: Apache2, MariaDB (latest), PHP7.4 on Ubuntu 20.04
apt-get install -y apache2 mariadb-server php libapache2-mod-php php-mysql

# CONFIGURE APACHE
cp /vagrant/tmp/development.conf /etc/apache2/sites-available/development.conf
a2ensite development.conf
a2dissite 000-default.conf 
# echo "<?php phpinfo(); ?>" > /var/www/html/info.php
systemctl reload apache2
# enable mod rewrite on apache
sudo a2enmod rewrite
# update apache config
cp /vagrant/tmp/apache2.conf /etc/apache2/apache2.conf
# restart apache 
sudo systemctl restart apache2

# CREATE DB, USER, TABLE, and INSERT RECORDS
echo "create database development" | mariadb 
echo "CREATE USER 'development'@'localhost' IDENTIFIED BY 'development'" | mariadb 
echo "GRANT ALL PRIVILEGES ON *.* TO 'development'@'localhost';" | mariadb 
echo "flush privileges" | mariadb 
# create test table
mariadb < /vagrant/tmp/create-table.sql
# insert test records
mariadb < /vagrant/tmp/insert-records.sql 

# INSTALL COMPOSER - INSTRUCTIONS: https://getcomposer.org/download/
# php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
# php composer-setup.php --install-dir=/var/www/html
# php -r "unlink('composer-setup.php');"
