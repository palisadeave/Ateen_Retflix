# Name: set_env.sh
# Description: Install nginx, mysql, php and set configurations

sudo apt-get update -y
sudo apt-get upgrade -y
sudo apt-get dist-upgrade -y

echo "--------nginx installation start--------"
sudo apt install curl gnupg2 ca-certificates lsb-release -y
echo "deb http://nginx.org/packages/ubuntu `lsb_release -cs` nginx" | sudo tee /etc/apt/sources.list.d/nginx.list
FILE=/etc/apt/preferences.d/99nginx
echo "Package: *" | sudo tee $FILE
echo "Pin: origin nginx.org" | sudo tee -a $FILE
echo "Pin: release o=nginx" | sudo tee -a $FILE
echo "Pin-Priority: 900" | sudo tee -a $FILE
cat $FILE
curl -o /tmp/nginx_signing.key https://nginx.org/keys/nginx_signing.key
gpg --with-fingerprint /tmp/nginx_signing.key
sudo mv /tmp/nginx_signing.key /etc/apt/trusted.gpg.d/nginx_signing.asc
sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys ABF5BD827BD9BF62
sudo apt update -y
sudo apt install nginx

echo "--------nginx installation end--------"
nginx -v

echo "--------mysql installation start--------"
sudo apt-get -y install mysql-server mysql-client
echo "--------mysql installation end--------"

echo "--------php installation start--------"
sudo apt-get -y install php7.0-fpm php-mysql php7.0-curl
echo "--------php installation end--------"

echo "--------nginx configuration start--------"
NGINX_DIR=/etc/nginx
NGINX_CONFIG=$NGINX_DIR/conf.d
NGINX_SRC_DIR=/usr/share/nginx
NGINX_HTML_DIR=$NGINX_SRC_DIR/html
NGINX_CSS_DIR=$NGINX_SRC_DIR/css
PHP_DIR=/etc/php/7.0/fpm

if [ ! -d "$NGINX_CONFIG" ]; then
        echo "No such directory $NGINX_CONFIG"
        exit 1
fi

if [ ! -d "$PHP_DIR" ]; then
        echo "No such directory $NGINX_PHP_DIR"
        exit 1
fi
cp ./nginx/default.conf $NGINX_CONFIG
cp ./nginx/www.conf $PHP_DIR/pool.d
cp ./nginx/php.ini $PHP_DIR

cp -r ./html $NGINX_SRC_DIR
cp -r ./css $NGINX_SRC_DIR
chmod -R 777 $NGINX_HTML_DIR
chmod -R 777 $NGINX_CSS_DIR
ln -s $NGINX_HTML_DIR/searchResult.json $NGINX_HTML_DIR/SEARCH

echo "--------nginx configuration end--------"

echo "--------mysql configuration start--------"
mysql -u root -pateen < ./MySQL/create_db.sql;
mysql -u root -pateen retflix < ./MySQL/retflix.sql;
echo "--------mysql configuration end--------"

echo "--------nginx php start--------"
NGINX_CMD="sudo service nginx"
PHP_CMD="sudo service php7.0-fpm"

$NGINX_CMD start
$PHP_CMD start
$NGINX_CMD restart
$PHP_CMD restart
echo "Please check your localhost in Firefox"
echo "How to restart"
echo "NGINX: $NGINX_CMD restart"
echo "PHP: $PHP_CMD restart"
