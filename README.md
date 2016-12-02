# repair

Instalación

1) Clonar repositorio
2) Crear archivo app/config/parameters.yml y configurarlo
3) Ejecutar composer install
4) Crear base de datos
	4.1)php bin/console doctrine:schema:update --dump-sql (para ver sentencias SQL)
	4.2)php bin/console doctrine:schema:update --force (para ejecutar sentencias SQL)

5)php bin/console assets:install
6)php bin/console cache:clear (limpiar manualmente si es necesario)
7)Para envio de mails configurar modo
