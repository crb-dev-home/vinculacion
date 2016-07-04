<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Solicitar Beca Alumnos</title>
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
<h2 class="featured-title2">Beca Servicio Social Alumnos</h2>

<div class="content bg1">

<?php if (isset($_POST['insertado'])):?>
<?php $mensaje = $_POST['insertado'];?>
<script language="JavaScript"> 
	var mensaje = '<?php echo $mensaje ?>';
//	alert(mensaje);
//	window.location = "../index.php";
	_dialogo(mensaje,"../index.php");
</script>
<?php else:?>
<?php require_once '../functions/consulta.php';?>

<?php if ($validar != "0"):?>
<?php if ($totalRows_datosAlumno == 0):?>
<script language="JavaScript"> 
	var mensaje = 'No se encontraron datos';
//	alert(mensaje);
//	window.location = "../index.php";
	_dialogo(mensaje,"../index.php");
</script>
<?php endif;?>
<?php endif;?>

<?php if ($validar != "0" and $totalRows_datosAlumno != 0):?>
<div class="formSection">

	<form method="post" action="../functions/insertar.php" onsubmit = "return validar()" name="frmGuardarSolicitud" id="frmGuardarSolicitud">
    <fieldset><legend style="font-weight: bold; margin-bottom:20px; margin-left:30%">Solcitud: Carta de presentaci&oacute;n</legend>    
    	<label class="formLabel" for="idAlumno">Número de Control:</label>
   	 	<input name="idAlumno" type="text" style="text-align:left; margin-left:50px;" id="idAlumno" readonly="readonly" value="<?php echo $row_datosAlumno['idAlumno']; ?>"/>
        
        <label class="formLabel" for="nombre">Nombre:</label>
   	 	<input class="textbox" name="nombre" type="text" style="text-align:left" id="nombre" readonly="readonly" value="<?php echo $row_datosAlumno['nomAlumno']; ?>"/>
        
        <label class="formLabel" for="apPaterno">Apellido Paterno:</label>
   	 	<input class="textbox" name="apPaterno" type="text" style="text-align:left" id="apPaterno" readonly="readonly" value="<?php echo $row_datosAlumno['apPaterno']; ?>"/>
        
        <label class="formLabel" for="apMaterno">Apellido Materno:</label>
   	 	<input class="textbox" name="apMaterno" type="text" style="text-align:left" id="apMaterno" readonly="readonly" value="<?php echo $row_datosAlumno['apMaterno']; ?>"/>
        <br />
        <!--<label class="formLabel" for="sexo">Sexo:</label>
        <input name="sexo" type="text" style="text-align:left; margin-left:50px;" id="sexo" readonly="readonly" value="<?php echo $row_datosAlumno['sexo']; ?>"/> -->
        
        <label class="formLabel" for="discapacidad">Padece alguna discapacidad?:
        <input type="radio" name="discapacidad" value="Si" style="margin-left:50px;"/>Si
        <input type="radio" name="discapacidad" value="No" style="margin-left:50px;" checked/>No</label><br />
                
        <label class="formLabel" for="curp">CURP:</label>
   	 	<input required readonly="readonly" title="Debe ser de 18 caracteres" pattern=".{18,}" maxlength="18" class="textbox" name="curp" type="text" style="text-align:left; text-transform:uppercase" id="curp" value="<?php echo $row_datosAlumno['curp']; ?>"/><span><a href="javascript:consultarCURP()"><img height="35px" width="35px" style="margin-left:5px" src="../images/curp.png" title="Consulta Curp"/></a></span>
        
        <label class="formLabel" for="carrera">Carrera:</label>
   	 	<input class="textbox" name="carrera" type="text" style="text-align:left" id="carrera" readonly="readonly" value="<?php echo $row_datosAlumno['carrera']; ?>"/>
        
        <label class="formLabel" for="email">Email:</label>
   	 	<input required title="Ej. tuemail@mail.com" pattern="[A-Za-z0-9._%+-]{3,}@[a-zA-Z]{3,}([.]{1}[a-zA-Z]{2,}|[.]{1}[a-zA-Z]{2,}[.]{1}[a-zA-Z]{2,})" class="textbox" name="email" type="text" style="text-align:left" id="email" value="<?php echo $row_datosAlumno['email']; ?>"/>
        
        <label class="formLabel" for="telefono">Teléfono (10 digitos):</label>
   	 	<input required title="Ej. 6641234578" pattern="[0-9]{10,}" name="telefono" maxlength="10" type="text" style="text-align:left; margin-left:50px;" id="telefono" value="<?php echo $row_datosAlumno['telefono']; ?>"/>

		<!-- crb01 -->
		<div>
			<label class="formLabel" for="dependencias">Dependencia:</label>
			<select required name="lstDependencias" id="lstDependencias">
				<option id="" value=""></option>
				<option id="otraDependencia" value="otraDependencia">Dar de Alta Nueva...</option>
				<?php while($row_datosDependencia = mysqli_fetch_assoc($datosDependencia)){ ?>
					<option id="dependencias" value="<?php echo $row_datosDependencia['idDependencia']; ?>"><?php echo $row_datosDependencia['nomDependencia']; ?></option>
				<?php }; ?>
			</select>
		</div>

<!--        <label class="formLabel" for="dependencias">Dependencia:</label>-->
<!--        -->
<!--        <select name="lstDependencias" id="lstDependencias" class="formList" onchange="validarDependencia();">         -->
<!--        --><?php //while($row_datosDependencia = mysqli_fetch_assoc($datosDependencia)){ ?>
<!--        <option id="dependencias" value="--><?php //echo $row_datosDependencia['idDependencia']; ?><!--">--><?php //echo $row_datosDependencia['nomDependencia']; ?><!--</option>-->
<!--        --><?php //}; ?><!-- -->
<!--        <option id="otraDependencia" value="otraDependencia">Otro...</option>-->
<!--        </select>-->
        
        <div id="capturaDependencia" style="display:none">
        <label class="formLabel" for="nuevaDependencia">Nombre completo:</label>
   	 	<input class="textbox" name="nuevaDependencia" type="text" style="text-align:left" id="nuevaDependencia" value=""/>
   	 	
        <label class="formLabel" for="nombreCorto">Nombre Corto:</label>
   	 	<input class="textbox" name="nombreCorto" type="text" style="text-align:left" id="nombreCorto" value=""/>
   	 	
   	 	<label class="formLabel" for="domicilioDep">Calle y Número:</label>
   	 	<input class="textbox" name="domicilioDep" type="text" style="text-align:left" id="domicilioDep" value=""/>
   	 	
   	 	<label class="formLabel" for="coloniaDep">Colonia:</label>
   	 	<input class="textbox" name="coloniaDep" type="text" style="text-align:left" id="coloniaDep" value=""/>
   	 	
   	 	<label class="formLabel" for="ciudadDep">Ciudad:</label>
   	 	<input class="textbox" name="ciudadDep" type="text" style="text-align:left" id="ciudadDep" value=""/>
   	 	
   	 	<label class="formLabel" for="codigoDep">Codigo Postal:</label>
   	 	<input class="textbox" name="codigoDep" type="text" style="text-align:left" id="codigoDep" value=""/>
   	 	
        <label class="formLabel">Tipo:</label>
        <input name="tipo" type="text" style="text-align:left; margin-left:50px;" id="tipo" readonly="readonly" value="Dependencia"/>               
                        
        <label class="formLabel">Sector:</label>
        <select class="textbox" name="sector" id="sector">
                <option value="Educativo">Educativo</option>
                <option value="Público">Público</option>
                <option value="Privado">Privado</option>
                <option value="Social">Social</option>
        </select>
        </div>
        <input name="tipoSolicitud" type="hidden" value="beca-alumnos"/>     
        
        <label class="formLabel" for="responsableDependencia">Nombre completo del responsable de la dependencia:</label>
   	 	<input required class="textbox" name="responsableDependencia" type="text" style="text-align:left" id="responsableDependencia" value=""/>
        
        <label class="formLabel" for="telefonoDependencia">Tel&eacute;fono de la dependencia:</label>
   	 	<input required title="Ej. 6641234578" pattern="[0-9]{10,}" maxlength="10" name="telefonoDependencia" type="text" style="text-align:left; margin-left:50px" id="telefonoDependencia" value=""/>
        
        <label class="formLabel">Extensión:</label>
        <input name="extension" type="text" style="text-align:left; margin-left:50px" id="extension" value=""/>
        
        <label class="formLabel" for="emailDependencia">Email del responsable de la dependencia:</label>
   	 	<input required title="Ej. tuemail@mail.com" pattern="[A-Za-z0-9._%+-]{3,}@[a-zA-Z]{3,}([.]{1}[a-zA-Z]{2,}|[.]{1}[a-zA-Z]{2,}[.]{1}[a-zA-Z]{2,})" class="textbox" name="emailDependencia" type="text" style="text-align:left" id="emailDependencia" value=""/>  <br /> 
        
        <label class="formLabel" for="programa">Programa:</label>
   	 	<input required class="textbox" maxlength="150" name="programa" type="text" style="text-align:left" id="programa" value=""/>  <br />
        
        <label class="formLabel" for="fechaInicio">Fecha de Inicio:</label>
        <input required="required" class="fecha" type="text" id="fechaInicio" name="fechaInicio" value=""/><br />
         
        <label class="formLabel" for="fechaTermino">Fecha de T&eacute;rmino:</label>
        <input required="required" class="fecha" type="text" id="fechaTermino" name="fechaTermino" value=""/><br />
        
        <label class="formLabel" for="horas">Horas(min. 480hrs):</label>
   	 	<input required title="Solo números" pattern="[0-9]{3}" name="horas" type="text" style="text-align:left; margin-left:50px;" id="horas" value="480"/>
   	 	
        <br />
             
        
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
  }

);
	function vistaPrevia()
	{		
		var fechaInicio = document.getElementById("fechaInicio").value;
		var fechaTermino = document.getElementById("fechaTermino").value;
		var nomAlumno = document.getElementById("nombre").value;
		var apPaterno = document.getElementById("apPaterno").value;
		var apMaterno = document.getElementById("apMaterno").value;
		var curp = document.getElementById("curp").value;
		var idAlumno = document.getElementById("idAlumno").value;
		var carrera = document.getElementById("carrera").value;
		var dep = document.getElementById("lstDependencias");
		var nomDependencia = dep.options[dep.selectedIndex].text;
		var programa = document.getElementById("programa").value;
		var url = "../functions/preview_formatoPresentacionServicio.php?fechaInicio="+fechaInicio+"&fechaTermino="+fechaTermino+"&numSolicitud=00000&nomAlumno="+nomAlumno+"&apPaterno="+apPaterno+"&apMaterno="+apMaterno+"&curp="+curp+"&idAlumno="+idAlumno+"&carrera="+carrera+"&nomDependencia="+nomDependencia+"&programa="+programa;
		window.open(url);
		
	}
	
	function validarDependencia()
	{
		var validar = $('#lstDependencias').val(); //crb01
//		var validar = document.getElementById("lstDependencias").value;
		var nueva = document.getElementById("nuevaDependencia").value;
		var nombreCorto = document.getElementById("nombreCorto").value;
		var tipo = document.getElementById("tipo").value;
		var sector = document.getElementById("sector").value;
		if (validar == "otraDependencia")
		{
			document.getElementById("capturaDependencia").style.display = "inline";	
			document.getElementById("nuevaDependencia").value = nueva;	
			document.getElementById("nuevaDependencia").setAttribute("required","true");
			document.getElementById("nombreCorto").value = nombreCorto;	
			document.getElementById("nombreCorto").setAttribute("required","true");
		}
		else
		{
			document.getElementById("capturaDependencia").style.display = "none";
			document.getElementById("nuevaDependencia").value = "";
			document.getElementById("nuevaDependencia").removeAttribute("required");
			document.getElementById("nombreCorto").value = "";
			document.getElementById("nombreCorto").removeAttribute("required");
		}
	}	

	function consultarCURP()
	{
		var url = "https://consultas.curp.gob.mx/CurpSP/";
		window.open(url);
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