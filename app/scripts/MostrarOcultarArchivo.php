<?php 
if(!(isset($_POST["nombre"]))){
	echo '[0,"Error, parametros incorrectos (nombre)"]';
	die;
}
include $_SERVER["DOCUMENT_ROOT"]."/app/core/core.php";
$db = new Db();

if($_POST["tipo"]=="ocultar"){
	if(count($db->select("SELECT id FROM archivos WHERE nombre = '".$_POST["nombre"]."'"))>0){
		if($db->query("UPDATE archivos SET estado = 2 WHERE nombre = '".$_POST["nombre"]."'")){
			echo 'El audio ahora no es visible.';
		}else{
			echo 'Error, al ocultar el audio (ingreso).';
		}
	}else{
		if($db->query("INSERT INTO archivos (nombre,estado) VALUES ('".$_POST["nombre"]."',2)")){
			echo 'El audio ahora no es visible.';
		}else{
			echo 'Error, al ocultar el audio (modificación).';
		}
	}
}else{
	if(count($db->select("SELECT id FROM archivos WHERE nombre = '".$_POST["nombre"]."'"))>0){
		if($db->query("UPDATE archivos SET estado = 1 WHERE nombre = '".$_POST["nombre"]."'")){
			echo 'El audio ahora es visible.';
		}else{
			echo 'Error, al mostrar el audio (ingreso).';
		}
	}else{
		if($db->query("INSERT INTO archivos (nombre,estado) VALUES ('".$_POST["nombre"]."',1)")){
			echo 'El audio ahora es visible.';
		}else{
			echo 'Error, al mostrar el audio (modificación).';
		}
	}
}


?>