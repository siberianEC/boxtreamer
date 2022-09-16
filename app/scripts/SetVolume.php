<?php 
if(!(isset($_POST["volumen"]))){
	echo '[0,"Error, parametros incorrectos (Volumen)"]';
	die;
}
include $_SERVER["DOCUMENT_ROOT"]."/app/core/core.php";
$db = new Db();
$db->query("UPDATE configuracion SET datos = ".$_POST["volumen"]." WHERE nombre = 'volumen'");
//shell_exec('sudo '.$_SERVER["DOCUMENT_ROOT"].'/app/sh/SetVolume.sh '.$_POST["volumen"]);
echo "El volumen se configuró correctamente a ".$_POST["volumen"]."%";
 ?>