FROM nginx:1.10
WORKDIR /var/www
ADD config/docker/vhost.conf /etc/nginx/conf.d/default.conf