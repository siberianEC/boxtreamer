<?php 
include "/var/www/html/app/core/mysql.php";
$db = new Db();
$db->query("UPDATE configuracion SET datos = '' WHERE nombre = 'reproduciendo ahora'");	
shell_exec('sudo bash /var/www/html/app/sh/radio.sh '.$argv[2]." ".$argv[1]);

?>