FROM debian
ENV app /user/local
WORKDIR ${app}

RUN apt-get update && apt-get -y install ssh wget git iputils-ping cron vim apache2 php php-zip php-mbstring php-xml php-pgsql php-curl php-gd && apt-get -y autoremove && apt-get clean && rm -rf /var/lib/apt/lists/* && a2enmod ssl && a2enmod rewrite
RUN wget https://getcomposer.org/composer.phar && chmod u+x composer.phar && mv composer.phar /usr/local/bin/composer

RUN mkdir ec_aprendizaje
#RUN cd ${app}/ec_aprendizaje && git checkout dev && composer install && composer dump-autoload && composer run-script post-root-package-install && chown www-data:www-data ./ -R && chmod 755 storage -R
RUN cd ..

RUN cd /etc/apache2/sites-available && tar czf bkp.tar.gz *.conf && rm *.conf
COPY *.conf /etc/apache2/sites-available/
RUN cd /etc/apache2/sites-enabled && rm *.conf && ln -s ../sites-available/traducciones.conf


EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

