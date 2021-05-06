# Ateen_Retflix

## Table of Contents
* [Installation instructions] (#Installation instructions)
* [PATH information] (#PATH information)
* [Version] (#Version check)
* [DB] (#DB)

## Installation instructions
```sh
cd /PATH/TO/set_env.sh
sudo chmod +rwx set_env.sh
# this may take a while
sudo ./set_env.sh 
```
# Grant permission
```sh
sudo chmod +rwx (BLANK)
```

## PATH information
> html: /usr/share/nginx/html   
> css: /usr/share/nginx/css   
> default.conf: /etc/nginx/conf.d       
> www.conf: /etc/php/7.0/fpm/pool.d    
> php.ini: /etc/php/7.0/fpm   
> (sudo apt-get install php7.0-curl)    
> register: /usr/share/nginx/html   
> signin: /usr/share/nginx/html   

## Version check
```sh
# This must show no errors
nginx -v
php -v
mysql -v
```

## DB
> localhost   
> user: root   
> pw: ateen

```sh
cd /PATH/TO/mysql
mysql -u root -p
create database retflix;
use reflix;
source ./retflix.sql
```

## Start server
```sh
cd /usr/share/nginx/
sudo service nginx start
sudo service php7.0-fpm restart
```

