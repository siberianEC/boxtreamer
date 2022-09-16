<?php 
if(!(isset($_POST["control"]))){
	echo '[0,"Error, parametros incorrectos (Control)"]';
	die;
}

shell_exec('sudo reboot now');

 ?>