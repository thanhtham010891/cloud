FROM mysql:5.7

COPY ./my.cnf /etc/mysql/my.cnf
RUN chmod -R 775 /docker-entrypoint-initdb.d
