<?php 
session_start();
if(isset($_SESSION["id"])){
	if($_SESSION["tipo"]=="2"){
		header("Location: /master/pages/inicio.php");
	}else{
		header("Location: /pages/inicio.php");
	}
}	
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>BOXTREAMER | LOGIN</title>

</head>

<link rel="stylesheet" href="/assets/css/login.css">
<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
<script type="text/javascript" src="/assets/js/jquery-3.3.1.min.js"></script>



<body class="login-page">
	<div class="login-box">
  		<div class="login-box-body">
    		<div class="login-logo"><label style="color:#fff;">BOXTREAMER</label></div>
   			<p class="login-box-msg" style="color:#dedede;">Ingresa los datos para iniciar sesión</p>

   			<form id="login">
      			<div class="form-group has-feedback">
        			<input type="text" class="form-control" name="user" required="" placeholder="Usuario">
      			</div>
      			<div class="form-group has-feedback">
        			<input type="password" class="form-control" name="pass" required="" placeholder="Contraseña">
      			</div>
      			<div id="div-iniciar">
          			<button type="submit" class="btn btn-primary btn-block btn-flat" id="btn-iniciar-sesion">Iniciar Sesión</button>
        		</div>
        	</form>

      </div>
  </div>

</body>


</html>
<script type="text/javascript">
	$("#login").submit(function(e){
		e.preventDefault();
		var data = $(this).serialize();
		$.ajax({
			url:'/app/scripts/login.php',
			type:'POST',
			data:data,
			success:function(res){
				window.location = "";
			},
			error:function(err){
				alert(err.responseText);
			}
		});
	});
</script>