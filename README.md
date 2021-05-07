# [COSE451] Software Security GitCTF
# Ateen_Retflix
* Retflix = Review + Netflix   
* TV Programs / Movies Review Program   
* After you sign up and log in to Retflix webpage, you can search and select Netflix content, and read or leave reviews.   

## Table of Contents
* [Installation instructions](#installation)
* [Version check](#version)
* [Path information](#path)
* [Start server](#server)
* [DB](#db)


## <a name="installation"></a>Installation instructions
set_env.sh is made at the assumption of being executed at new VM.   
Therefore, if your VM has nginx, mysql or php7.0, some files can be overwritten.
```sh
$ git clone https://github.com/palisadeave/Ateen_Retflix.git
$ cd /PATH/TO/Ateen_Retflix/set_env.sh
$ sudo chmod +rwx set_env.sh
# this may take a while
$ sudo ./set_env.sh 
```
_while instaling, you have to enter password of mysql as "**ateen**"._

## <a name="version"></a>Version check
```sh
# This must show no errors after installation
$ nginx -v
> nginx version: nginx/1.20.0
$ php -v
> PHP 7.0.33-0ubuntu0.16.04.16 (cli) ( NTS )
$ mysql --version
> mysql  Ver 14.14 Distrib 5.7.33
```
_Then you can find our Retflix page at **http://localhost/**._

## <a name="path"></a>Path information
> html: /usr/share/nginx/html   
> css: /usr/share/nginx/css   
> default.conf: /etc/nginx/conf.d       
> www.conf: /etc/php/7.0/fpm/pool.d    
> php.ini: /etc/php/7.0/fpm       

## <a name="server"></a>Start server
If something is strange, restarting the server or erasing the cache of Firefox can be solutions.
```sh
$ cd /usr/share/nginx/
$ sudo service nginx start
$ sudo service php7.0-fpm restart
    
# To restart
$ sudo service nginx restart
$ sudo service php7.0-fpm restart
```

## <a name="db"></a>DB
> localhost   
> user: root   
> pw: ateen

```sh
# If mysql configuration fails, please execute these commands.
$ cd /PATH/TO/MySQL/retflix.sql
$ mysql -u root -pateen
mysql> create database retflix;
mysql> use reflix;
mysql> source ./retflix.sql;
```
