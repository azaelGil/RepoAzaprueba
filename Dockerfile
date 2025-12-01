FROM alextselegidis/easyappointments:1.5.0

# Copiar configuración y script de inicio persistente
COPY config.authaz.php /var/www/html/config.authaz.php
COPY copy-authaz-config.sh /usr/local/bin/copy-authaz-config.sh

ENTRYPOINT ["/usr/local/bin/copy-authaz-config.sh"]
