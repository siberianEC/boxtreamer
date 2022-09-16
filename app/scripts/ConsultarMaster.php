
<?php 
header('Access-Control-Allow-Origin: *'); 
if(!(isset($_POST["control"]))){
	echo '[0,"Error, parametros incorrectos (control)"]';
	die;
}

$name=trim(shell_exec("ps -e -o command | grep play | grep -v grep"));
$name=trim(str_replace("play", "", $name));
$name=str_replace(" repeat 999999999", "", $name);
$name=str_replace(" repeat", "", $name);

if($name==""){
	$status="STAND-BY";
	$color="#000000";
}else{
	$status="PLAYING";
	$color="#dcf7e5";
}

if ((strpos(strtolower($name), 'http://') !== false)||(strpos(strtolower($name), 'https://') !== false)) {
    $tipo="Streaming Audio";
}else{
	$tipo="Archivo mp3";
}

$volumen = trim(shell_exec('sudo '.$_SERVER["DOCUMENT_ROOT"].'/app/sh/GetVolume.sh'));
$volumen = str_replace("%","",$volumen);


$temp=trim(shell_exec("sudo /opt/vc/bin/vcgencmd measure_temp"));
$temp= str_replace("temp=","",$temp);
$hora=trim(shell_exec("date"));
echo '["'.$status.'","'.$color.'","'.$tipo.'","'.$name.'","'.$volumen.'","'.$temp.'","'.$hora.'"]';

?>
