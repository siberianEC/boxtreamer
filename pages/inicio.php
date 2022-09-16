<?php include $_SERVER["DOCUMENT_ROOT"]."/pages/layout/head.php"; 

$name=trim(shell_exec("ps -e -o command | grep play | grep -v grep"));
$name=trim(str_replace("-t mp3", "", $name));
$name=trim(str_replace("play", "", $name));
$name=str_replace(" repeat 999999999", "", $name);
$name=str_replace(" repeat", "", $name);

if($name==""){
	$status="STAND-BY";
	$color="#000000";
	$colorb="#f52e4a";
}else{
	$status="PLAYING";
	$color="#dcf7e5";
	$colorb="#3c763d";
}

if ((strpos(strtolower($name), 'http://') !== false)||(strpos(strtolower($name), 'https://') !== false)) {
    $tipo="Streaming Audio";
}else{
	if($name==""){
		$tipo="";
	}else{
		$tipo="Archivo mp3";
	}
}

$volumen = trim(shell_exec('sudo '.$_SERVER["DOCUMENT_ROOT"].'/app/sh/GetVolume.sh'));
$volumen = str_replace("%","",$volumen);
?>



<div>
	<div class="col-sm-8">
		

		<div class="DivTituloTipo2">
		PLAYER:
		</div>
<div class="DivTituloTipo">
		<div class="DivTitulo">
			<div class="col-sm-2"><label>Estado</label></div>
			<div class="col-sm-10 FondoGris" style="text-align: center;">
					<label  class="flash infinite animated" style=" width: 100%;animation-duration: 3s;   BACKGROUND:<?php echo $colorb; ?>;
    PADDING: 6px 93px
;color:<?php echo $color; ?>"><?php echo $status; ?></label>
			</div>
		</div>
		<div class="DivTitulo">
			<div class="col-sm-2"><label>Fuente</label></div>
			<div class="col-sm-10 FondoGris" style="text-align: center;">
				<label><?php echo $name; ?></label>
			</div>
		</div>
		<div class="DivTitulo">
			<div class="col-sm-2"><label>Tipo</label></div>
			<div class="col-sm-10 FondoGris" style="text-align: center;">
				<label id="info"><?php echo $tipo; ?></label>
			</div>
		</div>
		
</div>

		<div class="DivTituloTipo2">
		SALIDA DE AUDIO:
		</div>
		<div class="DivTituloTipo">
		<!-- 	<div class="DivTitulo">
			<div class="col-sm-2"><label>Ruta</label></div>
			<div class="col-sm-10 FondoGris" style="text-align: center;">
				<label id="info0"></label>
			</div>
		</div> -->
		<div class="DivTitulo">
			<div class="col-sm-2"><label>Tamaño</label></div>
			<div class="col-sm-10 FondoGris" style="text-align: center;">
				<label id="info1"></label>
			</div>
		</div>


		<div class="DivTitulo">
			<div class="col-sm-2"><label>Codificación</label></div>
			<div class="col-sm-10 FondoGris" style="text-align: center;">
				<label id="info2"></label>
			</div>
		</div>
		<div class="DivTitulo">
			<div class="col-sm-2"><label>Canales</label></div>
			<div class="col-sm-10 FondoGris" style="text-align: center;">
				<label id="info3"></label>
			</div>
		</div>
		<div class="DivTitulo">
			<div class="col-sm-2"><label>Frecuencia</label></div>
			<div class="col-sm-10 FondoGris" style="text-align: center;">
				<label id="info4"></label>
			</div>
		</div>
		<div class="DivTitulo">
			<div class="col-sm-2"><label>Duración</label></div>
			<div class="col-sm-10 FondoGris" style="text-align: center;">
				<label id="info5"></label>
			</div>
		</div>
		<div class="DivTitulo">
			<div class="col-sm-2"><label>Volumen</label></div>
			<div class="col-sm-10 FondoGris" style="text-align: center;">
				 <div class="volumen_input_container"><div  class="porcentaje"><?php echo $volumen; ?>%</div><div class="volumen_input"><div class="volumen_audio" style="width: <?php echo $volumen; ?>%"></div></div></div>
			</div>
		</div>

		<div class="DivTitulo">
			<div class="col-sm-2"><label>Audio</label></div>
			<div class="col-sm-10 FondoGris" style="text-align: center;">
				<label id="info6"></label>
			</div>
		</div>
		</div>

	</div>
	<div class="col-sm-4 FondoGrisAyuda">
		<label>Ayuda</label>
		<br><br>
		<label>Pagina de Inicio</label>
		<p>Resumen del estado del dispositivo</p>


		<label>Estado</label>
		<p>-STAND-BY:
		No hay un fuente de audio (Streaming o archivo) disponible.
		</p>

		<p>-PLAYING:
		Player está recibiendo desde una fuente y está sonando.
		</p>


	</div>
	<img src="/assets/img/Cajita.jpg" style="width: 300px;">
</div>

</div>
<?php include $_SERVER["DOCUMENT_ROOT"]."/pages/layout/footer.php"; ?>
</body>
</html>
<script type="text/javascript">
	var datos=null;
	var ix=6;
	function actualizar_datos(){
		$.ajax({
		url:'/app/scripts/ReadMusicLog.php',
		success:function(data){
			
			try{
			datos = JSON.parse(data);
			$("#info0").html(datos[0]);
			$("#info1").html(datos[1]);
			$("#info2").html(datos[2]);
			$("#info3").html(datos[3]);
			$("#info4").html(datos[4]);
			$("#info5").html(datos[5]);
			}catch(err){
				
			}
		},
		error:function(err){
			
		}
	});
	}
	actualizar_datos();
	setInterval(function(){ 
		if(datos!=null){
			$("#info6").html(datos[ix]);
			if(ix==26){
				actualizar_datos();
				ix=6;
			}
			ix++;
		}
	}, 250);
</script>