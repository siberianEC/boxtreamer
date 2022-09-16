<?php 
if(!((isset($_POST["user"]))&&(isset($_POST["pass"])))) {
	echo '[0,"Error, parametros incorrectos"]';
	die;
}

include $_SERVER["DOCUMENT_ROOT"]."/app/core/core.php";
$db = new Db();

$user=$_POST["user"];
$pass=$_POST["pass"];

$result=$db->select("SELECT id,tipo FROM user WHERE user = '$user' AND pass = '".sha1($pass)."'");
if(count($result)>0){
	$_SESSION["id"]=$result[0]["id"];
	$_SESSION["tipo"]=$result[0]["tipo"];
	echo "ok";
}else{
	echo "Usuario o contraseña incorrecta";
}

 ?>