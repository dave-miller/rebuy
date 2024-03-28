FROM mariadb:10.3

MAINTAINER Mahmoud Zalt <mahmoud@zalt.me>

ADD ./docker/mariadb/my.cnf /etc/mysql/conf.d/my.cnf

RUN apt-get update

# Define environment variables for MariaDB configuration
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_USER=app
ENV MYSQL_PASSWORD=app_password

# Grant access to all databases
RUN echo "GRANT ALL PRIVILEGES ON *.* TO 'app'@'%' IDENTIFIED BY 'app_password';" > /docker-entrypoint-initdb.d/grant_permissions.sql

CMD ["mysqld"]

EXPOSE 3306
