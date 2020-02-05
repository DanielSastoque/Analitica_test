# Analitica_test

Consumo de un Web Service publicado como parte de un sistema de gestión documental.

Para crear la base de datos, a partir de la información obtenida desde el Web Service, ejecute el programa: 
<pre>
  <code>
    php get_data.php
  </code>
</pre>

Para generar los reportes requeridos (listado de la información obtenida y cantidad de archivos agrupados por tipo), en formato csv, ejecute el programa:
<pre>
  <code>
    php make_reports.php
  </code>
</pre>

Al terminar la ejecución, puede consultar los reportes: ``all_info_report.csv``, ``group_report.csv``.

Los requerimientos para el funcionamiento de estos programas, pueden ser instalados con:
<pre>
  <code>
    sudo apt-get install php7.3 libapache2-mod-php7.3 php7.3-cli php7.3-soap php7.3-sqlite3
  </code>
</pre>
