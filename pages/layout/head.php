<?php 
include $_SERVER["DOCUMENT_ROOT"]."/app/core/core.php";
$db = new Db();
if(!(isset($_SESSION["id"]))){
	header("Location: /");
}else{
	if($_SESSION["tipo"]=="3"){
		if($_SERVER['SCRIPT_NAME']!="/pages/archivos.php"){
			header("Location: /pages/archivos.php");
		}
	}
}
date_default_timezone_set('America/Guayaquil');
?>

<!DOCTYPE html>
<html>
<head>
	<title>BOXTREAMER</title>
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/principal.css">

	<script type="text/javascript" src="/assets/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
	<script src="/assets/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="/assets/css/jquery.dataTables.min.css">

	<link rel="stylesheet" href="/assets/css/responsive.bootstrap.min.css">
	<script src="/assets/js/dataTables.responsive.min.js"></script>
	<link rel="stylesheet" href="/assets/css/animate.css">
	<link rel="stylesheet" href="/assets/css/select2.min.css">
	<script src="/assets/js/select2.min.js"></script>

</head>
<body>
	<div id="loading" style="display: none;position: fixed;width: 100%;height: 100%;top: 0px;left: 0px;z-index: 999999;overflow: auto;background-color: rgba(0, 0, 0, 0.498039);">
<img style="position: absolute;
    top: 50% !important;
  left: 50% !important;" src="/assets/img/loader_1.gif">
</div>

<div class="container" style="margin-top: 5px">
	<ul id="BotonesMenuPrincipal">
	<a href="/pages/inicio.php"><li>INICIO</li></a>
	<a href="/pages/configuracion.php"><li>CONFIGURACIÓN</li></a>
	<a href="/pages/licencia.php"><li>LICENCIA</li></a>
	<a href="/pages/archivos.php"><li>ARCHIVOS</li></a>
	
	<a href="/pages/programacion.php"><li>PROGRAMACIÓN</li></a>
	<!--<a href="#"><li>ESTADO</li></a>
	<a href="#"><li>ACTUALIZAR</li></a>-->
	<?php  if($_SESSION["tipo"]=="1"){ ?>
	<a id="BtnUpgrade"><li>UPGRADE</li></a>
	<a id="BtnReiniciar"><li>REINICIAR</li></a>
	<?php } ?>
	<a id="BtnSalir"><li>SALIR</li></a>
	<li style="float: right;"><span id="Reloj"><?php echo date('Y-m-d H:i:s') ?></span></li>
</ul>
<form action="/app/scripts/SubirUpgrade.php" method="post" enctype="multipart/form-data">
<input type="submit" value="Subir" name="submit" id="submit2" required  style="display: none;">
<input type="file" name="FileUpgrade" onchange="document.getElementById('submit2').click()" id="FileUpgrade" style="display: none;">
</form>


<div class="row" style="font-size: 30px;">
	<div class="col-sm-6">STREAMING CLIENT</div>
	<div class="col-sm-6" style="text-align: right;    font-weight: bold;
    letter-spacing: -3px;
    text-shadow: 1px 3px 8px #ccc; color: #5e6164;">BOXTREAMER</div>
</div>
<hr id="HrMenuPrincipal">
<script type="text/javascript">
	$("#BtnUpgrade").click(function(){$("#FileUpgrade").click();});


	$("#BtnReiniciar").click(function(){
		var res=prompt('Para reiniciar el equipo escribe: "OK"');
		if(res.toLowerCase()=="ok"){
			$.ajax({
				url:'/app/scripts/Reboot.php',
				type:'POST',
				data:{
					control:'reboot'
				}
			});
		}
	});
	$("#BtnSalir").click(function(){
		$.ajax({
			url:'/app/scripts/Logout.php',
			type:'POST',
			data:{
				control:'Logout'
			},
			success:function(res){
				if(res=="ok"){
					window.location = "/";
				}
			},
			error:function(err){
				alert(err.responseText);
			}
		});
	});
	var d = new Date("<?php echo date('Y-m-d H:i:s') ?>");
	setInterval(function(){ 
		d.setSeconds(d.getSeconds() + 1);
		var MyDateString =  d.getFullYear() + '-'
             + ('0' + (d.getMonth()+1)).slice(-2) + '-'
             + ('0' + d.getDate()).slice(-2) + ' '
             + ('0' + d.getHours()).slice(-2) + ':'
             + ('0' + d.getMinutes()).slice(-2) + ':'
             + ('0' + d.getSeconds()).slice(-2);
		$("#Reloj").html(MyDateString);
	}, 1000);
	
	<?php if (isset($_GET["resp"])) {
		$resp=$_GET["resp"];
	}else{
		$resp=-1;
	} ?>

</script>