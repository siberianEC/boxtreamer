<?php
include "/var/www/html/app/core/mysql.php";
$db = new Db(); 
if($argv[1]=="1"){
	shell_exec('sudo /var/www/html/app/sh/radio.sh '.$argv[2]." ".$argv[3]." repeat ".$argv[4]);
}else{
	shell_exec('sudo /var/www/html/app/sh/radio.sh '.$argv[2]." ".$argv[3]);
}

if(file_exists('/var/www/html/music.log')){
	unlink('/var/www/html/music.log');
}
if($argv[4]!='999999999'){
	$db->query("UPDATE programacion SET estado = 2,fecha = now() WHERE id = ".$argv[5]);
}

?>