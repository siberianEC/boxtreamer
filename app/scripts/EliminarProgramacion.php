<?php 
if(!(isset($_POST["id"]))){
	echo '[0,"Error, parametros incorrectos (id)"]';
	die;
}
include $_SERVER["DOCUMENT_ROOT"]."/app/core/core.php";
$db = new Db();


if($db->query("UPDATE programacion SET estado = 0 WHERE id = ".$_POST["id"])){
	echo 'La programación se eliminó con éxito.';
}else{
	echo 'La programación no pudo ser eliminada.';
}

?>