<?php

//credenciales de la bd
define('DB_USUARIO', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');//checar host
define('DB_NOMBRE', 'proymdye');

$db = new mysqli(DB_HOST, DB_USUARIO, DB_PASSWORD, DB_NOMBRE, '3307');

//echo $db->ping();
