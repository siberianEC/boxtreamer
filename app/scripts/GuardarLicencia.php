<?php 

if(!((isset($_POST["licencia"])))){
	echo '[0,"Error, parametros incorrectos"]';
	die;
}


include $_SERVER["DOCUMENT_ROOT"]."/app/core/core.php";
$db = new Db();

$db->query("UPDATE configuracion SET datos = '".$_POST["licencia"]."' WHERE nombre = 'licencia'");




echo "Se cambió la licencia con éxito."
?>