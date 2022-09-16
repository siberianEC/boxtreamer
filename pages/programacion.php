<?php include $_SERVER["DOCUMENT_ROOT"]."/pages/layout/head.php"; 
$archivos  = scandir($_SERVER["DOCUMENT_ROOT"]."/assets/media");

$result=$db->select("SELECT count(*)+1 as prioridad from programacion where estado in (1,2)");
$prioridad=$result[0]["prioridad"];

?>

<div class="row">
	<div class="col-sm-8">
		
		<div>
		<form id="form_datos">
			<input type="hidden" name="IdAudio" id="IdAudio" value="">
			<label id="label_titulo">INGRESAR</label>
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-12">
					<div style="padding-right: 15px;padding-left: 15px;margin-right: 4px;display: inline-block;width: 15%"><label style="margin-top: 5px;">Audio/Stream</label></div>
					<div style="right: 15px;padding-left: 15px;display: inline-block;width: 82%"><select name="nombre" id="nombre" class="InputUrl" required>
						<?php 
						foreach ($archivos as $key => $value) {
							if(($value!=".")&&($value!=".."))
							echo '<option value="'.$value.'">'.$value.'</option>';
						}
					 ?>
					</select>
					</div>
				</div>
			</div>
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-6">
					<div class="col-sm-4"><label style="margin-top: 5px;">Días</label></div>
					<div class="col-sm-8"><select multiple="multiple" id="dias" class="InputUrl" required>
						<option value="0">Todos</option>
						<option value="1">Lunes</option>
						<option value="2">Martes</option>
						<option value="3">Miércoles</option>
						<option value="4">Jueves</option>
						<option value="5">Viernes</option>
						<option value="6">Sábado</option>
						<option value="7">Domingo</option>
					</select></div>
				</div>
				<div class="col-sm-6" style="margin-top: 7px;">
					<div class="col-sm-4"><label>Prioridad</label></div>
					<div class="col-sm-8"><input type="text" id="prioridad" name="prioridad" class="InputUrl" value="<?php echo $prioridad; ?>" required></div>
				</div>
			</div>
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-6">
					<div class="col-sm-4"><label>Fecha INI</label></div>
					<div class="col-sm-5" style="padding-right: 0px;"><input type="date" id="fecha_ini" name="fecha_ini" class="InputUrl" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required></div>
					<div class="col-sm-3"><label><input checked type="checkbox" name="cboxFechaIni" id="cboxFechaIni"></label></div>
				</div>
				<div class="col-sm-6">
					<div class="col-sm-4"><label>Fecha FIN</label></div>
					<div class="col-sm-5" style="padding-right: 0px;"><input type="date" id="fecha_fin" name="fecha_fin" class="InputUrl" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required></div>
					<div class="col-sm-3"><label><input checked type="checkbox" name="cboxFechaFin" id="cboxFechaFin"></label></div>
				</div>
			</div>
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-6">
					<div class="col-sm-4"><label>Hora INI</label></div>
					<div class="col-sm-8"><input step="1" type="time" id="hora_ini" name="hora_ini" class="InputUrl" required></div>
				</div>
				<div class="col-sm-6">
					<div class="col-sm-4"><label>Hora FIN</label></div>
					<div class="col-sm-5"><input step="1" type="time" id="hora_fin" name="hora_fin" class="InputUrl" required></div>
					<div class="col-sm-3"><label><input checked type="checkbox" name="cboxHoraFin" id="cboxHoraFin"></label></div>
				</div>
			</div>
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-6">
					<div class="col-sm-4"><label>Repeticiones</label></div>
					<div class="col-sm-4"><input type="text" id="repeticiones" name="repeticiones" value="0" class="InputUrl" required></div>
					<div class="col-sm-4"><label>Loop <input type="checkbox" name="cboxRepeticiones" id="cboxRepeticiones"></label></div>
				</div>
				<div class="col-sm-6">
					<div class="col-sm-4"><label>Volumen</label></div>
					<div class="col-sm-8"><input type="text" id="volumen" value="100" name="volumen" class="InputUrl" required></div>
				</div>
			</div>
			<button id="BtnEnviar" hidden></button>
		</form>
			<div style="margin-bottom: 10px;float: right;">
				<div class="col-sm-12">
					<button id="BtnCancelar">Cancelar</button>
					<button id="BtnGuardar">Guardar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-4 FondoGris">
		<label>Ayuda</label>
		<br>
		<div>
		<label>REPETICIONES</label>
		<p>La opcion de repeticiones como su nombre lo indica, es para saber el número de repeticiones del audio, con el número 0 el audio solo sonara 1 vez y para que suene con un bucle el check de Loop debe estar activado.</p>
		</div>
		<div>
		<label>STREAMING</label>
		<p>Para ingresar un streaming debe ingresar la URL completa con HTTP o HTTPS ejemplo 'https://streamingecuador.net:8001/radiodisney.mp3'.</p>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<table id="tabla-web" class="display compact" style="width: 100%">
		    <thead>
		        <tr>
		        	<th>Prioridad</th> 
		            <th>Nombre</th> 
		            <th>Fecha INI</th>
		            <th>Fecha FIN</th>
		            <th>Días</th>
		            <th>Hora INI</th>
		            <th>Hora FIN</th>
		            <th>Repeticiones</th>
		            <th>Volumen</th>
		            <th>Opciones</th>
		        </tr>
		    </thead>
		    <tbody>
		              
		    </tbody>
		</table>
	</div>
</div>

</div>
<?php include $_SERVER["DOCUMENT_ROOT"]."/pages/layout/footer.php"; ?>
</body>
</html>
<script type="text/javascript">
	$("#cboxRepeticiones").change(function() {
	    if(this.checked) {
	        $("#repeticiones").prop('disabled', true);
	    }else{
			$("#repeticiones").prop('disabled', false);
	    }
	});
	$("#cboxFechaIni").change(function() {
	    if(this.checked) {
	        $("#fecha_ini").prop('disabled', false);
	    }else{
			$("#fecha_ini").prop('disabled', true);
	    }
	});
	$("#cboxFechaFin").change(function() {
	    if(this.checked) {
	        $("#fecha_fin").prop('disabled', false);
	    }else{
			$("#fecha_fin").prop('disabled', true);
	    }
	});
	$("#cboxHoraFin").change(function() {
	    if(this.checked) {
	        $("#hora_fin").prop('disabled', false);
	    }else{
			$("#hora_fin").prop('disabled', true);
	    }
	});

	$("#BtnCancelar").click(function(){
		limpiar_programacion();
	});

	function limpiar_programacion(){
		$('#nombre').val("").trigger('change');
		$('#dias').val("").trigger('change');
		$("#fecha_ini").val("<?php echo date('Y-m-d'); ?>");
		$("#fecha_fin").val("<?php echo date('Y-m-d'); ?>");
		$("#hora_ini").val("");
		$("#hora_fin").val("");
		$("#repeticiones").val("0");
		$("#prioridad").val("<?php echo $prioridad; ?>");
		$("#volumen").val("100");
		$("#IdAudio").val("");
		$("#label_titulo").html("INGRESAR");
	}

	 $('#nombre').select2({
	 	tags: true,
	 	placeholder: "Seleccione el audio o ingrese la url del stream",
    	allowClear: true
	 });
	 $('#nombre').val("").trigger('change');
	 $('#dias').select2({
	 	placeholder: "Seleccione los días",
    	allowClear: true
	 });

	$("#BtnGuardar").click(function(){
		$("#BtnEnviar").click();
	});

	$("#form_datos").submit(function(e){
		var datos = $(this).serialize();
		datos+="&dias="+$("#dias").val().toString();
		$.ajax({
			url:'/app/scripts/GuardarProgramacion.php',
			type:'POST',
			data:datos,
			beforeSend:function(){$("#loading").show();},
			success:function(res){
				$("#loading").hide();
				try{
					var data = JSON.parse(res);
					alert(data[1]);
					if(data[0]==1){
						window.location = "";
					}
				}catch(err){
					alert(err.message);
				}
			},
			error:function(err){
				$("#loading").hide();
				alert(err.responseText);
			}
		});
		e.preventDefault();
	});


	 var table=$('#tabla-web').dataTable( {
	    responsive:true,
	      "order": [ 0, "asc" ],
	      "pageLength": 50,
	      "dom": '<"top"f>rt<"bottom"ip><"clear">',
	        "ajax": {
	            "url": "/app/scripts/ObtenerProgramacion.php",
	            "dataSrc": ""
	        },
	        language: {
	        search: "Buscar:",
	        lengthMenu:     "Mostar registros",
	        info:           "Mostrando _START_ - _END_ de _TOTAL_ registros",
	    	infoEmpty:      "Mostrando 0 - 0 de 0 registros",
	        paginate: {
	            first:      "Primero",
	            last:       "Ultimo",
	            next:       "Siguiente",
	            previous:   "Anterior"
	        },
	        emptyTable: "No se han encontrado registros"
	  		},
	  		columns: [
	            { "data": "prioridad" },
	            { "data": "nombre" },
	            { "data": "fecha_ini" },
	            { "data": "fecha_fin" },
	            { "data": "dias" },
	            { "data": "hora_ini" },
	            { "data": "hora_fin" },
	            { "data": "repeticiones" },
	            { "data": "volumen" },
	            { "data": "opciones", render : function(data){
			        return '<select class="SelectOpciones" idaudio="'+data+'"><option value="" disabled selected>Opciones</option><option>Clonar</option><option>Editar</option><option>Eliminar</option></select>';
			    }},
			    { "data": "estado","visible": false}
	        ],
	        createdRow: function( row, data, dataIndex){
                if( data.estado ==  "2"){
                    $(row).addClass('ProgramacionReproducida');
                } else if (data.estado ==  "3"){
                	$(row).addClass('ProgramacionError');
                }
            },
	        initComplete: function(settings, json) {
		     preparar_opciones();
		     $(".sorting_1").click(function(){
		     	setTimeout(function(){ preparar_opciones(); }, 100);
		     });
		  }
	    } );
	 

	 function preparar_opciones(){
	 	$(".SelectOpciones").change(function(){
     	var tipo=$(this).val();
     	$(".SelectOpciones").val("");
     	$(this).val(tipo);
	 	var id=$(this).attr("IdAudio");
	 	if((tipo=="Clonar")||(tipo=="Editar")){
	 		$(this).val("");
		 	$.ajax({
		 		url:'/app/scripts/ObtenerProgramacionById.php',
				type:'POST',
				data:{id:id},
				success:function(res){
					var data = JSON.parse(res);
					if(tipo=="Editar"){
						$("#label_titulo").html("EDITAR");
						$("#IdAudio").val(data.id);
					}else{
						$("#label_titulo").html("INGRESAR");
					}
					$("#prioridad").val(data.prioridad);
					$('#dias').val(data.dias.split(",")).trigger('change');
					if(data.fecha_ini=='1996-08-23'){
						if($('#cboxFechaIni:checkbox:checked').length > 0){
							$('#cboxFechaIni').prop('checked', false);
							$("#fecha_ini").prop('disabled', true);
						}else{
							$('#cboxFechaIni').prop('checked', false);
							$("#fecha_ini").prop('disabled', true);
						}
					}else{
						$("#fecha_ini").prop('disabled', false);
						$('#cboxFechaIni').prop('checked', true);
						$("#fecha_ini").val(data.fecha_ini);
					}
					if(data.fecha_fin=='2996-08-23'){
						if($('#cboxFechaFin:checkbox:checked').length > 0){
							$('#cboxFechaFin').prop('checked', false);
							$("#fecha_fin").prop('disabled', true);
						}else{
							$('#cboxFechaFin').prop('checked', false);
							$("#fecha_fin").prop('disabled', true);
						}
					}else{
						$("#fecha_fin").prop('disabled', false);
						$('#cboxFechaFin').prop('checked', true);
						$("#fecha_fin").val(data.fecha_fin);
					}
					
					
					$("#hora_ini").val(data.hora_ini);

					if(data.hora_fin=='23:59:57'){
						if($('#cboxHoraFin:checkbox:checked').length > 0){
							$('#cboxHoraFin').prop('checked', false);
							$("#hora_fin").prop('disabled', true);
						}else{
							$('#cboxHoraFin').prop('checked', false);
							$("#hora_fin").prop('disabled', true);
						}
					}else{
						$("#hora_fin").prop('disabled', false);
						$('#cboxHoraFin').prop('checked', true);
						$("#hora_fin").val(data.hora_fin);
					}


					if(data.repeticiones=='999999999'){
						if(!($('#cboxRepeticiones:checkbox:checked').length > 0)){
							$('#cboxRepeticiones').prop('checked', true);
							$("#repeticiones").prop('disabled', true);
						}
					}else{
						$("#repeticiones").val(data.repeticiones);
					}
					
					$("#volumen").val(data.volumen);
					if($("#nombre option[value='"+data.nombre+"']").length > 0){
						$('#nombre').val(data.nombre).trigger('change');
					}else{
						var data_aux = {id: data.nombre,text: data.nombre};
						var newOption = new Option(data_aux.text, data_aux.id, false, false);
						$('#nombre').append(newOption).trigger('change');
						$('#nombre').val(data.nombre).trigger('change');
					}
				},
				error:function(err){
					alert(err.responseText);
				}
		 	});
		}else{
			var res=prompt('Para eliminar la programación escribe: "OK"');
			if(res==null){
		 		$(this).val("");
		 	}else{
				if(res.toLowerCase()=="ok"){
					$.ajax({
						url:'/app/scripts/EliminarProgramacion.php',
						type:'POST',
						data:{id:id},
						beforeSend:function(){$("#loading").show();},
						success:function(res){
							$("#loading").hide();
							alert(res);
							if(res=="La programación se eliminó con éxito."){
								window.location = "";
							}
						},
						error:function(err){
							$("#loading").hide();
							alert(err.responseText);
						}
					});
				}else{
					$(this).val("");
				}
			}
		}
	 });
	 }
	
</script>