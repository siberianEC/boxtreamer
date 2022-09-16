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
			<label>AUDIO</label>
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-3"><label>VOLUMEN</label></div>
				<div class="col-sm-9"><input type="text" id="volumen" style="width: 50px;text-align: center;margin-right: 5px" maxlength="3" value="<?php echo $result[6]["datos"]; ?>">%</div>
			</div>
		</div>
		<div>
			<label>NETWORK</label>
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-3"><label>Address</label></div>
				<div class="col-sm-9"><input type="text" id="Address" style="padding: 7px 5px;" class="InputUrl" value="<?php echo $result[0]["datos"]; ?>"></div>
			</div>
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-3"><label>Gateway</label></div>
				<div class="col-sm-9"><input type="text" id="Gateway" style="padding: 7px 5px;" class="InputUrl" value="<?php echo $result[3]["datos"]; ?>"></div>
			</div>
		</div>
		<div>
			<label>SEGURIDAD</label>
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-3"><label>Contraseña</label></div>
				<div class="col-sm-9"><input type="password" style="padding: 7px 5px;" id="password" class="InputUrl"></div>
			</div>
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-3"><label>Confirmación</label></div>
				<div class="col-sm-9"><input type="password" style="padding: 7px 5px;" id="password2" class="InputUrl"></div>
			</div>
		</div>

	</div>
	
	<div class="col-sm-4 FondoGris">
		<label>Ayuda</label>
		<br>
		<div>
		<label>GENERAL</label>
		<p>La mejor forma de cambiar las configuraciones es modificar cada sección por separado, por ejemplo si desea cambiar la contraseña y el volumen, se recomienda primero cambiar la contraseña, recargar la página y luego cambiar el volumen del sistema.</p>
		</div>
		<div>
		<label>NETWORK</label>
		<p>Luego de cambiar las direcciones IP lo más recomendable es reiniciar el sistema para que los cambios se efectuen.</p>
		</div>
		<div>
		<label>VOLUMEN</label>
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
		
		if($("#volumen").val()!="<?php echo $volumen; ?>"){
			if($.isNumeric($("#volumen").val())){
				var volumen = parseInt($("#volumen").val());
				if(volumen<0)volumen=0;
				if(volumen>100)volumen=100;
				$.ajax({
					url:'/app/scripts/SetVolume.php',
					type:'POST',
					data:{
						volumen:volumen
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
			}else{
				$("#volumen").val("<?php echo $volumen; ?>");
			}

		}


		var CambiosIP=false;
		if($("#Address").val()!="<?php echo $result[0]["datos"]; ?>")CambiosIP=true;
		if($("#Netmask").val()!="<?php echo $result[4]["datos"]; ?>")CambiosIP=true;
		if($("#Gateway").val()!="<?php echo $result[3]["datos"]; ?>")CambiosIP=true;
		if($("#DNS1").val()!="<?php echo $result[1]["datos"]; ?>")CambiosIP=true;
		if($("#DNS2").val()!="<?php echo $result[2]["datos"]; ?>")CambiosIP=true;
		
		if(CambiosIP){
			$.ajax({
				url:'/app/scripts/GuardarConfiguracionIP.php',
				type:'POST',
				data:{
					ip_address:$("#Address").val(),
					ip_dns1:$("#DNS1").val(),
					ip_dns2:$("#DNS2").val(),
					ip_gateway:$("#Gateway").val(),
					ip_netmask:$("#Netmask").val()
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
		}

		var CambiosPassword=false;
		if($("#password").val()!="")CambiosPassword=true;
		if($("#password2").val()!="")CambiosPassword=true;

		if(CambiosPassword){
			if($("#password").val()==$("#password2").val()){
				if($("#password").val().length>4){
					$.ajax({
						url:'/app/scripts/CambiarPassword.php',
						type:'POST',
						data:{password:$("#password").val()},
						beforeSend:function(){$("#loading").show();},
						success:function(res){
							$("#loading").hide();
							alert(res);
							if(res=="La contraseña de modificó con éxito.")
							window.location = "";
						},
						error:function(err){
							$("#loading").hide();
							alert(err.responseText);
						}
					});
				}else{
					alert("La contraseña debe tener más de 4 caracteres.");
				}
			}else{
				alert("Las contraseñas no coinciden.");
			}
		}
	});
</script>