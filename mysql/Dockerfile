FROM mysql:latest

COPY todos_table.sql /docker-entrypoint-initdb.d/01-todos.sql
COPY ./password-type.cnf /etc/mysql/conf.d/password-type.cnf
