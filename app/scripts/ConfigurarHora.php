<?php 
$server="10.11.5.37";

$ctx = stream_context_create(array('http'=>array('timeout' => 3,)));
$date = @file_get_contents("http://".$server."/time.php", false, $ctx);
if($date === FALSE){
	$error = error_get_last();
	echo $error["message"];
}else{
	date_default_timezone_set('America/Guayaquil');
	$date_aux=date('Y-m-d H:i:s');

	$to_time = strtotime($date);
	$from_time = strtotime($date_aux);
	$time=round(abs($to_time - $from_time) / 60,2);
        error_log($time);
	if($time>5){
		$date = explode(" ", $date);
		shell_exec('sudo date +%Y-%m-%d -s "'.$date[0].'"');
		sleep(1);
		shell_exec('sudo date +%T -s "'.$date[1].'"');
		echo "ok";
	}else{
		echo "La hora ya se encuentra sincronizada.";
	}
}





?>
