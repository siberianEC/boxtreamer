<?php include $_SERVER["DOCUMENT_ROOT"]."/pages/layout/head.php"; 

$result=$db->select("SELECT nombre,datos FROM configuracion order by id");

?>

<div>
	<div class="col-sm-2">
		<button id="BtnCancelar">Cancelar</button>
		<button id="BtnAplicar">Aplicar</button>
	</div>
	<div class="col-sm-6">



<div>
		
			<div class="row" style="margin-bottom: 10px; margin-top: 18px;">
				<div class="col-sm-3"><label>IP ADDRESS</label></div>
				<div class="col-sm-9"><SPAN style="FONT-SIZE: 20PX;FONT-WEIGHT: BOLD;"><?php echo $_SERVER['HTTP_HOST'];?></SPAN></div>
			</div>
		
		</div>

		<div>
		
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-3"><label>LICENCIA</label></div>
				<div class="col-sm-9"><input type="text" style="padding: 7px 5px;" placeholder="Ingrese la licencia" id="licencia" class="InputUrl" value="<?php echo $result[8]["datos"];?>"></div>
			</div>
		
		</div>

		
		<div>
		
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-3"><label>STATUS</label></div>
				<div class="col-sm-9"><?php 
	
	
	// verificación de licencia  ********************************************
try {



	
	$url = 'http://10.11.5.37/licence.php';
	$result=$db->select("SELECT nombre,datos FROM configuracion order by id");
	$data = array('licence' => $result[8]["datos"], 'ip' => $_SERVER['HTTP_HOST']);
	$options = array(
	'http' => array(
		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'method'  => 'POST',
		'content' => http_build_query($data),
		'timeout' => 1
	)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);

	if ($result!="1") { 
		echo '<SPAN style="FONT-SIZE: 14PX;FONT-WEIGHT: BOLD;COLOR: #b10404;">EQUIPO NO AUTORIZADO</SPAN>';
	}else
	{
		echo '<SPAN style="FONT-SIZE: 14PX;FONT-WEIGHT: BOLD;COLOR: #23b943;">EQUIPO AUTORIZADO</SPAN>';
	}
} catch (\Throwable $th) {
	echo '<SPAN style="FONT-SIZE: 14PX;FONT-WEIGHT: BOLD;COLOR: #b10404;">EQUIPO NO AUTORIZADO</SPAN>';
}

// ***********************************************************************
	
	
	
	
	
	
	?></div>


			</div>
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-12" style="    margin-top: 14px;
    font-style: initial;
    color: #b1b1b1;"><b>Nota:</b> Para solicitar una licencia comuniquese a info@siberian.com.ec.</div>

				</div>
		</div>
	

	</div>
	<div class="col-sm-4 FondoGris">
		<label>Ayuda</label>
		<br>
		<div>
		<label>LICENCIA</label>
		<p>La mejor forma de cambiar las configuraciones es modificar cada sección por separado, por ejemplo si desea cambiar la contraseña y el volumen, se recomienda primero cambiar la contraseña, recargar la página y luego cambiar el volumen del sistema.</p>
		</div>
		<div>
		<label>IP ADDRESS</label>
		<p>Luego de cambiar las direcciones IP lo más recomendable es reiniciar el sistema para que los cambios se efectuen.</p>
		</div>
		<div>
		<label>STATUS</label>
		<p>Configuración del volumen en la reproducción de archivos desde el usuario panaderia.</p>
		</div>
	</div>
</div>

</div>
<?php include $_SERVER["DOCUMENT_ROOT"]."/pages/layout/footer.php"; ?>
</body>
</html>

<script type="text/javascript">

	$("#BtnCancelar").click(function(){
		
	});

	$("#BtnAplicar").click(function(){
	
			$.ajax({
				url:'/app/scripts/GuardarLicencia.php',
				type:'POST',
				data:{
					licencia:$("#licencia").val(),
				},
				beforeSend:function(){$("#loading").show();},
				success:function(res){
					$("#loading").hide();
					alert(res);
					window.location = "";
				},
				error:function(err){
					$("#loading").hide();
					alert(err.responseText);
				}
			});
		
	});
</script>