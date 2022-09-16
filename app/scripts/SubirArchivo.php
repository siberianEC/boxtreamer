<?php


if($_FILES["fileToUpload"]["name"]==""){
    $upload = 5;
}else{
    $target_dir = "/var/www/html/assets/media/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $target_file = str_replace(" ", "", $target_file);
    $target_file = str_replace("(", "", $target_file);
    $target_file = str_replace(")", "", $target_file);
    $upload = 1;
    $FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if (file_exists($target_file)) {
        $upload = 2;
    }

    if(!(($FileType=="mp3")||($FileType=="ogg")||($FileType=="wav"))){
    	$upload = 4;
    }

    if ($upload == 1) {
       if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $upload = 1;
        } else {
            $upload = 0;
        } 

    }

}

header('Location: http://'.$_SERVER['SERVER_ADDR'].'/pages/archivos.php?resp='.$upload);
?>