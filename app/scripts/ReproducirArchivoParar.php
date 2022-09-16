<?php 
header('Access-Control-Allow-Origin: *'); 

include "/var/www/html/app/core/mysql.php";
$db = new Db();
$result=$db->select("SELECT datos FROM configuracion WHERE nombre = 'reproduciendo ahora'");
if($result[0]["datos"]!=""){
	shell_exec("sudo pkill play");
$db->query("UPDATE configuracion SET datos = '' WHERE nombre = 'reproduciendo ahora'");	

echo 'Éxito se terminó la reproducción del audio.';
}else{
	echo 'Actualmente no se está reproduciendo ningún audio.';
}
?>