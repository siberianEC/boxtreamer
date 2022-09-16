<?php 
if(!(isset($_POST["nombre"]))){
	echo '[0,"Error, parametros incorrectos (nombre)"]';
	die;
}
include $_SERVER["DOCUMENT_ROOT"]."/app/core/core.php";
$db = new Db();


if(count($db->select("SELECT id FROM archivos WHERE nombre = '".$_POST["nombre"]."'"))>0){
	if($db->query("UPDATE archivos SET descripcion = '".$_POST["descripcion"]."' WHERE nombre = '".$_POST["nombre"]."'")){
		echo 'Se editó el nombre del audio.';
	}else{
		echo 'Error, al editar el nombre el audio (modificación).';
	}
}else{
	if($db->query("INSERT INTO archivos (nombre,estado,descripcion) VALUES ('".$_POST["nombre"]."',1,'".$_POST["descripcion"]."')")){
		echo 'Se editó el nombre del audio.';
	}else{
		echo 'Error, al editar el nombre el audio (ingreso).';
	}
}


?>