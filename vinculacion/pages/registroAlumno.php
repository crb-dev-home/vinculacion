<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Registro Alumno</title>
<link rel="icon" href="../images/favicon.ico" type="image/ico" />

<style type="text/css">
@import url("../css/main.css");
</style>
<link rel="stylesheet" href="../css/menu.css" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css'/>
<link href="../css/jquery-ui.css" type="text/css" rel="stylesheet"/>
<link href="../css/theme.css" type="text/css" rel="stylesheet"/>   
	
<script src="../js/jquery.js"></script>
<script src="../js/jquery-ui.js"></script>
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
<h2 class="featured-title2">Registro de Alumno</h2>
<div class="content bg1">
<?php 
	require_once '../connections/conexion.php';
	$query_datosCarrera = sprintf("SELECT * FROM tblcarreras ");
	$datosCarrera = mysqli_query($conexion, $query_datosCarrera) or die(mysqli_error($conexion));
	//mysqli_close($conexion);

?>
	<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

	$id 				= $_POST['idAlumno'];
	$nombre 			= $_POST['nombre'];
	$apPaterno 			= $_POST['apPaterno'];
	$apMaterno			= $_POST['apMaterno'];
	$fechaNacimiento	= $_POST['fechaNacimiento'];
	$sexo 				= $_POST['sexo'];
	$seguroSocial       = $_POST['seguroSocial'];
	$curp 				= $_POST['curp'];
	$domicilioAlumno 	= $_POST['domicilioAlumno'];
	$coloniaAlumno 		= $_POST['coloniaAlumno'];
	$ciudad 			= $_POST['ciudad'];
	$codigoDep 			= $_POST['codigoDep'];
	$telefono 			= $_POST['telefono'];
	$email 				= $_POST['email'];
	$carrera 			= $_POST['lstCarreras'];
	$semestre 			= $_POST['semestre'];
	$creditos 			= $_POST['creditos'];
	
	
	//require_once '../connections/conexion.php';
	//Datos Alumno
	$query_insert = sprintf("INSERT INTO tblalumnos (idAlumno, nomAlumno, apPaterno, apMaterno, fechaNacimiento, sexo,nss, curp, carrera, email, telefono, domicilio, colonia, codigo, semestre, creditos, ciudad) 
			VALUES ('$id', '$nombre', '$apPaterno', '$apMaterno', '$fechaNacimiento', '$sexo','$seguroSocial', '$curp', '$carrera', '$email', '$telefono', '$domicilioAlumno', '$coloniaAlumno', '$codigoDep', '$semestre', '$creditos', '$ciudad')");
	$resp = mysqli_query($conexion, $query_insert) or die(mysqli_error($conexion));
	mysqli_close($conexion);
	if($resp == 1){
?>
<script language="JavaScript"> 
        var mensaje = 'Registro realizado';
		alert(mensaje);
		/**
		 * crb01 añadir validacion para redireccionar a opcion inicial.
         */
		var tipoSolicitud= "<?php echo $_GET['tipo']?>";

		if(tipoSolicitud==="servicio"){
			window.location = "servicio-social.php?numControl=<?php echo $_GET['numControl']?>&tipo=<?php echo $_GET['tipo']?>";
		}else if(tipoSolicitud==="residencia"){
			window.location = "residencia.php?numControl=<?php echo $_GET['numControl']?>&tipo=<?php echo $_GET['tipo']?>";
		}else if(tipoSolicitud==="practicas"){
			window.location = "practicas.php?numControl=<?php echo $_GET['numControl']?>&tipo=<?php echo $_GET['tipo']?>";
		}else if(tipoSolicitud==="alumnos"){
			window.location = "beca-alumnos.php?numControl=<?php echo $_GET['numControl']?>&tipo=<?php echo $_GET['tipo']?>";
		}else if(tipoSolicitud==="egresados"){
			window.location = "beca-egresados.php?numControl=<?php echo $_GET['numControl']?>&tipo=<?php echo $_GET['tipo']?>";
		}else if(tipoSolicitud==="constancia"){
			window.location = "constancia.php?numControl=<?php echo $_GET['numControl']?>&tipo=<?php echo $_GET['tipo']?>";
		}else if(tipoSolicitud==="anexo") {
			window.location = "anexo-residencia.php?numControl=<?php echo $_GET['numControl']?>&tipo=<?php echo $_GET['tipo']?>";
		}else {
			window.location = "../index.php?band=true&id=<?php echo $id?>";
		}
    </script>
<?php 		
	}
}
?>
	<div class="formSection2">		
		<form method="post" name="frmGuardarAlumno" id="frmGuardarAlumno">
	    <table style="margin-left: 20px;margin-right: 20px;" cellspacing="10">
	    	<tr>
	    		<td colspan="3">
	    			<label class="formLabel2" style="color: blue;">No existe registro del alumno, para continuar registre información:</label>
	    		</td>
	    	</tr>
	    	<tr><td style="height: 10px;"></td></tr>
	    	<tr>
	    		<td colspan="3">
	    			<label class="formLabel2" for="idAlumno">Numero de Control:</label>
	   	 			<input class="textbox2" size="30" name="idAlumno" required type="text" style="text-align:left;margin-left: 0;" maxlength="8" value="<?php echo $_GET['numControl']?>" readonly="readonly"/>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			<label class="formLabel2" for="nombre">Nombre:</label>
	   	 			<input class="textbox2" name="nombre" required type="text" style="text-align:left;text-transform: uppercase" onchange="this.value = this.value.toUpperCase();" maxlength="30"/>
	    		</td>
	    		<td>
	    			<label class="formLabel2" for="apPaterno">Apellido Paterno:</label>
	   	 			<input class="textbox2" name="apPaterno" required type="text" style="text-align:left;text-transform: uppercase" onchange="this.value = this.value.toUpperCase();" id="apPaterno" maxlength="30"/>
	    		</td>
	    		<td>
	    			<label class="formLabel2" for="apMaterno">Apellido Materno:</label>
	   	 			<input class="textbox2" name="apMaterno" type="text" style="text-align:left;text-transform: uppercase" onchange="this.value = this.value.toUpperCase();" id="apMaterno"  maxlength="30"/>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
		    		<label class="formLabel2" for="fechaNacimiento">Fecha de Nacimiento:</label>
		        	<input required="required" class="textbox2" type="text" id="fechaNacimiento" name="fechaNacimiento"  value=""/><br/>
		    	</td>
	    		<td>
	    			<label class="formLabel2" for="sexo"/>Sexo:</label>
					<input type="radio" name="sexo" value="F" checked="checked"/>Femenino
		        	<input type="radio" name="sexo" value="M" />Masculino
	    		</td>	    		
<!--	    		<td>-->
<!--	    			<label class="formLabel2" for="curp">CURP:</label>-->
<!--   	 				<input required title="Debe ser de 18 caracteres" pattern=".{18,}" maxlength="18" class="textbox2" name="curp" type="text" style="text-align:left;text-transform: uppercase" onkeyup="this.value = this.value.toUpperCase();" id="curp" /><span><a href="javascript:consultarCURP()"><img height="35px" width="35px" style="margin-left:5px" src="../images/curp.png" title="Consulta Curp"/></a></span>-->
<!--	    		</td>-->
	    	</tr>
			<tr>
				<td colspan="3">
				<table width="100%">
					<tr>
				<td colspan="2"  width="50%">
					<label class="formLabel2" for="seguroSocial">Numero de Seguro Social (si se cuenta con):</label>
					<input class="textbox2" style="text-align:left" name="seguroSocial" type="text" maxlength="11"  pattern=".{11,}"  id="seguroSocial" onkeypress="return soloNumeros(event)" value=""/><span><a href="javascript:consultarIMSS()"><img height="35px" width="35px" style="margin-left:15px" src="../images/imss.png" title="Consulta Curp"/></a></span>
				</td>

				<td  colspan="2"  width="50%">
					<label class="formLabel2" for="curp">CURP:</label>
					<input required title="Debe ser de 18 caracteres" pattern=".{18,}" maxlength="18" class="textbox2" name="curp" type="text" style="text-align:left;text-transform: uppercase" onkeyup="this.value = this.value.toUpperCase();" id="curp" /><span><a href="javascript:consultarCURP()"><img height="35px" width="35px" style="margin-left:15px" src="../images/curp.png" title="Consulta Curp"/></a></span>
				</td>
						</tr>
					</table>
				</td>

			</tr>
	    	<tr>	
	    		<td>
	    			<label class="formLabel2" for="domicilioAlumno">Calle y Numero:</label>
	   	 			<input required class="textbox2" name="domicilioAlumno" type="text" style="text-align:left" id="domicilioAlumno" maxlength="50"/>
	    		</td>
	    		<td>
	    			 <label class="formLabel2" for="coloniaAlumno">Colonia:</label>
	   	 			<input required class="textbox2" name="coloniaAlumno" type="text" style="text-align:left" id="coloniaAlumno" maxlength="50" />
	    		</td>
	    		<td>
					<label class="formLabel2" for="ciudad">Ciudad:</label>
					<input required class="textbox2" name="ciudad" type="text" style="text-align:left" id="ciudad" maxlength="20"/>
				</td>
			</tr>
			<tr>
				<td>
					<label class="formLabel2" for="codigoDep">Código Postal:</label>
					<input required class="textbox2" name="codigoDep" type="text" style="text-align:left" id="codigoDep" maxlength="20"/>
				</td>   		
	    		<td>
	    			<label class="formLabel2" for="telefono">Teléfono (10 digitos):</label>
	   	 			<input class="textbox2" required title="Ej. 6641234578" pattern="[0-9]{10,}" name="telefono" type="text" style="text-align:left;width: 200px;margin-left: 0;" id="telefono" maxlength="10" onkeypress="return soloNumeros(event)"/>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td colspan="3">
	    			<label class="formLabel2" for="email">Email:</label>
	   	 			<input required title="Ej. tuemail@mail.com" pattern="[A-Za-z0-9._%+-]{3,}@[a-zA-Z]{3,}([.]{1}[a-zA-Z]{2,}|[.]{1}[a-zA-Z]{2,}[.]{1}[a-zA-Z]{2,})" class="textbox2" name="email" type="text" style="text-align:left" id="email"/>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			<label class="formLabel2" for="carrera">Carrera:</label>
	    			<select name="lstCarreras" id="lstCarreras" class="formList" style="margin-left: 0;width: 200px;" required>         
			        <?php while($row_Carrera = mysqli_fetch_assoc($datosCarrera)){?>
			        	<option id="carreras" value="<?php echo $row_Carrera['idCarrera']; ?>"><?php echo $row_Carrera['nomCarreraLargo']; ?></option>
			        <?php }; ?> 
			        </select>
	    		</td>
	    		<td>
	    			<label class="formLabel2" for="semestre">Semestre:</label>
	   	 			<input required class="textbox2" name="semestre" type="text" style="text-align:left" id="semestre" onkeypress="return soloNumeros(event)" maxlength="2"/>
	    		</td>
	    		<td>
	    			<label class="formLabel2" for="creditos">Creditos:</label>
	   	 			<input required class="textbox2" name="creditos" type="text" style="text-align:left" id="creditos" onkeypress="return soloNumeros(event)" maxlength="3"/>
	    		</td>
	    		
	    	</tr>
	    	
	    </table>
		<input name="enviar" type="submit" id="enviar" class="enviar" value="Registrar"/>        
		<input name="cancelar" type="button" id="cancelar" class="cancelar" value="Cancelar" onclick="location.href='../index.php'"/>
		</form>   
	</div>
<script language="JavaScript"> 
$(document).ready(
  
  /* This is the function that will get executed after the DOM is fully loaded */
  function () 
  {
    $( "#fechaNacimiento" ).datepicker({
		defaultDate: "+1w",
		dateFormat:"yy-mm-dd",
      	changeMonth: true,//this option for allowing user to select month
      	changeYear: true, //this option for allowing user to select from year range
      	yearRange: "-80:+0",
		onClose: function( selectedDate ) 
		{
			$( "#fechaNacimiento" ).datepicker( "option", "minDate", selectedDate );
		}
    });
  }

);

function soloNumeros(e){
	var key = window.Event ? e.which : e.keyCode
	return (key >= 48 && key <= 57)
}

function consultarCURP()
{
	var url = "https://consultas.curp.gob.mx/CurpSP/";
	window.open(url);
}

function consultarIMSS()
{
	var url = "http://portal.infonavit.org.mx/wps/wcm/connect/infonavit/trabajadores/obten+tu+numero+de+seguridad+social+(nss)/";
	window.open(url);
}
</script>
</div>

<br class="clearfloat" />

<div class="footer"><?php include("../includes/admin_footer.php"); ?>
</div>
</div>
</body>
</html>
