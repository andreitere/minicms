# minicms

Configurare :

.htacces: RewriteBase /[folder daca e cazul]/
bit-admin/inc/functions.php 
    - $addr = adresa folder incluzand (sub)domeniul
    - $user = user;
	  - $pass = parola
	  - $host = adresa serverului mysql
	  - $database = numele baze de date

Dupa modificarea parametrilor de mai sus se va accesa $addr + /bit-admin/inc/setup.php

:)
