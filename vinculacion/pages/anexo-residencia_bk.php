<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Anexo Residencia</title>
<link rel="icon" href="../images/favicon.ico" type="image/ico" />

<style type="text/css">
@import url("../css/main.css");

.custom-combobox-input{
	margin-left: 0 !important;
	padding-left: 0 !important;
}
</style>
<link rel="stylesheet" href="../css/menu.css" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css'/>
<link href="../css/jquery-ui.css" type="text/css" rel="stylesheet"/>
<link href="../css/theme.css" type="text/css" rel="stylesheet"/>   
	
<script src="../js/jquery.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../js/dependenciasAutocomplete.js"></script> <!-- crb01 -->
<script type="application/javascript" src="../js/dialogoConfirmacion.js"></script>
</head>
<body>
<div class="container">
  <div class="header">
  <?php include("../includes/admin_header.php"); ?>
  <br class="clearfloat" />
  <?php include("../includes/menu.php"); ?>
</div>


<span class="archive-title">Departamento de Gestión</span>
<h1 class="featured-title">Tecnológica y Vinculación</h1>
<h2 class="featured-title2">Anexo al Convenio Residencias Profesionales</h2>

<div class="content bg1">

<?php if (isset($_POST['insertado'])):?>
<?php $mensaje = $_POST['insertado'];?>
<?php $anexo = $_POST['imprimir'];?>
<?php $solicitud = $_POST['solicitud'];
	 $solicitud = strip_tags(str_replace(array("\r\n", "\r", "\n"), "", $solicitud));
	?>
<script language="JavaScript"> 
	var mensaje = '<?php echo $mensaje ?>';
	var imprimir = '<?php echo $anexo ?>';
	var numSolicitud = 0;

	if(/^\d+$/.test('<?php echo $solicitud?>')){
		numSolicitud = '<?php echo $solicitud?>';
	}

//	alert(mensaje);
//	window.location = "../index.php";
	_dialogo(mensaje,"../index.php");
	if (imprimir == "imprimir")
	{
		var url = "../functions/formatoAnexoResidencia.php?numSolicitud="+numSolicitud;
		window.open(url);
	}
</script>
<?php else:?>
<?php require_once '../functions/consulta.php';?>

<?php if ($validar != "0"):?>
	<?php if ($totalRows_datosAlumno == 0):?>
    <script language="JavaScript"> 
        var mensaje = 'No se encontraron datos';
//        alert(mensaje);
//        window.location = "../index.php";
		_dialogo(mensaje,"../index.php");
    </script>
    <?php endif;?>
<?php endif;?>

<?php if ($validar != "0" and $totalRows_datosAlumno != 0):?>
<div class="formSection2">
	
	<form action="../functions/insertar.php" method="post" onsubmit = "return validar()" name="frmGuardarSolicitud" id="frmGuardarSolicitud">
    <fieldset><legend style="font-weight: bold; margin-bottom:40px; margin-left:15%">Solcitud: Anexo al Convenio Residencias</legend>   
    <table style="margin-left: 20px;margin-right: 20px;" cellspacing="10">
    	<tr>
    		<td colspan="3">
    			<label class="formLabel2" for="idAlumno">Numero de Control:</label>
   	 			<input class="textbox2" name="idAlumno" type="text" style="text-align:left;margin-left: 0;" id="idAlumno" readonly="readonly" value="<?php echo $row_datosAlumno['idAlumno']; ?>"/>
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<label class="formLabel2" for="nombre">Nombre:</label>
   	 			<input class="textbox2" name="nombre" type="text" style="text-align:left" id="nombre" readonly="readonly" value="<?php echo $row_datosAlumno['nomAlumno']; ?>"/>
    		</td>
    		<td>
    			<label class="formLabel2" for="apPaterno">Apellido Paterno:</label>
   	 			<input class="textbox2" name="apPaterno" type="text" style="text-align:left" id="apPaterno" readonly="readonly" value="<?php echo $row_datosAlumno['apPaterno']; ?>"/>		
    		</td>
    		<td>
    			<label class="formLabel2" for="apMaterno">Apellido Materno:</label>
   	 			<input class="textbox2" name="apMaterno" type="text" style="text-align:left" id="apMaterno" readonly="readonly" value="<?php echo $row_datosAlumno['apMaterno']; ?>"/>
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<label class="formLabel2" for="edad">Edad:</label>
   	 			<input class="textbox2" name="edad" type="text" style="text-align:left" id="edad" readonly="readonly" value="<?php echo $row_datosAlumno['edad']; ?>"/>
    		</td>
    		<td>
    			<label class="formLabel2" for="sexo"/>Sexo:</label>
				<input type="radio" name="sexo" value="F" <?php if($row_datosAlumno['sexo'] == 'F'){echo 'checked="checked"';} ?> />Femenino
	        	<input type="radio" name="sexo" value="M" <?php if($row_datosAlumno['sexo'] == 'M'){echo 'checked="checked"';} ?> />Masculino
    		</td>
    		<td>
    			<label class="formLabel2" for="discapacidad">Padece alguna discapacidad?:</label>
				<input type="radio" name="discapacidad" value="Si"/>Si
	        	<input type="radio" name="discapacidad" style="margin-left: 30px;" value="No" checked="checked"/>No
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<label class="formLabel2" for="carrera">Carrera:</label>
   	 			<input class="textbox2" name="carrera" type="text" style="text-align:left" id="carrera" readonly="readonly" value="<?php echo $row_datosAlumno['carrera']; ?>"/>
    		</td>
    		<td>
    			<label class="formLabel2" for="semestre">Semestre:</label>
   	 			<input class="textbox2" name="semestre" type="text" style="text-align:left" id="semestre" readonly="readonly" value="<?php echo $row_datosAlumno['semestre']; ?>"/>
    		</td>
    		<td>
    			<label class="formLabel2" for="email">Email:</label>
   	 			<input required title="Ej. tuemail@mail.com" pattern="[A-Za-z0-9._%+-]{3,}@[a-zA-Z]{3,}([.]{1}[a-zA-Z]{2,}|[.]{1}[a-zA-Z]{2,}[.]{1}[a-zA-Z]{2,})" class="textbox2" name="email" readonly="readonly" type="text" style="text-align:left" id="email" value="<?php echo $row_datosAlumno['email']; ?>"/>
    		</td>
    		
    	</tr>
    	<tr>	
    		<td>
    			<label class="formLabel2" for="domicilioAlumno">Calle y Numero:</label>
   	 			<input required class="textbox2" name="domicilioAlumno" readonly="readonly" type="text" style="text-align:left" id="domicilioAlumno" value="<?php echo $row_datosAlumno['domicilio']; ?>"/>
    		</td>
    		<td>
    			 <label class="formLabel2" for="coloniaAlumno">Colonia:</label>
   	 			<input required class="textbox2" name="coloniaAlumno" type="text" readonly="readonly" style="text-align:left" id="coloniaAlumno" value="<?php echo $row_datosAlumno['colonia']; ?>"/>
    		</td>
    		<td>
				<label class="formLabel2" for="ciudad">Ciudad:</label>
				<input  class="textbox2" name="ciudad" readonly="readonly" type="text" style="text-align:left" id="ciudad" value="<?php echo $row_datosAlumno['ciudad']; ?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<label class="formLabel2" for="codigoDep">Código Postal:</label>
				<input class="textbox2" name="codigoDep" readonly="readonly" type="text" style="text-align:left" id="codigoDep" value="<?php echo $row_datosAlumno['codigo']; ?>"/>
			</td>   		
    		<td>
    			<label class="formLabel2" for="telefono">Teléfono (10 digitos):</label>
   	 			<input class="textbox2" required title="Ej. 6641234578" pattern="[0-9]{10,}" name="telefono" readonly="readonly" type="text" style="text-align:left;width: 200px;margin-left: 0;" id="telefono" value="<?php echo $row_datosAlumno['telefono']; ?>"/>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3">
<!--    			<label class="formLabel2" for="dependencias"> Datos de la Empresa:</label>-->
				<label class="formLabel2" for="dependencias">Datos de la Empresa:</label>
    		</td>	
    	</tr>
    	<tr>
    		<td colspan="3">
				<select required name="lstDependencias" id="lstDependencias">
					<option id="" value=""></option>
					<option id="otraDependencia" value="otraDependencia">Dar de Alta Nueva...</option>
					<?php while($row_datosDependencia = mysqli_fetch_assoc($datosDependencia)){ ?>
						<option id="dependencias" value="<?php echo $row_datosDependencia['idDependencia']; ?>"><?php echo $row_datosDependencia['nomDependencia']; ?></option>
					<?php }; ?>
				</select>
<!--    			<select name="lstDependencias" id="lstDependencias" class="formList" style="margin-left: 0" onchange="validarDependencia();">         -->
<!--		        --><?php //while($row_datosDependencia = mysqli_fetch_assoc($datosDependencia)){ ?>
<!--		        	<option id="dependencias" value="--><?php //echo $row_datosDependencia['idDependencia']; ?><!--">--><?php //echo $row_datosDependencia['nomDependencia']; ?><!--</option>-->
<!--		        --><?php //}; ?><!-- -->
<!--		        <option id="otraDependencia" value="otraDependencia">Otro...</option>-->
<!--		        </select>-->
    		</td>
    	</tr>
    	<tr>
	    	<td colspan="3">
	    		<div id="capturaDependencia" style="display:none">
	    			<table cellspacing="10">
	    				<tr>
	    					<td colspan="3">
	    					 	<label class="formLabel2" >Capture empresa:</label>
	    					</td>
	    				</tr>
	    				<tr>	
	    					<td>
	    						<label class="formLabel2" for="nuevaDependencia">Nombre completo:</label>
			   	 				<input class="textbox2" name="nuevaDependencia" type="text" style="text-align:left" id="nuevaDependencia" value=""/>
	    					</td>
	    					<td>
	    						<label class="formLabel2" for="nombreCorto">Nombre corto:</label>
			   	 				<input class="textbox2" name="nombreCorto" type="text" style="text-align:left" id="nombreCorto" value=""/>
	    					</td>
	    					<td>
	    						<label class="formLabel2" for="rfc">R.F.C.:</label>
			   	 				<input class="textbox2" name="rfc" type="text" style="text-align:left" id="rfc" value=""/>
	    					</td>	    				
	    				</tr>
	    				<tr>
	    					<td>
	    						 <label class="formLabel2">Giro:</label>
	    						 <select class="textbox2" name="giro" id="giro">
	    						 	<option value="Industrial">Industrial</option>
	    						 	<option value="Servicios">Servicios </option>
	    						 	<option value="Otro">Otro</option>
	    						 </select>
	    					</td>	
	    					<td>
	    						 <label class="formLabel2">Sector:</label>
	    						 <select class="textbox2" name="sector" id="sector">
	    						 	<option value="Publico">Público</option>
	    						 	<option value="Privado">Privado</option>
	    						 </select>
	    					</td>
	    					<td>
	    						<label class="formLabel2">Tipo:</label>
        						<input class="textbox2" name="tipo" type="text" style="text-align:left;" id="tipo" readonly="readonly" value="Empresa"/>
	    					</td>
	    				</tr> 
	    				<tr>	
				    		<td>
				    			<label class="formLabel2" for="domicilioDep">Domicilio:</label>
				   	 			<input  class="textbox2" name="domicilioDep" type="text" style="text-align:left" id="domicilioDep" value=""/>
				    		</td>
				    		<td>
				    			 <label class="formLabel2" for="coloniaDep">Colonia:</label>
				   	 			<input  class="textbox2" name="coloniaDep" type="text" style="text-align:left" id="coloniaDep" value=""/>
				    		</td>
				    		<td>
				    			<label class="formLabel2" for="ciudadDep">Ciudad:</label>
				   	 			<input  class="textbox2" name="ciudadDep" type="text" style="text-align:left" id="ciudadDep" value=""/>
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>
				    			<label class="formLabel2" for="codigoDep">Código Postal:</label>
				   	 			<input class="textbox2" name="codigoDep" type="text" style="text-align:left" id="codigoDep" value=""/>
				    		</td>    		
				    	</tr>   			
	    			</table>
	        	</div>
	    	</td>
    	</tr>
    	
    	<tr>
    		<td colspan="2">
    			<label class="formLabel2" for="area">Nombre del área donde presenta su residencia:</label>
   	 			<input required class="textbox2" name="area" type="text" style="text-align:left;width: 96%;" id="area" value=""/>
    		</td>
    		<td>
    			<label class="formLabel2" for="telefonoEmp">Teléfono y ext.:</label>
   	 			<input class="textbox2" required title="Ej. 6641234578" pattern="[0-9]{10,}" name="telefonoDependencia" type="text" style="text-align:left;width: 130px;margin-left: 0;" id="telefonoDependencia" onkeypress="return soloNumeros(event)" value=""/>
   	 			<input class="textbox2" title="" name="extension" type="text" style="text-align:left;width: 50px;margin-left: 0;" id="extEmp" value=""/>
    		</td>    	
    	</tr>
    	<tr>
    		<td colspan="2">
    			<label class="formLabel2" for="responsableDependencia">Titular de la empresa:</label>
   	 			<input required class="textbox2" name="responsableDependencia" type="text" style="text-align:left;width: 96%;" id="responsableDependencia" value=""/>
    		</td>
    		<td>
    			 <label class="formLabel2" for="puestoResponsable">Puesto:</label>
   	 			<input required class="textbox2" name="puestoResponsable" type="text" style="text-align:left;" id="puestoResponsable" value=""/>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="2">
    			<label class="formLabel2" for="nomAcuerdo">Nombre de la persona  que firmará el acuerdo de trabajo:</label>
   	 			<input required class="textbox2" name="nomAcuerdo" type="text" style="text-align:left;width: 96%;" id="nomAcuerdo" value=""/>
    		</td>
    		<td>
    			 <label class="formLabel2" for="puestoAcuerdo">Puesto:</label>
   	 			<input required class="textbox2" name="puestoAcuerdo" type="text" style="text-align:left" id="puestoAcuerdo" value=""/>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="2">
    			<label class="formLabel2" for="emailDependencia">Correo Electrónico:</label>
   	 			<input title="Ej. tuemail@mail.com" pattern="[A-Za-z0-9._%+-]{3,}@[a-zA-Z]{3,}([.]{1}[a-zA-Z]{2,}|[.]{1}[a-zA-Z]{2,}[.]{1}[a-zA-Z]{2,})" class="textbox2" name="emailDependencia" type="text" style="text-align:left;width: 96%;" id="emailDependencia" value=""/>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3">
    			 <label class="formLabel2" for="mision">Misión de la empresa:</label>
   	 			<input required class="textbox2" name="mision" type="text" style="text-align:left;width: 96%;" id="mision" value=""/>
    		</td>
    	</tr>
    	<tr>	
    		<td colspan="3">
    			<label class="formLabel2">Datos Complementarios:</label>
    		</td>
    	</tr>
    	<tr>
    		<td>
	    		<label class="formLabel2" for="fechaInicio">Nombre del proyecto:</label>
	        	<input required="required" maxlength="150" class="textbox2" type="text" id="nomProy" name="nomProy"  value=""/><br />
	    	</td>
    		<td>
	    		<label class="formLabel2" for="fechaTermino">Periodo Proyectado:</label>
        		<input required="required" class="textbox2" type="text" id="perProy" name="perProy" value=""/><br />
	    	</td>
	    	<td>
	    		<label class="formLabel2" for="fechaTermino">Número de Residentes:</label>
        		<input required="required" class="textbox2" type="text" id="numRes" name="numRes" onkeypress="return soloNumeros(event)"/><br />
	    	</td>
    	</tr>
    	<tr>
    		<td>
	    		<label class="formLabel2" for="fechaInicio">Opción Elegida:</label>
	    	</td>
    	</tr>
    	<tr>
    		<td>
    			<input type="radio" name="opcion" value="1" checked="checked"/>	Banco de Proyectos
    		</td>
    		<td>
    			<input type="radio" name="opcion" value="2" />	Propuesta propia
    		</td>
    		<td>
    			<input type="radio" name="opcion" value="3" />	Trabajador
    		</td>
    	</tr>
    	<tr>
	    	<td>
	    		<label class="formLabel2" for="fechaInicio">Fecha de Inicio:</label>
	        	<input required="required" class="textbox2" type="text" id="fechaInicio" name="fechaInicio"  value=""/><br />
	    	</td>
    		<td>
	    		<label class="formLabel2" for="fechaTermino">Fecha de T&eacute;rmino:</label>
        		<input required="required" class="textbox2" type="text" id="fechaTermino" name="fechaTermino" value=""/><br />
	    	</td>
    	
    	</tr>
    	<tr>
    		<td>
    			<label class="formLabel2" for="horario">Horario del Residente en la Empresa:</label>
				<input required class="textbox2" name="horario" type="text" style="text-align:left" id="horario" value=""/>
    		</td>
    		<td>
    			<label class="formLabel2">Días en que se Presentara en la Empresa:</label>
    			<input required class="textbox2" name="dias" type="text" style="text-align:left" id="dias" value=""/>
			</td>
			<td>
				<label class="formLabel2" for="fechaReporte">Fecha de Entrega de Reporte de Residencias:</label>
   	 			<input required class="textbox2" name="fechaReporte" type="text" style="text-align:left" id="fechaReporte" value=""/>
			</td>
    	</tr>
    	<tr>
    		<td colspan="3">
				<label class="formLabel2" for="pago">Por concepto de apoyo económico el residente recibirá mensualmente la cantidad de:</label>
   	 			<input class="textbox2" name="pago" type="text" style="text-align:left;;width: 96%;" id="pago" value=""/>
			</td>
		</tr>
    	<tr>
    		<td colspan="3">
				<label class="formLabel2" for="importe">Importe con Letra:</label>
   	 			<input class="textbox2" name="importe" type="text" style="text-align:left;;width: 96%;" id="importe" value=""/>
			</td>
    	</tr>
		<tr>
			<td>
				<label class="formLabel2" for="carrera">En caso de emergencia acudir a:</label>
				<select required class="textbox2" name="emergencias" style="text-align:left" id="emergencias">
					<option value="1">IMSS</option>
					<option value="2">ISSTE</option>
					<option value="3">OTRO</option>
					</select>
			</td>

		</tr>
    </table>
    <input name="tipoSolicitud" type="hidden" value="anexo-residencia"/>
	<input name="enviar" type="submit" id="enviar" class="enviar" value="Enviar"/>        
	<input name="cancelar" type="button" id="cancelar" class="cancelar" value="Cancelar" onclick="location.href='../index.php'"/>
	</fieldset>
	</form>   
</div>
<?php endif;?>
<?php endif;?>

<script language="JavaScript"> 
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () 
  {
    $( "#fechaInicio" ).datepicker({
		defaultDate: "+1w",
		dateFormat:"yy-mm-dd",
      	changeMonth: true,//this option for allowing user to select month
      	changeYear: true, //this option for allowing user to select from year range
		onClose: function( selectedDate ) 
		{
			$( "#fechaTermino" ).datepicker( "option", "minDate", selectedDate );
		}
    });
	
	$( "#fechaTermino" ).datepicker({
		defaultDate: "+1w",
		dateFormat:"yy-mm-dd",
	    changeMonth: true,//this option for allowing user to select month
    	changeYear: true, //this option for allowing user to select from year range
		onClose: function( selectedDate ) 
		{
			$( "#fechaInicio" ).datepicker( "option", "maxDate", selectedDate );
		}
    });

	$( "#fechaReporte" ).datepicker({
		defaultDate: "+1w",
		dateFormat:"yy-mm-dd",
	    changeMonth: true,//this option for allowing user to select month
    	changeYear: true, //this option for allowing user to select from year range
		onClose: function( selectedDate ) 
		{
			$( "#fechaTermino" ).datepicker( "option", "maxDate", selectedDate );
		}
    });
  }

);
function validarDependencia()
{
	var validar = $('#lstDependencias').val(); //crb01
//	var validar = document.getElementById("lstDependencias").value;
	var nueva = document.getElementById("nuevaDependencia").value;
	var giro = document.getElementById("giro").value;
	var sector = document.getElementById("sector").value;
	
	if (validar == "otraDependencia")
	{
		document.getElementById("capturaDependencia").style.display = "inline";	
		document.getElementById("nuevaDependencia").value = nueva;	
		document.getElementById("nuevaDependencia").setAttribute("required","true");

		document.getElementById("nuevaDependencia").setAttribute("required","true");
		document.getElementById("nombreCorto").setAttribute("required","true");
		document.getElementById("rfc").setAttribute("required","true");
		document.getElementById("giro").setAttribute("required","true");
		document.getElementById("tipo").setAttribute("required","true");
		document.getElementById("domicilioDep").setAttribute("required","true");
		document.getElementById("coloniaDep").setAttribute("required","true");
		document.getElementById("ciudadDep").setAttribute("required","true");
		document.getElementById("codigoDep").setAttribute("required","true");

	}
	else
	{
		document.getElementById("capturaDependencia").style.display = "none";
		document.getElementById("nuevaDependencia").value = "";
		document.getElementById("nuevaDependencia").removeAttribute("required");

		document.getElementById("nuevaDependencia").removeAttribute("required");
		document.getElementById("nombreCorto").removeAttribute("required");
		document.getElementById("rfc").removeAttribute("required");
		document.getElementById("giro").removeAttribute("required");
		document.getElementById("tipo").removeAttribute("required");
		document.getElementById("domicilioDep").removeAttribute("required");
		document.getElementById("coloniaDep").removeAttribute("required");
		document.getElementById("ciudadDep").removeAttribute("required");
		document.getElementById("codigoDep").removeAttribute("required");
	}
}
function soloNumeros(e)
{
	var key = window.Event ? e.which : e.keyCode
	return (key >= 48 && key <= 57)
}

function validar()
{
	if (confirm("Una vez enviada la solicitud esta no podra ser corregida. ¿Seguro que desea continuar?"))
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>
</div>

<br class="clearfloat" />

<div class="footer"><?php include("../includes/admin_footer.php"); ?>
</div>
</div>
</body>
</html>
