<?php 
header('Access-Control-Allow-Origin: *'); 



if(!(isset($_POST["nombre"]))){
	echo '[0,"Error, parametros incorrectos (nombre)"]';
	die;
}

include $_SERVER["DOCUMENT_ROOT"]."/app/core/core.php";
$db = new Db();

$IdAudio=$_POST["IdAudio"];
$nombre=$_POST["nombre"];
$dias=$_POST["dias"];
$hora_ini=$_POST["hora_ini"];
$volumen=$_POST["volumen"];
$prioridad=$_POST["prioridad"];

if(@$_POST["cboxRepeticiones"]=='on'){
	$repeticiones='999999999';
}else{
	$repeticiones=$_POST["repeticiones"];
}

if(@$_POST["cboxFechaIni"]=='on'){
	$fecha_ini=$_POST["fecha_ini"];
}else{
	$fecha_ini='1996-08-23';
}

if(@$_POST["cboxFechaFin"]=='on'){
	$fecha_fin=$_POST["fecha_fin"];
}else{
	$fecha_fin='2996-08-23';
}

if(@$_POST["cboxHoraFin"]=='on'){
	$hora_fin=$_POST["hora_fin"];
}else{
	$hora_fin='23:59:57';
}


if(!(is_numeric($repeticiones)))$repeticiones=0;
if($repeticiones<1)$repeticiones=0;

if(!(is_numeric($volumen)))$volumen=80;

if($volumen<0)$volumen=0;

if(!(is_numeric($prioridad)))$prioridad=1;
if($prioridad<1)$prioridad=1;

$fecha_ini_dt = new DateTime($fecha_ini);
$fecha_fin_dt = new DateTime($fecha_fin);


if ($fecha_fin_dt < $fecha_ini_dt) { 
	echo "Error, la fecha de finalizar debe ser mayor que la fecha de inicio.";
	die;
}

if($fecha_ini==$fecha_fin){
	if (strtotime($hora_fin) <= strtotime($hora_ini)) {
	  echo "Error, la hora de finalizar debe ser mayor que la hora de inicio.";
	  die;
	}
}

$fecha_ini.=" ".$hora_ini;
$fecha_fin.=" ".$hora_fin;


$ruta_audio="";
if (!(strpos(strtolower($nombre), 'http') !== false)){
	$ruta_audio=$_SERVER["DOCUMENT_ROOT"]."/assets/media/";
	if(!(file_exists($_SERVER["DOCUMENT_ROOT"]."/assets/media/".$nombre))){
		echo 'Error, el audio no existe primero debe ingresar el archivo.';
		die;
	}
}

/*$audio=shell_exec('SUDO_ASKPASS=/usr/bin/ssh-askpass sudo /var/www/html/app/sh/GetMediaInfo.sh &'.$ruta_audio.$nombre);
if (!(strpos($audio, 'duration') !== false)) {
	echo 'Error, el audio no es válido';
	die;
}*/

if(isset($_POST["OrderByMaster"])){
	$OrderByMaster=1;
}else{
	$OrderByMaster=0;
}


$query="SELECT id
FROM programacion
WHERE (DATE_FORMAT('".$fecha_ini."','%Y-%m-%d') BETWEEN DATE_FORMAT(fecha_ini,'%Y-%m-%d') AND DATE_FORMAT(fecha_fin,'%Y-%m-%d')
OR DATE_FORMAT('".$fecha_fin."','%Y-%m-%d') BETWEEN DATE_FORMAT(fecha_ini,'%Y-%m-%d') AND DATE_FORMAT(fecha_fin,'%Y-%m-%d'))
and (CAST(DATE_FORMAT(fecha_ini,'%H:%i:%s') AS TIME) < CAST('".$hora_ini."' AS time) AND CAST(DATE_FORMAT(fecha_fin,'%H:%i:%s') AS TIME)  > CAST('".$hora_ini."' AS time)
OR CAST(DATE_FORMAT(fecha_ini,'%H:%i:%s') AS TIME) < CAST('".$hora_fin."' AS time) AND CAST(DATE_FORMAT(fecha_fin,'%H:%i:%s') AS TIME)  > CAST('".$hora_fin."' AS time))";

$result=$db->select($query);
if($IdAudio==""){
	$sql="INSERT INTO programacion (prioridad,nombre,dias,fecha_ini,fecha_fin,repeticiones,volumen,OrderByMaster) VALUES
	($prioridad,'$nombre','$dias','$fecha_ini','$fecha_fin','$repeticiones','$volumen',$OrderByMaster)";
	if($db->query($sql)){
		if(count($result)>0){
			echo '[1,"Advertencia, está ingresando un audio/stream que coincide con otro ingresado con anterioridad, por favor revisar la programación."]';
		}else{
			echo '[1,"La programación se ingresó con éxito."]';
		}
	}else{
		echo '[0,"Error, al ingresar la programación."]';
	}
}else{
	$sql="UPDATE programacion SET prioridad = '$prioridad',nombre = '$nombre',fecha_ini = '$fecha_ini', fecha_fin = '$fecha_fin', dias = '$dias', repeticiones = '$repeticiones', volumen = '$volumen', estado = 1 WHERE id = $IdAudio";
	if($db->query($sql)){
		if(count($result)>0){
			echo '[1,"Advertencia, está ingresando un audio/stream que coincide con otro ingresado con anterioridad, por favor revisar la programación."]';
		}else{
			echo '[1,"La programación se editó con éxito."]';
		}
	}else{
		echo '[0,"La programación no pudo ser editada."]';
	}
}
?>