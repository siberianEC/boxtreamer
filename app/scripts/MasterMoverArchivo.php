<?php 


$remote_file_url = $_POST["ruta"].$_POST["archivo"];



/* New file name and path for this file */
$local_file = "/var/www/html/assets/media/".$_POST["archivo"];
 
if(file_exists($local_file)){
	echo "ok";
}else{
	/* Copy the file from source url to server */
	$copy = copy($remote_file_url, $local_file );
	 
	/* Add notice for success/failure */
	if( !$copy ) {
	    echo "Error al copiar archivo, revise si existe: ".$remote_file_url;
	}
	else{
	    echo "ok";
	}
}


 ?>