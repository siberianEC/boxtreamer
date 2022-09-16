<?php

if(file_get_contents("/var/www/upgrade.zip")){
    unlink("/var/www/upgrade.zip");
}
if($_FILES["FileUpgrade"]["name"]==""){
    $upload = 5;
}else{

	if($_FILES["FileUpgrade"]["name"]!="upgrade.zip"){
		$upload = 8;
	}else{
		$target_dir = "/var/www/";
	    $target_file = $target_dir . basename($_FILES["FileUpgrade"]["name"]);
	    $target_file = str_replace(" ", "", $target_file);
	    $target_file = str_replace("(", "", $target_file);
	    $target_file = str_replace(")", "", $target_file);
	    $upload = 1;
	    $FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	    if (file_exists($target_file)) {
	        $upload = 2;
	    }

	    if(!($FileType=="zip")){
	        $upload = 4;
	    }

	    if ($upload == 1) {
	       if (move_uploaded_file($_FILES["FileUpgrade"]["tmp_name"], $target_file)) {
	            $upload = 1;
	        } else {
	            $upload = 0;
	        } 

	    }
	}

    

}

if($upload==1){
    $upload = shell_exec('sudo /var/www/html/app/sh/Upgrade.sh');
    header('Location: http://'.$_SERVER['SERVER_ADDR'].'/pages/archivos.php?resp='.$upload);
}else{
    header('Location: http://'.$_SERVER['SERVER_ADDR'].'/pages/archivos.php?resp='.$upload);
}
?>