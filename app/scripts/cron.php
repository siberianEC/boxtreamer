<?php 
date_default_timezone_set('America/Guayaquil');

include "/var/www/html/app/core/mysql.php";
$db = new Db();


// VERIFICACION DE LICENCIA ********************************************
// cada 5 segundos verifica en caso de no estar autorizada
// cada 5 minutos verifica en caso de estar autorizada
	$validar_licencia=true;
	if(file_exists("/var/www/html/.licence.lock")){
		$d1=strtotime(file_get_contents("/var/www/html/.licence.lock"));
		$d2=strtotime(date("Y-m-d H:i:s"));
		if(abs($d2-$d1)>300){//Si es mayor a 5 minutos (300) borramos el arhivo y continuamos
			unlink("/var/www/html/.licence.lock");//eliminamos el archivo lock
		}else{
			$validar_licencia=false;
		}
	}
	if ($validar_licencia) {
		try {
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
				'content' => http_build_query($data),
				'timeout' => 3
			)
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);			
			if ($result!="1") { 
				$dia_semana=date('N');
				$fecha_aux1=date("Y-m-d");
				$fecha_aux2=date("H:i:s");
				file_put_contents("/var/www/html/.baneado.lock", $fecha_aux1." ".$fecha_aux2);//creamos el archivo lock
				shell_exec('sudo pkill play');
				die;
			}else{
				unlink("/var/www/html/.baneado.lock");//eliminamos el archivo lock
			}
		} catch (\Throwable $th) {
			$dia_semana=date('N');
			$fecha_aux1=date("Y-m-d");
			$fecha_aux2=date("H:i:s");
			file_put_contents("/var/www/html/.baneado.lock", $fecha_aux1." ".$fecha_aux2);//creamos el archivo lock
			shell_exec('sudo pkill play');
			die;
		}
		$fecha_aux1=date("Y-m-d");
		$fecha_aux2=date("H:i:s");
		file_put_contents("/var/www/html/.licence.lock", $fecha_aux1." ".$fecha_aux2);//creamos el archivo lock
	}
// ***********************************************************************




$control=true;
if(file_exists("/var/www/html/.baneado.lock")){
	$control=false;
}


if ($control) {//se ejecuta cuando no se este ejecutando otro archivo
	$dia_semana=date('N');
	$fecha_aux1=date("Y-m-d");
	$fecha_aux2=date("H:i:s");
	file_put_contents("/var/www/html/.boxtreamer.lock", $fecha_aux1." ".$fecha_aux2);//creamos el archivo lock

	//shell_exec('sudo /var/www/html/app/sh/ComprobarHilosMuertos.sh');//Matamos los hilos muertos
	
	

	$result=$db->select("SELECT datos FROM configuracion WHERE nombre = 'reproduciendo ahora'");
	$reproduciendo_ahora=$result[0]["datos"];
	$query="SELECT id,
	IF(LOCATE('http://',nombre) OR LOCATE('https://',nombre), 
	nombre, 
	CONCAT((SELECT datos FROM configuracion WHERE nombre = 'ruta'),nombre)) as ruta,
	volumen,nombre,repeticiones 
	from programacion 
	where DATE_FORMAT('".$fecha_aux1."','%Y-%m-%d') BETWEEN DATE_FORMAT(fecha_ini,'%Y-%m-%d') and DATE_FORMAT(fecha_fin,'%Y-%m-%d')
	and  CAST(DATE_FORMAT(fecha_ini,'%H:%i:%s') AS TIME) < CAST('".$fecha_aux2."' AS time) AND CAST(DATE_FORMAT(fecha_fin,'%H:%i:%s') AS TIME)  > CAST('".$fecha_aux2."' AS time)
	and (dias LIKE '%".$dia_semana."%' OR dias LIKE '%0%')
	and (estado = 1 OR (estado = 2 and DATE_FORMAT(fecha,'%Y-%m-%d') != DATE_FORMAT(now(),'%Y-%m-%d')))
	order by OrderByMaster desc,prioridad";

	$result=$db->select($query);
	if(count($result)>0){//Publicidad
		$name=trim(shell_exec("ps -e -o command | grep play | grep -v grep"));
		foreach ($result as $key => $value) {
			if (!(strpos($name, substr($value["ruta"], 0, -1)) !== false)) {
				if ((strpos($name, $reproduciendo_ahora) !== false)) {
					$control=true;
					/*if (strpos($value["ruta"], 'http') !== false) {
						if(trim(shell_exec("sudo ethtool eth0 | grep Link\ d"))!="Link detected: yes"){//Si no hay conexion no tomamos en cuenta los enlaces web ya que demora mucho verificar el audio de los mismos
							$control=false;
						}
					}*/

					if($control){//Si es un archivo sin http o si es enlace y hay conexion, verificamos que sea un audio
							if (strpos($value["ruta"], 'http') !== false) {
								// valir si esta sonando el voceo
								$name=trim(shell_exec("ps -e -o command | grep play | grep -v grep"));
								if ((strpos($name, 'mp3') !== false)) {
									break;
								}
								shell_exec('sudo  bash /var/www/html/app/sh/radio.sh '.$value["volumen"]." ".$value["ruta"]);
								if(file_exists('/var/www/html/music.log')){
									unlink('/var/www/html/music.log');
								}
								if($value["repeticiones"]!='999999999'){
									$db->query("UPDATE programacion SET estado = 2,fecha = now() WHERE id = ".$value["id"]);
								}
								//shell_exec("nohup php /var/www/html/app/scripts/cronBackGround.php 0 ".$value["volumen"]." ".$value["ruta"]." ".$value["repeticiones"]." ".$value["id"]." > /dev/null 2>&1 &");
							}else{
								//shell_exec("nohup php /var/www/html/app/scripts/cronBackGround.php 1 ".$value["volumen"]." ".$value["ruta"]." ".$value["repeticiones"]." ".$value["id"]." > /dev/null 2>&1 &");
							}
							break;//Si el archivo es un audio no es necesario pedir el siguiente archivo
					}
				}
			}else{
				break;//Si encuentra que la musica ya se esta reproduciendo termina el bucle
			}
		}	
	}else{
		//shell_exec("sudo pkill play");
		//shell_exec("php /var/www/html/app/scripts/ConfigurarHora.php");
	}
	unlink("/var/www/html/.boxtreamer.lock");//eliminamos el archivo lock
}
?>
