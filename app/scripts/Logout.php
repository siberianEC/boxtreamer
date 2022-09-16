<?php 
if(!(isset($_POST["control"]))){
	echo '[0,"Error, parametros incorrectos (Control)"]';
	die;
}
session_start();
// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 
echo "ok";

 ?>