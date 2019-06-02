# Preparación del proyecto 

## Instalación base de datos firebird:
- Installation: 
`apt-get install firebird2.5-superclassic`
- Configuration: 
`dpkg-reconfigure firebird2.5-superclassic`
- Install dev tools: 
`apt-get install firebird2.5-dev`
- Install sample: `firebird2.5-examples`    
- <b>review at /usr/share/doc/firebird2.5-examples/</b>
- Data location: `/var/lib/firebird/2.5/data/`
- Connection user: `firebird.firebird`
- Sample database: 
`connect "localhost:/var/lib/firebird/2.5/data/employee.fdb" user 'SYSDBA' password '{password}';`

### New sample database:
sudo chown firebird.firebird {database}.fdb
sudo mv {database}.fdb /var/lib/firebird/2.5/data/
isql-fb
connect "localhost:/var/lib/firebird/2.5/data/{databse}.fdb" user 'SYSDBA' password 'MASTERKEY’;
show tables;

### Creating database 
created shell script to copy every file in Bucket to the server:
may you should comment de database creation from principal script and execute the statement directly !
setting alias db, change `/etc/firebird/2.5/aliases.conf`, set a new record: 
```
Alef.fdb = /var/lib/firebird/2.5/data/Alef.fdb    
Alef = /var/lib/firebird/2.5/data/Alef.fdb    
```

Create a shell script to copy every bucket file into local server:

``` 
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/0 BD_FTC_Meta_v8.sql' .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/0.1 generadores a 0.SQL’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/1 Bancos_sat.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/11 UM.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/12 Roles.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/2 CLAVES_SAT.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/3 UNIDADES_SAT.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/4 TABLA DE CONTROL.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/5 precios01.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/6 PERIODOS_2016.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/7 MONED01.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/9 Usuario.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/coi_AUXILIAR_2019.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/coi_CUENTAS_2019sql.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/coi_CUENTAS_FTC.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/coi_FTC_CUENTAS_SAT.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/coi_FTC_PARAMETROS.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/coi_FTC_PARAM_COI.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/xml Limpiar Tablas.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/Semanas/Insertar Semanas.xlsx’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/Semanas/Semanas.sql’ .
gsutil cp -p 'gs://ftc-hosting/ftcenlinea/sat2app/Semanas/Semanas2019.sql’ .
```

Create another shell script to prepare the database and load data (one only execution)
```
for f in *.sql; do isql-fb -q -i "$f" Alef.fdb ; done
```

### Errores de la ejecución del script de carga:
```
Statement failed, 
SQLSTATE = 42S02
Dynamic SQL Error
- SQL error code = -204
- Table unknown
- CUENTAS18
- At line 25, column 10
At line 37 in file coi_CUENTAS_FTC.sql
Statement failed, SQLSTATE = 42000
unsuccessful metadata update
- Generator GEN_FTC_CUENTAS_SAT_ID already exists
After line 16 in file coi_FTC_CUENTAS_SAT.sql
Statement failed, SQLSTATE = 42S01
unsuccessful metadata update
- Table FTC_CUENTAS_SAT already exists
After line 34 in file coi_FTC_CUENTAS_SAT.sql
Statement failed, SQLSTATE = 42S11
unsuccessful metadata update
- Index PK_FTC_CUENTAS_SAT already exists
After line 56 in file coi_FTC_CUENTAS_SAT.sql
```

## Configuración Apache2
Prepare the apache2 to work with the application:
`sudo vim /etc/apache2/sites-available/{subdomain}.conf`
```
<VirtualHost *:80> 
    # The ServerName directive sets the request scheme, hostname and port that 
    # the server uses to identify itself. This is used when creating 
    # redirection URLs. In the context of virtual hosts, the ServerName 
    # specifies what hostname must appear in the request's Host: header to 
    # match this virtual host. For the default virtual host (this file) this 
    # value is not decisive as it is used as a last resort host regardless. 
    # However, you must set it for any further virtual host explicitly. 


    ServerName {subdomain} 
    # ServerAlias www.{subdomain} 
    ServerAdmin info@ftcenlinea.com 
    DocumentRoot /var/www/{subdomain-asis}/html 


    # Available loglevels: trace8, ..., trace1, debug, info, notice, warn, 
    # error, crit, alert, emerg. 
    # It is also possible to configure the loglevel for particular 
    # modules, e.g. 
    # LogLevel info ssl:warn 


    ErrorLog ${APACHE_LOG_DIR}/error.log 
    CustomLog ${APACHE_LOG_DIR}/access.log combined 


    # For most configuration files from conf-available/, which are 
    # enabled or disabled at a global level, it is possible to # include a line for only one particular virtual host. For example the 
    # following line enables the CGI configuration for this host only # after it has been globally disabled with "a2disconf". 

    #Include conf-available/serve-cgi-bin.conf
</VirtualHost>
```

## Crear el registro del subdominio
GO to your console-network and set a new cloud dns record (A - {subdoaim}) for subdomain register.

[After that] Ejecutar la instrucción que asocia el subdominio: 
`sudo a2ensite {subdomain}`

Finalmente reiniciar el apache2:
`sudo service apache2 restart`

En caso de haber un error al iniciar, verificar el estado a través de:
`sudo systemctl status apache2.service`

## Install php7.x

- set new lib repo for debian
```
echo 'deb http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list
echo 'deb-src http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list
```

- install the gig key to use repo:
```
cd /tmp
wget https://www.dotdeb.org/dotdeb.gpg
sudo apt-key add dotdeb.gpg
# verify the “OK” response, and remove key
rm dotdeb.gpg
``` 
- set package to install in a variable:
```
y = libapache2-mod-php7.0 php-pear php7.0 php7.0-cgi php7.0-cli php7.0-common php7.0-fpm php7.0-gd php7.0-json php7.0-mysql php7.0-readline
echo $y
sudo apt-get install $y

sudo a2enmod proxy_fcgi setenvif
sudo a2enconf php7.0-fpm
sudo service apache2 restart
```

- Now, it's time to execute a simple test:
`sudo vim /var/www/sat2app/html/index.php`

```
<?php 
    phpinfo();
?>
```

- for php7 management service:
`sudo systemctl [stop,start,restart,reload] php7.0-fpm.service`

- Setting up firebird - php
`sudo apt-get install php7-interbase`

- Change # to ; comments at: /etc/php5/mods-available/interbase.ini
```
sudo phpenmod interbase
sudo systemctl restart php7.0-fpm.service
sudo service apache2 restart
```

- Now, time to test the interbase interface
`sudo vim /var/www/sat2app/html/index.php`
```
<?php

$db = ‘localhost:Alef.fdb';
$username = 'SYSDBA';
$password = {password}';

// Connect to database:
$dbh = ibase_connect($db, $username, $password);
$sql = 'SELECT ID, USER_LOGIN, USER_PASS, USER_EMAIL, USER_REGISTRO, USER_STATUS, USER_ROL, LETRA, LETRA2 FROM PG_USERS';

// Execute query:
$rc = ibase_query($dbh, $sql);

// Get the result row by row as object
while ($row = ibase_fetch_object($rc)) {
  echo $row->email, "\n";
}

// Release the handle associated with the result of the query
ibase_free_result($rc);

// Release the handle associated with the connection
ibase_close($dbh);
?>
```