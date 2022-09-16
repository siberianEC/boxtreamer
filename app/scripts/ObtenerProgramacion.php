<?php
include $_SERVER["DOCUMENT_ROOT"]."/app/core/core.php";
$db = new Db();

    $sql = "SELECT id,prioridad,nombre,Replace(DATE_FORMAT(fecha_ini,'%Y-%m-%d'),'1996-08-23','-') as fecha_ini,Replace(DATE_FORMAT(fecha_fin,'%Y-%m-%d'),'2996-08-23','-') as fecha_fin,dias,DATE_FORMAT(fecha_ini,'%H:%i:%s') as hora_ini,Replace(DATE_FORMAT(fecha_fin,'%H:%i:%s'),'23:59:57','-') as hora_fin,volumen,Replace(repeticiones,'999999999','Loop') as repeticiones,estado FROM programacion WHERE estado in (1,2,3)";
    $data = array();
    foreach ($db->select($sql) as $key => $value) {
    $dias=str_replace('0', 'Todos', $value["dias"]);
    $dias=str_replace('1', 'Lunes', $dias);
    $dias=str_replace('2', 'Martes', $dias);
    $dias=str_replace('3', 'Miércoles', $dias);
    $dias=str_replace('4', 'Jueves', $dias);
    $dias=str_replace('5', 'Viernes', $dias);
    $dias=str_replace('6', 'Sábado', $dias);
    $dias=str_replace('7', 'Domingo', $dias);


    $data[] = array(
      "prioridad" => $value["prioridad"],
      "nombre" => $value["nombre"],
      "fecha_ini" => $value["fecha_ini"],
      "fecha_fin" => $value["fecha_fin"],
      "dias" => $dias,
      "hora_ini" => $value["hora_ini"],
      "hora_fin" => $value["hora_fin"],
      "volumen" => $value["volumen"],
      "repeticiones" => $value["repeticiones"],
      "opciones" => $value["id"],
      "estado" => $value["estado"]
      );
  }
    echo json_encode($data);

?>