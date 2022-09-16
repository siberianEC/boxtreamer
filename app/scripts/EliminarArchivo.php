<?php 
header('Access-Control-Allow-Origin: *'); 
if(!(isset($_POST["nombre"]))){
	echo '[0,"Error, parametros incorrectos (nombre)"]';
	die;
}

$file=$_SERVER["DOCUMENT_ROOT"]."/assets/media/".$_POST["nombre"];

if (!unlink($file))
  {
  echo ("Error al eliminar el archivo.");
  }
else
  {
  echo ("El archivo se eliminó con éxito.");
  }
?>