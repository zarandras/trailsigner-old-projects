<?php

define('MYSQL_USER', 'modras');
define('MYSQL_PASS', 'Iecha2ae');
define('MYSQL_HOST', ':/var/run/mysqld/mysqld.sock');
define('MYSQL_DB',   'modras');

$link = mysql_connect (MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
mysql_select_db (MYSQL_DB, $link);
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_hungarian_ci'", $link);

header('Content-type: text/html; charset=utf-8');

?>
