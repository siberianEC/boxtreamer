<?php 
if(file_exists('/var/www/html/music.log')){
	$data=file_get_contents('/var/www/html/music.log');
	$data_aux1=explode("\n", $data);

	$data_aux2="";
	for($i=10;$i<sizeof($data_aux1);$i++){
		$data_aux2.=$data_aux1[$i];
	}
	$data_aux2=explode("\r", $data_aux2);

	$datos='["'.trim($data_aux1[1]).'","'.trim($data_aux1[3]).'","'.trim($data_aux1[4]).'","'.trim($data_aux1[5]).'","'.trim($data_aux1[6]).'","'.trim($data_aux1[8]).'",';
	for($i=30;$i>0;$i--){
		@$data_aux=trim($data_aux2[count($data_aux2)-$i]);
		@$data_aux=explode("[", $data_aux);
		@$data_aux=explode("]", $data_aux[2]);
		@$data_aux=$data_aux[0];
		@$datos.='"'.$data_aux.'",';
		
	}
	$datos=substr($datos, 0, -1);
	echo $datos.="]";
}
?>