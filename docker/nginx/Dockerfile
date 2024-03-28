FROM nginx:alpine3.18

WORKDIR /etc/nginx

RUN apk update && apk upgrade


# COPY BASIC CONF
COPY ./docker/nginx/nginx.conf /etc/nginx/
COPY ./docker/nginx/pomodoro.conf /etc/nginx/conf.d/

CMD ["nginx", "-g", "daemon off;"]