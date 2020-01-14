FROM nginx:1.17.6

ADD vhost.conf /etc/nginx/conf.d/default.conf
