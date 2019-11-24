#!/bin/sh
# wait-for-mysql.sh

set -e

host="$1"
shift
cmd="$@"

until nc -z ${host} 3306; do
  >&2 echo "Mysql is unavailable - sleeping $host"
  >&2 echo ${host}" 3306;"
  sleep 3
done

>&2 echo "Mysql is up - executing Server"
exec $cmd