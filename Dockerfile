FROM php:8.4-apache

# Povolit Apache mod_rewrite
RUN a2enmod rewrite

# Nastavit DocumentRoot na Symfony "public"
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Přepsat defaultní Apache config
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Ujisti se, že Composer je nainstalovaný (volitelné, ale praktické)
RUN apt-get update && apt-get install -y git unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
