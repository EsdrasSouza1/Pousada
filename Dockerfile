# Pousada Barão — imagem PHP + Apache para deploy no Railway
FROM php:8.2-apache

# Extensão necessária para conectar no MySQL via PDO
RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite

# Copia o código da aplicação para o diretório servido pelo Apache
COPY . /var/www/html/

# Garante permissões corretas
RUN chown -R www-data:www-data /var/www/html

# Entrypoint ajusta a porta do Apache para a porta dinâmica do Railway ($PORT)
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
