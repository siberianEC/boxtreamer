<?php 
header('Access-Control-Allow-Origin: *'); 
if(!(isset($_POST["nombre"]))){
	echo '[0,"Error, parametros incorrectos (nombre)"]';
	die;
}


// verificación de licencia  ********************************************
try {
	include "/var/www/html/app/core/mysql.php";
	$db = new Db();
	function getServerAddress() {
		if(isset($_SERVER["SERVER_ADDR"]))
		return $_SERVER["SERVER_ADDR"];
		else {
			$ifconfig = shell_exec('/sbin/ifconfig enp2s0');
			preg_match('/inet ([\d\.]+)/', $ifconfig, $match);
			return $match[1];
		}
	}
	$result=$db->select("SELECT nombre,datos FROM configuracion order by id");
	$url = 'http://10.11.5.37/licence.php';
	$data = array('licence' => $result[8]["datos"], 'ip' => getServerAddress());
	$options = array(
	'http' => array(
		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'method'  => 'POST',
		'content' => http_build_query($data)
	)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result!="1") { 
		shell_exec('sudo pkill play');
		echo 'Licencia no valida.';
		die;
	}
} catch (Exception $e) {
	shell_exec('sudo pkill play');
	echo 'Licencia no valida.';
	die;
}
// ***********************************************************************




$file=$_SERVER["DOCUMENT_ROOT"]."/assets/media/".$_POST["nombre"];


$result=$db->select("SELECT datos FROM configuracion WHERE id in (10,11)");

if($result[1]["datos"]==""){
$db->query("UPDATE configuracion SET datos = '".$file."' WHERE nombre = 'reproduciendo ahora'");

/*shell_exec('sudo pkill play &');
shell_exec('sudo sleep 1 ');
shell_exec('sudo amixer set PCM '.$result[0]["datos"].' &');
shell_exec('sudo rm /var/www/html/music.log &' );
shell_exec('sudo play -t mp3 '.$file.' > /var/www/html/music.log 2>&1');*/

$db = new Db();
$db->query("UPDATE configuracion SET datos = '' WHERE nombre = 'reproduciendo ahora'");	
shell_exec('sudo bash /var/www/html/app/sh/radio.sh '.$result[0]["datos"]." ".$file);


//shell_exec("nohup php ".$_SERVER["DOCUMENT_ROOT"]."/app/scripts/ReproducirArchivoAhoraBackGround.php ".$file." ".$result[0]["datos"]." &");
echo 'El audio se está reproduciendo.';
}else{
	echo 'Ya se está reproduciendo un audio, debe cancelar la reproducción.';
}

?>