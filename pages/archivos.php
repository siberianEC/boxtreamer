<?php include $_SERVER["DOCUMENT_ROOT"]."/pages/layout/head.php"; 


$archivos  = scandir($_SERVER["DOCUMENT_ROOT"]."/assets/media");
$result=$db->select("SELECT datos FROM configuracion WHERE nombre = 'reproduciendo ahora'");
$reproduciendo_ahora=$result[0]["datos"];
$reproduciendo_ahora=trim(str_replace($_SERVER["DOCUMENT_ROOT"]."/assets/media/", "", $reproduciendo_ahora));

$archivos_base=$db->select("SELECT nombre,estado,descripcion FROM archivos");
?>

<style type="text/css">
	hr{margin-top: 10px;margin-bottom: 10px;}
	.glyphicon {top: 10px;}
	.noselect {
list-style-type: none;padding: 10px 5px;margin-bottom: 0px;max-height: 800px;overflow-y: scroll;
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
}
</style>
<div>
	<div class="col-sm-8">
		
		<?php if($_SESSION["tipo"]=="1"){ ?>
		<div class="DivTitulo">
			<div class="col-sm-3"><label>Añadir archivo</label></div>
			<div class="col-sm-9">
				<form action="/app/scripts/SubirArchivo.php" method="post" enctype="multipart/form-data">
					<input type="submit" value="Subir" name="submit" required>
    				<input type="file" name="fileToUpload" id="fileToUpload" style="display: inline-block;">
				</form>
			</div>
		</div>
		<?php } ?>
		<div class="DivTitulo">
			<?php  if($_SESSION["tipo"]=="1"){ ?>
			<div class="col-sm-3"><label>Lista de archivos</label><label>Total de archivos: <?php echo count($archivos)-2; ?></label></div>
			<div class="col-sm-9 FondoGris">
			<?php }else{ ?>
			<div class="col-sm-12 FondoGris">
				<div>
				<span class="glyphicon glyphicon-stop BtnGly BtnReproducirParar" style="font-size: 45px;"></span> 
				<h3 style="display: inline-block;">Parar reproducción</h3>
				</div>
			<?php } ?>
				<ul class="noselect">
					<?php 
					foreach ($archivos as $key => $value) {
						if(($value!=".")&&($value!="..")){
						 
						 if($_SESSION["tipo"]=="3"){
						 	$aux = '<li style="font-size: 25px;">';
						 	

						 	$control=true;
							$nombre=$value;
							 foreach ($archivos_base as $key2 => $value2) {
							 	if($value2["nombre"]==$value){
							 		$nombre=$value2["nombre"];
							 		if($value2["descripcion"]!=""){
							 			$value=$value2["descripcion"];
							 		}else{
							 			$value=$value2["nombre"];
							 		}
							 		if($value2["estado"]=="2"){
							 			$control=false;
							 		}
							 	}
							 }

						 	$aux.='<span class="glyphicon glyphicon-play-circle BtnGly BtnReproducirParar" tipo="reproducir" nombre="'.$nombre.'" style="font-size: 45px;"></span> ';

							if($control){
								if($nombre==$value){
									$aux.=$value.'</li><hr>';
								}else{
									$aux.=$nombre." - ".$value.'</li><hr>';
								}
							 	
						 		echo $aux;
						 	}
						 	

						 }else{
						 	$aux = '<li>';
						 	
						 
							 $control=true;
							 $nombre=$value;
							 foreach ($archivos_base as $key2 => $value2) {
							 	if($value2["nombre"]==$value){
							 		$nombre=$value2["nombre"];
							 		if($value2["descripcion"]!=""){
							 			$value=$value2["descripcion"];
							 		}else{
							 			$value=$value2["nombre"];
							 		}
							 		if($value2["estado"]=="2"){
							 			$control=false;
							 		}
							 	}
							 }
							 $aux.='<span name="'.$nombre.'" title="Borrar archivo" class="glyphicon glyphicon-remove BtnBorrarArchivo BtnGly" style="font-size: 18px;"></span> ';
							 $aux.='<span class="glyphicon glyphicon-pencil BtnGly" title="Editar la descripción" nombre="'.$nombre.'"></span> ';
							 if($control){
							 	$aux.='<span class="glyphicon glyphicon-eye-open BtnGly BtnMostrarOcultarArchivo" nombre="'.$nombre.'" tipo="ocultar" title="El audio es visible."></span> ';
							 }else{
							 	$aux.='<span class="glyphicon glyphicon-eye-close BtnGly BtnMostrarOcultarArchivo" nombre="'.$nombre.'" tipo="mostrar" title="El audio no es visible."></span> ';
							 }


							if($nombre==$value){
								$aux.=$value.'</li>';
							}else{
								$aux.=$nombre." - ".$value.'</li>';
							}
						 	echo $aux;
						 }

						
						}
					}
					 ?>
				</ul>
			</div>
		</div>

	</div>
	<div class="col-sm-4 FondoGris">
		<label>Ayuda</label>
		<br>
		<div>
		<label>FORMATOS</label>
		<p>Los formatos disponibles son: mp3,wav y ogg.</p>
		</div>
		<div>
		<label>CAPACIDAD</label>
		<p>No se recomienda tener una gran cantidad de archivos ya que se puede ocupar toda la memoria del sistema, es recomendable borrar archivos que no se utilizen.</p>
		</div>
		<div>
	</div>
</div>

</div>
<?php include $_SERVER["DOCUMENT_ROOT"]."/pages/layout/footer.php"; ?>
</body>
</html>

<script type="text/javascript">
	$(".glyphicon-pencil").click(function(){
		var descripcion=prompt('Ingrese la descripción del audio: ');
		if(descripcion!=null){
			$.ajax({
				url:"/app/scripts/EditarNombreArchivo.php",
				type:"POST",
				data:{nombre:$(this).attr("nombre"),descripcion:descripcion},
				beforeSend:function(){$("#loading").show();},
				success:function(res){
					$("#loading").hide();
					alert(res);
					if(res=="Se editó el nombre del audio."){
						window.location = "";
					}
				},
				error:function(err){
					$("#loading").hide();
					alert(err.responseText);
				}
			});
		}
	});

	$(".BtnMostrarOcultarArchivo").click(function(){
		$.ajax({
			url:"/app/scripts/MostrarOcultarArchivo.php",
			type:"POST",
			data:{nombre:$(this).attr("nombre"),tipo:$(this).attr("tipo")},
			beforeSend:function(){$("#loading").show();},
			success:function(res){
				$("#loading").hide();
				alert(res);
				if(res=="El audio ahora no es visible."||res=="El audio ahora es visible."){
					window.location = "";
				}
			},
			error:function(err){
				$("#loading").hide();
				alert(err.responseText);
			}
		});
	});



		$(".BtnReproducirParar").click(function(){
			var nombre = $(this).attr("nombre");
			if($(this).attr("tipo")=="reproducir"){
				$.ajax({
					url:"/app/scripts/ReproducirArchivoAhora.php",
					type:"POST",
					data:{nombre:nombre},
					beforeSend:function(){$("#loading").show();},
					success:function(res){
						$("#loading").hide();
						alert(res);
					},
					error:function(err){
						$("#loading").hide();
						alert(err.responseText);
					}
				});
			}else{
				$.ajax({
					url:"/app/scripts/ReproducirArchivoParar.php",
					type:"POST",
					data:{nombre:nombre},
					beforeSend:function(){$("#loading").show();},
					success:function(res){
						$("#loading").hide();
						alert(res);
					},
					error:function(err){
						$("#loading").hide();
						alert(err.responseText);
					}
				});
			}
			
		});
		

	

	

	$(".BtnBorrarArchivo").click(function(){
		var res=prompt('Para eliminar el archivo escribe: "OK"');
		if(res.toLowerCase()=="ok"){
			var name = $(this).attr("name");
			$.ajax({
				url:"/app/scripts/EliminarArchivo.php",
				type:"POST",
				data:{nombre:name},
				beforeSend:function(){$("#loading").show();},
				success:function(res){
					$("#loading").hide();
					alert(res);
					if(res=="El archivo se eliminó con éxito."){
						window.location = "";
					}
				},
				error:function(err){
					$("#loading").hide();
					alert(err.responseText);
				}
			});
		}
	});
	if(parseInt(<?php echo $resp; ?>)>=0){
		var mensaje="";
		switch(parseInt(<?php echo $resp; ?>)){
			case 0:
			mensaje="Error al subir archivo";
			break;
			case 1:
			mensaje="El archivo se subió con éxito";
			break;
			case 2:
			mensaje="Error, el archivo ya existe";
			break;
			case 3:
			mensaje="El archivo es demasiado grande";
			break;
			case 4:
			mensaje="El archivo debe ser un audio (wav,mp3,ogg)";
			break;
			case 5:
			mensaje="El archivo es demasiado grande o no es válido";
			break;
			case 6:
			mensaje="La versión del sistema se modificó con éxito.";
			window.history.pushState('', '', window.location.pathname);
			alert(mensaje);
			window.location = "";
			break;
			case 7:
			mensaje="Error al modificar la versión del sistema.";
			break;
			case 7:
			mensaje="Error, el archivo de la versión no es válido.";
			break;
			default:
			mensaje="El archivo es demasiado grande o no es válido";
			break;
		}
		window.history.pushState('', '', window.location.pathname);
		alert(mensaje);
	}
</script>