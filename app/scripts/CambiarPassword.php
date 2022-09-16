<?php 
if(!(isset($_POST["password"]))){
	echo '[0,"Error, parametros incorrectos (password)"]';
	die;
}
include $_SERVER["DOCUMENT_ROOT"]."/app/core/core.php";
$db = new Db();


if($db->query("UPDATE user SET pass = '".sha1($_POST["password"])."' WHERE id = 1")){
	echo 'La contraseña de modificó con éxito.';
}else{
	echo 'Error, la contraseña no pudo ser modificada.';
}

?>