<?php 

if(!((isset($_POST["ip_address"]))&&(isset($_POST["ip_gateway"])))){
	echo '[0,"Error, parametros incorrectos"]';
	die;
}


if(!(ip2long($_POST["ip_gateway"]) !== false)){
	echo 'La dirección gateway es inválida';die;
}

include $_SERVER["DOCUMENT_ROOT"]."/app/core/core.php";
$db = new Db();

$db->query("UPDATE configuracion SET datos = '".$_POST["ip_address"]."' WHERE nombre = 'ip_address'");
$db->query("UPDATE configuracion SET datos = '".$_POST["ip_gateway"]."' WHERE nombre = 'ip_gateway'");
shell_exec('sudo bash /var/www/html/app/sh/ChangeIp.sh 0 '.$_POST["ip_address"]." ".$_POST["ip_gateway"]);

echo "Se cambió la IP con éxito, para que el cambio tenga efecto debe reiniciar el equipo."
?>