# Pousada Barão — imagem PHP + Apache para deploy no Railway
FROM php:8.2-apache

# Corrige erro "More than one MPM loaded": desabilita mpm_event e mpm_worker,
# garante que apenas mpm_prefork (necessário para PHP) esteja ativo.
RUN a2dismod mpm_event mpm_worker 2>/dev/null || true \
    && a2enmod mpm_prefork

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
