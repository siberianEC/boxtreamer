<?php
if(!(isset($_POST["id"]))){
  echo '[0,"Error, parametros incorrectos (id)"]';
  die;
}

include $_SERVER["DOCUMENT_ROOT"]."/app/core/core.php";
$db = new Db();

$sql = "SELECT id,prioridad,nombre,DATE_FORMAT(fecha_ini,'%Y-%m-%d') as fecha_ini,DATE_FORMAT(fecha_fin,'%Y-%m-%d') as fecha_fin,dias,DATE_FORMAT(fecha_ini,'%H:%i:%s') as hora_ini,DATE_FORMAT(fecha_fin,'%H:%i:%s') as hora_fin,volumen,repeticiones FROM programacion WHERE id = ".$_POST["id"];
$result=$db->select($sql);
echo json_encode($result[0]);

?>