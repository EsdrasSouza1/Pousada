#!/bin/sh
set -e

# Railway injeta a porta em $PORT. Apache, por padrão, escuta na 80.
# Ajustamos a porta de escuta para o valor fornecido (fallback: 80).
PORT="${PORT:-80}"

sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

exec "$@"
