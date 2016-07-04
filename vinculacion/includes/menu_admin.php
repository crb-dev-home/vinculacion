<div class="nav_section">
	<div id="menu">
		<ul>  			
   			<li class="nivel1"><a href="solicitudes.php" class="nivel1">Solicitudes</a></li>
   			<li class="nivel1"><a href="reporteador.php" class="nivel1">Reportes</a></li>
   			<li class="nivel1"><a href="" class="nivel1">Catálogos</a>
   				<ul>
   					<li class="nivel2"><a href="javascript:void(0);" onclick="habilitar();" class="nivel2">Usuarios</a></li>
            		<li class="nivel2"><a href="dependencias.php" class="nivel2">Dependencias</a></li> 
            		<li class="nivel2"><a href="mttoAlumnos.php" class="nivel2">Alumnos</a></li>  				
   				</ul>		
   			</li>
			<li class="nivel1"><a href="" class="nivel1">Configuraciónes</a>
				<ul style="width: 200px">
					<li class="nivel2" style="width: 200px"><a href="javascript:void(0);" onclick="dialogAseguradora.dialog('open');" >Aseguradora</a></li>
					<li class="nivel2" style="width: 200px"><a href="javascript:void(0);" onclick="dialogCoordinadorBeca.dialog('open');" >Coordinador de Becas</a></li>
					<li class="nivel2" style="width: 200px"><a href="javascript:void(0);" onclick="dialogLeyendaAnual.dialog('open');" >Leyenda Anual</a></li>
					<li class="nivel2" style="width: 200px"><a href="javascript:void(0);" onclick="dialogFechas.dialog('open');" >Periodo Becas</a></li>
				</ul>
			</li>
        </ul>
	</div>
    <div id = "usuario">
    	<?php echo $_SESSION['usuario'];?><br />
        <a href="logout.php">Cerrar Sesi&oacute;n</a>
    </div>
 </div>
 
<div id="configurarFecha" title="Fechas Beca">
	<input style="height:0px; border:none"/> <!-- CRB01 evitar que se habra el datepicker al abrir el dialogo -->
	<p style="margin-left: 37px;" class="validarFecha">Fechas del periodo actual.</p>
 	<form>
 			<label style="margin-left: 50px; " class="formLabel" for="fechaInicioBeca">Fecha de Inicio:</label>
        	<input style="margin-left: 50px; text-align: center;" required="required" type="text" id="fechaInicioBeca" name="fechaInicioBeca" value=""/><br />
         
        	<label style="margin-left: 50px;" class="formLabel" for="fechaTerminoBeca">Fecha de T&eacute;rmino:</label>
        	<input style="margin-left: 50px; text-align: center;" required="required" type="text" id="fechaTerminoBeca" name="fechaTerminoBeca" value=""/>
    </form>
</div>

<!--crb01 -->
<div id="configurarLeyendaAnual" title="Leyenda Anual en Formatos">
	<p style="margin-left: 20px; width: 200px" class="validadorLeyenda">Leyenda para el a&ntilde;o en curso</p>
	<form>
		<input maxlength="100" style="margin-left: 35px; text-align: center; width: 400px" required="required" type="text" id="leyendaAnual" name="leyendaAnual" value=""/><br />
	</form>
</div>

<!--crb01 -->
<div id="configurarCoordinadorBeca" title="Coordinador Nacional de Becas">
	<p style="margin-left: 20px; width: 300px" class="validadorCoordinador">Coordinador en curso (incluyendo Titulo):</p>
	<form>
		<input maxlength="50" style="margin-left: 35px; text-align: center; width: 400px" required="required" type="text" id="coordinadorBecas" name="coordinadorBecas" value=""/><br />
	</form>
</div>

<div id="configurarAseguradora" title="Datos Aseguradora Actual">
	<input style="height:0px; border:none"/> <!-- CRB01 evitar que se habra el datepicker al abrir el dialogo -->
	<p style="margin-left: 20px; width: 200px" class="validadorAseguradora">Datos Aseguradora</p>
	<form>
		<label style="margin-left: 35px;" class="formLabel" for="nombreAseguradora">Nombre de Aseguradora:</label>
		<input maxlength="100" style="margin-left: 35px; text-align: center; width: 400px" required="required" type="text" id="nombreAseguradora" name="nombreAseguradora" value=""/><br />

		<label style="margin-left: 35px;" class="formLabel" for="polizaAseguradora">Poliza de Seguro:</label>
		<input maxlength="100" style="margin-left: 35px; text-align: center;" required="required" type="text" id="polizaAseguradora" name="polizaAseguradora" value=""/><br />
	</form>
</div>

 <script>
 var CONFIG_INICIO_BECA = 'FECHA_INICIO_BECA';
 var CONFIG_TERMINO_BECA = 'FECHA_FIN_BECA';
 var CONFIG_LEYENDA_ANUAL_FORMATO = 'LEYENDA_ANUAL_FORMATOS';
 var CONFIG_COORDINADOR_NACIONAL_BECAS= 'COORDINADOR_NACIONAL_BECAS';
 var CONFIG_NOMBRE_ASEGURADORA = 'NOMBRE_ASEGURADORA';
 var CONFIG_POLIZA_ASEGURADORA = 'POLIZA_ASEGURADORA';

 var fInicio = $("#fechaInicioBeca"),
 fTermino = $("#fechaTerminoBeca"),
 //allFieldsFecha = $(".ui-state-error");//$( [] ).add( fInicio ).add( fTermino )
 tipsFecha = $( ".validarFecha" );
 tipsLeyenda = $( ".validadorLeyenda" );
 tipsAseguradora = $(".validadorAseguradora");
 tipsCoordinadorBecas = $(".validadorCoordinadorBecas");
	
 dialogFechas = $("#configurarFecha").dialog ({
     autoOpen : false,
     height: 250,
     width: 300,
     modal:true,
     resizable: false,
     buttons: { 
     	 "Guardar": guardar,
         "Cancelar": function() {
        	 dialogFechas.dialog( "close" );
 		},
     },
 	close: function() {
 		formGuardar[ 0 ].reset();
		limpiaCamposValidados();
		 },
	 open: function( event, ui ) {
		mostrarFechas();
	 }
 	});

      formGuardar = dialogFechas.find("form").on("submit", function( event ) {
     	event.preventDefault();
     	guardar();
     	
 	});

 function limpiaCamposValidados(){
	 $(".ui-state-error").removeClass("ui-state-error");
 }
 /**
  * crb01 dialogo para leyenda anual en formatos
  * */
 dialogLeyendaAnual= $("#configurarLeyendaAnual").dialog ({
	 autoOpen : false,
	 height: 200,
	 width: 500,
	 modal:true,
	 resizable: false,
	 buttons: {
		 "Guardar": guardarLeyenda,
		 "Cancelar": function() {
			 dialogLeyendaAnual.dialog( "close" );
		 },
	 },
	 close: function() {
		 formLeyendaGuardar[ 0 ].reset();
		 limpiaCamposValidados();
	 },
	 open: function( event, ui ) {
		 mostrarLeyenda();
	 }
 });

 formLeyendaGuardar = dialogLeyendaAnual.find("form").on("submit", function( event ) {
	 event.preventDefault();
	 guardarLeyenda();

 });


 /**
  * crb01 dialogo para leyenda anual en formatos
  * */
 dialogCoordinadorBeca= $("#configurarCoordinadorBeca").dialog ({
	 autoOpen : false,
	 height: 200,
	 width: 500,
	 modal:true,
	 resizable: false,
	 buttons: {
		 "Guardar": guardarCoordinadorBecas,
		 "Cancelar": function() {
			 dialogCoordinadorBeca.dialog( "close" );
		 },
	 },
	 close: function() {
		 formCoordinadorGuardar[ 0 ].reset();
		 limpiaCamposValidados();
	 },
	 open: function( event, ui ) {
		 mostrarCoordinadorBecas();
	 }
 });

 formCoordinadorGuardar = dialogCoordinadorBeca.find("form").on("submit", function( event ) {
	 event.preventDefault();
	 guardarCoordinadorBecas();

 });


 /**
  * crb01 dialogo para leyenda anual en formatos
  * */
 dialogAseguradora= $("#configurarAseguradora").dialog ({
	 autoOpen : false,
	 height: 250,
	 width: 500,
	 modal:true,
	 resizable: false,
	 buttons: {
		 "Guardar": guardarAseguradora,
		 "Cancelar": function() {
			 dialogAseguradora.dialog( "close" );
		 },
	 },
	 close: function() {
		 formAseguradoraGuardar[ 0 ].reset();
		 limpiaCamposValidados();
	 },
	 open: function( event, ui ) {
		 mostrarAseguradora();
	 }
 });

 formAseguradoraGuardar = dialogAseguradora.find("form").on("submit", function( event ) {
	 event.preventDefault();
	 guardarAseguradora();

 });

 /**
 * crb01 consulta de configuraciones
 * */
 function buscarConfiguracion(id){
	 var configuracion = '';
	 var data = {accion: "consultar", idConfiguracion: id};
	 $.ajax({
		 url: '../functions/configuracionesFunciones.php',
		 type: 'POST',
		 dataType: 'json',
		 async:false,
		 data: data,
		 success: function(resp)
		 {
			 if (resp.valor){
				 configuracion = resp.valor;
			 }
		 },
		 error: function(e)
		 {
			 console.log(e.responseText);
		 }
	 });

	 return configuracion;
 }

 /**
  * crb01 actualizar configuraciones
  * */
 function guardarConfiguracion(id,valor){
	 var data = {accion: "guardar", idConfiguracion: id, valorConfiguracion: valor};
	 var resp = '';
	 $.ajax({
		 url: '../functions/configuracionesFunciones.php',
		 type: 'POST',
		 dataType: 'json',
		 data: data,
		 async:false,
		 success: function(s)
		 {
			 resp = s;
		 },
		 error: function(e)
		 {
			 console.log(e.responseText);
		 }
	 });
	 return resp;
 }

 /**
  * crb01 mostrar fechas configuradas
  * */
 function mostrarFechas(){
	 var inicioBeca = buscarConfiguracion(CONFIG_INICIO_BECA);
	 fInicio.datepicker( "setDate", inicioBeca );

	 var finBeca = buscarConfiguracion(CONFIG_TERMINO_BECA);
	 fTermino.datepicker( "setDate", finBeca );
 }

 /**
  * crb01 mostrar fechas configuradas
  * */
 function mostrarLeyenda(){
	 var leyendaActual = buscarConfiguracion(CONFIG_LEYENDA_ANUAL_FORMATO);
	 if(leyendaActual){
		 $('#leyendaAnual').val(leyendaActual);
	 }

 }


 /**
  * crb01 nombre coordinador becas configurado
  * */
 function mostrarCoordinadorBecas(){
	 var coordinadorActual = buscarConfiguracion(CONFIG_COORDINADOR_NACIONAL_BECAS);
	 if(coordinadorActual){
		 $('#coordinadorBecas').val(coordinadorActual);
	 }

 }
 /**
  * crb01 mostrar aseguradora configuradas
  * */
 function mostrarAseguradora(){
	 var poliza = buscarConfiguracion(CONFIG_POLIZA_ASEGURADORA);
	 var nombre = buscarConfiguracion(CONFIG_NOMBRE_ASEGURADORA);

	 if(poliza){
		 $('#polizaAseguradora').val(poliza);
	 }

	 if(nombre){
		 $('#nombreAseguradora').val(nombre);
	 }

 }

 function habilitar()
 {
	 var usuario = "<?php echo $_SESSION['usuario'];?>";
	 var url = "mttoUsuarios.php";
	 
	 if (usuario == "Administrador")
	 {
		 window.open(url,"_self");
	 }
	 else
	 {
		 alert("No tienes permisos");
	 }
 } 

 $( "#fechaInicioBeca" ).datepicker({
		defaultDate: "+1w",
		dateFormat:"yy-mm-dd",
  		changeMonth: true,//this option for allowing user to select month
  		changeYear: true, //this option for allowing user to select from year range
		onClose: function( selectedDate ) 
		{
			$( "#fechaTerminoBeca" ).datepicker( "option", "minDate", selectedDate );
		}
});
	
	$( "#fechaTerminoBeca" ).datepicker({
		defaultDate: "+1w",
		dateFormat:"yy-mm-dd",
	    changeMonth: true,//this option for allowing user to select month
		changeYear: true, //this option for allowing user to select from year range
		onClose: function( selectedDate ) 
		{
			$( "#fechaInicioBeca" ).datepicker( "option", "maxDate", selectedDate );
		}
});

 /**
  * crb01 guardar leyenda anual
  * */
 function guardarLeyenda(){
	 var input = $('#leyendaAnual');

//	 if(validarInput(input,"Capture la leyenda",tipsLeyenda)) { //crb01 permitir leyenda vacia
		 var resp = guardarConfiguracion(CONFIG_LEYENDA_ANUAL_FORMATO, input.val());

		 if (resp.mensaje) {
			 alert(resp.mensaje);
		 }
		 dialogLeyendaAnual.dialog("close");
//	 }
 }

 /**
  * crb01 guardar coordinador
  * */
 function guardarCoordinadorBecas(){
	 var input = $('#coordinadorBecas');

	 if(validarInput(input,"Capture el nombre del coordinador",tipsCoordinadorBecas)) {
		 var resp = guardarConfiguracion(CONFIG_COORDINADOR_NACIONAL_BECAS, input.val());

		 if (resp.mensaje) {
			 alert(resp.mensaje);
		 }
		 dialogCoordinadorBeca.dialog("close");
	 }
 }

 /**
  * crb01 guardar leyenda anual
  * */
 function guardarAseguradora(){
	 var poliza = $('#polizaAseguradora');
	 var nombre = $('#nombreAseguradora');

	 if(validarAseguradora(poliza,nombre)) {
		 var resp = guardarConfiguracion(CONFIG_NOMBRE_ASEGURADORA, nombre.val());
		 resp = guardarConfiguracion(CONFIG_POLIZA_ASEGURADORA, poliza.val());

		 if (resp.mensaje) {
			 alert(resp.mensaje);
		 }
		 dialogAseguradora.dialog("close");
	 }
 }


 function validarAseguradora(poliza,nombre){
	/* var inputNombre = $('#nombreAseguradora');
	 var inputPoliza = $('#polizaAseguradora');*/

	 if (nombre.val() == "")
	 {
		 nombre.addClass( "ui-state-error" );
		 updateTips("Capture el nombre",tipsAseguradora);
		 return false;
	 }
	 else if (poliza.val() == "")
	 {
		 poliza.addClass( "ui-state-error" );
		 updateTips("Capture la poliza",tipsAseguradora);
		 return false;
	 }
	 else
	 {
		 return true;
	 }

 }

// function validarLeyenda(input){
//
//	 if (input.val() == "")
//	 {
//		 input.addClass( "ui-state-error" );
//		 updateTips("Capture la leyenda",tipsLeyenda);
//		 return false;
//	 }
//	 else
//	 {
//		 return true;
//	 }
// }

 function validarInput(input,mensaje,tip){

	 if (input.val() == "")
	 {
		 input.addClass( "ui-state-error" );
		 updateTips(mensaje,tip);
		 return false;
	 }
	 else
	 {
		 return true;
	 }
 }

 function guardar(){
	 var fechaIni =  document.getElementById("fechaInicioBeca").value;
	 var fechaFin =  document.getElementById("fechaTerminoBeca").value;
	 var valido = true;


	 valido = valido && checkDate(fInicio, fTermino);

	 if (valido)
	 {
		var resp = guardarConfiguracion(CONFIG_INICIO_BECA,fechaIni);
		resp = guardarConfiguracion(CONFIG_TERMINO_BECA,fechaFin);
		if(resp.mensaje) {
			 alert(resp.mensaje);
		}
		dialogFechas.dialog( "close" );
	 }


 }

function checkDate(i, t)
{
	if (i.val() == "")
	{
		i.addClass( "ui-state-error" );
		updateTipsFecha("Capture fecha inicio");
		return false;
	}
	else if (t.val() == "")
	{
		t.addClass( "ui-state-error" );
		updateTipsFecha("Capture fecha termino");
		return false;
	}
	else
	{
		return true;
	}
}
function updateTipsFecha( t ) 
{
	tipsFecha
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
    	  tipsFecha.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
}
//crb01
function updateTips(tip,validador){

	validador
		.text( tip )
		.addClass( "ui-state-highlight" );
	setTimeout(function() {
		validador.removeClass( "ui-state-highlight", 1500 );
	}, 500 );
}

  
 </script>