#!/bin/bash
# Copia nuestro config.authaz.php a config.php en cada arranque del contenedor
cp -f /var/www/html/config.php /var/www/html/config.php
exec apache2-foreground
