<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<?php

session_start();
if(!isset($_SESSION['usuario'])) 
{
  header('Location: ../_admin.php'); 
  exit();
}

?>
<title>Gestión Tecnológica y Vinculación</title>
<link rel="icon" href="../images/favicon.ico" type="image/ico" />

<style type="text/css">
@import url("../css/admin_main.css");

.custom-combobox {
	position: relative;
	display: inline-block;
}
.custom-combobox-input {
	margin: 0;
	width: 315px !important;
	margin-left: 50px;
	padding-left: 8px;
	background-image: url(../images/txtBox.png) !important;
	border: 1px solid #CCC;
}
.ui-button {
	height: 19px !important;
	position: absolute !important;
}
.custom-combobox-toggle {
	position: absolute;
	top: 0;
	bottom: 0;
	margin-left: -1px;
	padding: 0;
}
</style>
<link rel="stylesheet" href="../css/menu.css" type="text/css" />
<link href="../css/jquery-ui.css" type="text/css" rel="stylesheet"/>
<link href='https://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css' />
<script src="../js/jquery.js"></script>
<script src="../js/jquery-ui.js"></script>
<script type="application/javascript" src="../js/dependenciasAutocomplete.js"></script
</head>
<body onload="validarTipo()">
<div class="container">
  <div class="header">
  <?php include("../includes/admin_header.php"); ?>
  <br class="clearfloat" />
  <?php include("../includes/menu_admin.php"); ?>
</div>
<span class="archive-title">Departamento de Gestión</span>
<h1 class="featured-title">Tecnológica y Vinculación</h1>
<h2 class="featured-title2">Editar Solicitud</h2>

<div class="content bg1">

<?php
	if (isset($_GET["numSolicitud"])) 
	{
		
		$numSolicitud = $_GET["numSolicitud"];
		try 
		{	
			require_once '../connections/conexion.php';
			//Datos Solicitud
			$query_datosSolicitudes = sprintf("SELECT 
        `s`.`numRegistro` AS `numRegistro`,
        `s`.`tipoSolicitud` AS `tipoSolicitud`,
        `s`.`fechaSolicitud` AS `fechaSolicitud`,
        `s`.`fechaImpresion` AS `fechaImpresion`,
        `s`.`fechaEntregado` AS `fechaEntregado`,
        `s`.`status` AS `status`,
        `s`.`idAlumno` AS `idAlumno`,
        `a`.`nomAlumno` AS `nomAlumno`,
        `a`.`apPaterno` AS `apPaterno`,
        `a`.`apMaterno` AS `apMaterno`,
        `a`.`sexo` AS `sexo`,
        `a`.`curp` AS `curp`,
        `a`.`carrera` AS `carrera`,
        `a`.`email` AS `emailAlumno`,
        `a`.`telefono` AS `telAlumno`,
        `s`.`conDiscapacidad` AS `conDiscapacidad`,
        `d`.`nomDependencia` AS `nomDependencia`,
        `d`.`tipo` AS `tipo`,
        `d`.`sector` AS `sector`,
        `s`.`responsableDependencia` AS `responsableDependencia`,
        `s`.`puestoResponsable` AS `puestoResponsable`,
		`s`.`tituloResponsable` AS `tituloResponsable`,
        `s`.`telDependencia` AS `telDependencia`,
        `s`.`emailDependencia` AS `emailDependencia`,
        `s`.`programa` AS `programa`,
        `s`.`fechaInicio` AS `fechaInicio`,
        `s`.`fechaTermino` AS `fechaTermino`,
        `s`.`usuario` AS `usuario`,
		`s`.`horas` AS `horas`
    FROM
        ((`tblsolicitudes` `s`
        JOIN `tblalumnos` `a` ON ((`a`.`idAlumno` = `s`.`idAlumno`)))
        JOIN `tbldependencias` `d` ON ((`d`.`idDependencia` = `s`.`idDependencia`))) WHERE numRegistro = '$numSolicitud'");
			$datosSolicitudes = mysqli_query($conexion,$query_datosSolicitudes) or die(mysql_error($conexion));
			$row_datosSolicitudes = mysqli_fetch_assoc($datosSolicitudes);
			$dependencia = $row_datosSolicitudes['nomDependencia'];
			$tipo = $row_datosSolicitudes['tipoSolicitud'];
			
			//Tipo de dependencia
			if ($tipo == "residencia" or $tipo == "practicas")
			{
				$tipo = "Empresa";
			}
			else
			{
				$tipo = "Dependencia";
			}			
			//Datos dependencias
			$query_datosDependencia = sprintf("SELECT * FROM tbldependencias WHERE tipo = '$tipo'");
			$datosDependencia = mysqli_query($conexion, $query_datosDependencia) or die(mysqli_error($conexion));
		}
		 catch (PDOException $e) 
		{
			echo 'Error: '. $e->getMessage();
		}
		$tipoSolicitud = "";
			
		if ($row_datosSolicitudes['tipoSolicitud'] == "servicio-social")
		{
			$tipoSolicitud = "Carta de Presentacion: Servicio Social";
		}
		if ($row_datosSolicitudes['tipoSolicitud'] == "residencia")
		{
			$tipoSolicitud = "Carta de Presentacion: Residencias";
		}
		if ($row_datosSolicitudes['tipoSolicitud'] == "practicas")
		{
			$tipoSolicitud = "Carta de Presentacion: Practicas";
		}
		if ($row_datosSolicitudes['tipoSolicitud'] == "beca-alumnos")
		{
			$tipoSolicitud = "Carta de Postulación: Beca Alumnos";
		}
		if ($row_datosSolicitudes['tipoSolicitud'] == "beca-egresados")
		{
			$tipoSolicitud = "Carta de Postulación: Beca Egresados";
		}
		if ($row_datosSolicitudes['tipoSolicitud'] == "constancia")
		{
			$tipoSolicitud = "Constancia de Conclusión: Beca Servicio Social";
		}
		if ($row_datosSolicitudes['tipoSolicitud'] == "anexo")
		{
			$tipoSolicitud = "Anexo Convenio Residencias";
		}
		mysqli_close($conexion);
		
	}
?>
<div class="formSection"">

	<form id="frmGuardarSolicitud" method="get" action="../functions/solicitudesFunciones.php">
    <fieldset><legend style="font-weight: bold; margin-bottom:40px; margin-left:30%" class="">Editando Folio<?php echo ": ".$row_datosSolicitudes['numRegistro']; ?></legend>    
    	<label class="formLabelEditarSolicitud" for="idAlumno">Número de Control:</label>
   	 	<input class="textbox" name="idAlumno" type="text" id="idAlumno" style="text-align:left; margin-left:50px;" readonly value="<?php echo $row_datosSolicitudes['idAlumno']; ?>"/>
        
        <label class="formLabelEditarSolicitud" for="nombre">Nombre:</label>
   	 	<input class="textboxEditarSolicitud" name="nombre" type="text" id="nombre" readonly value="<?php echo $row_datosSolicitudes['nomAlumno']; ?>"/>
        
        <label class="formLabelEditarSolicitud" for="apPaterno">Apellido Paterno:</label>
   	 	<input class="textboxEditarSolicitud" name="apPaterno" type="text"  id="apPaterno" readonly value="<?php echo $row_datosSolicitudes['apPaterno']; ?>"/>
        
        <label class="formLabelEditarSolicitud" for="apMaterno">Apellido Materno:</label>
   	 	<input class="textboxEditarSolicitud" name="apMaterno" type="text"  id="apMaterno" readonly value="<?php echo $row_datosSolicitudes['apMaterno']; ?>"/>
        
        <div id="divCurp" style="display:none">
        <label class="formLabelEditarSolicitud" for="curp">CURP:</label>
   	 	<input class="textboxEditarSolicitud" required readonly="readonly" title="Debe ser de 18 caracteres" pattern=".{18,}" maxlength="18" class="textbox" name="curp" type="text" style="text-align:left; text-transform:uppercase;" id="curp" value="<?php echo $row_datosSolicitudes['curp']; ?>"/>
        </div>
        <label class="formLabelEditarSolicitud" for="carrera">Carrera:</label>
   	 	<input class="textboxEditarSolicitud" name="carrera" type="text" id="carrera" readonly value="<?php echo $row_datosSolicitudes['carrera']; ?>"/>
        <div id="divEmail" style="display:none">
        <label class="formLabelEditarSolicitud" for="email">Email:</label>
   	 	<input required title="Ej. tuemail@mail.com" pattern="[A-Za-z0-9._%+-]{3,}@[a-zA-Z]{3,}([.]{1}[a-zA-Z]{2,}|[.]{1}[a-zA-Z]{2,}[.]{1}[a-zA-Z]{2,})" class="textboxEditarSolicitud" name="email" type="text"  id="email" value="<?php echo $row_datosSolicitudes['emailAlumno']; ?>"/>
        </div>
        <div id="divTelefono" style="display:none">
        <label class="formLabelEditarSolicitud" for="telefono">Teléfono (10 digitos):</label>
   	 	<input required title="Ej. 6641234578" pattern="[0-9]{10,}" class="textbox" name="telefono" maxlength="10"type="text" style="text-align:left; margin-left:50px;" id="telefono" value="<?php echo $row_datosSolicitudes['telAlumno']; ?>"/><br />
   	 	</div>

<!--		<label class="formLabelEditarSolicitud" for="dependencia">--><?php //echo $tipo?><!--:</label>-->
<!--        <select class="textboxEditarSolicitud" name="lstDependencias" id="lstDependencias" class="formList">        -->
<!--        --><?php //while($row_datosDependencia = mysqli_fetch_assoc($datosDependencia)){ ?>
<!--        <option --><?php //if($row_datosDependencia['nomDependencia'] == $row_datosSolicitudes['nomDependencia']){echo 'selected="selected"';} ?><!-- id="dependencia" value="--><?php //echo $row_datosDependencia['idDependencia']; ?><!--">--><?php //echo $row_datosDependencia['nomDependencia']; ?><!--</option>-->
<!--        --><?php //}; ?><!-- -->
<!--   	 	</select>-->

		<!-- crb01 -->
		<label class="formLabelEditarSolicitud" for="dependencias"><?php echo $tipo?>:</label>
		<select required name="lstDependencias" id="lstDependencias">
			<?php while($row_datosDependencia = mysqli_fetch_assoc($datosDependencia)){ ?>
				<option <?php if($row_datosDependencia['nomDependencia'] == $row_datosSolicitudes['nomDependencia']){echo 'selected="selected"';} ?> id="dependencia" value="<?php echo $row_datosDependencia['idDependencia']; ?>"><?php echo $row_datosDependencia['nomDependencia']; ?></option>
			<?php }; ?>
		</select>

        
        <label class="formLabelEditarSolicitud" for="tipoSolicitud">Tipo de solicitud:</label>
        <input class="textboxEditarSolicitud" name="tipoSolicitud" type="text" readonly value="<?php echo $tipoSolicitud?>"/>
        <div id="divResponsable" style="display:none">
        <label class="formLabelEditarSolicitud" for="responsableDependencia">Responsable de la <?php echo $tipo?>:</label>
   	 	<input required class="textboxEditarSolicitud" name="responsableDependencia" type="text" id="" value="<?php echo $row_datosSolicitudes['responsableDependencia']; ?>"/><br />
        </div>
        <label class="formLabelEditarSolicitud" style="display:none" id="labeltituloResponsable">Titulo:</label><br />
        <select class="textboxEditarSolicitud" name="tituloResponsable" id="tituloResponsable" style="display:none">
                <option <?php if($row_datosSolicitudes['tituloResponsable'] == "Lic.") {echo 'selected="selected"';}?> value="Lic.">Lic</option>
                <option <?php if($row_datosSolicitudes['tituloResponsable'] == "Ing.") {echo 'selected="selected"';}?> value="Ing.">Ing</option>
                <option <?php if($row_datosSolicitudes['tituloResponsable'] == "T.S.U.") {echo 'selected="selected"';}?> value="T.S.U.">TSU</option>
                <option <?php if($row_datosSolicitudes['tituloResponsable'] == "MTRO.") {echo 'selected="selected"';}?> value="MTRO.">MTRO</option>
                <option <?php if($row_datosSolicitudes['tituloResponsable'] == "C.P.") {echo 'selected="selected"';}?> value="C.P.">C.P.</option>
                <option <?php if($row_datosSolicitudes['tituloResponsable'] == "M.A.") {echo 'selected="selected"';}?> value="M.A.">M.A.</option>
                <option <?php if($row_datosSolicitudes['tituloResponsable'] == "M.C.") {echo 'selected="selected"';}?> value="M.C.">M.C.</option>
                <option <?php if($row_datosSolicitudes['tituloResponsable'] == "Dr.") {echo 'selected="selected"';}?> value="Dr.">Dr</option>  
                <option <?php if($row_datosSolicitudes['tituloResponsable'] == "Arq.") {echo 'selected="selected"';}?> value="Arq.">Arq</option>              
        </select> 
		<div id="divTelefonoDep" style="display:none">
        <label class="formLabelEditarSolicitud" for="telefonoDependencia">Tel&eacute;fono de la dependencia (10 digitos):</label>
   	 	<input class="textbox" required title="Ej. 6641234578" pattern="[0-9]{10,}" maxlength="10" name="telefonoDependencia" type="text" id="telefonoDependencia" style="text-align:left; margin-left:50px;" value="<?php echo $row_datosSolicitudes['telDependencia']; ?>"/>
        </div>
        <div id="divEmailResp" style="display:none">
        <label class="formLabelEditarSolicitud" for="emailDependencia">Email del responsable de la <?php echo $tipo?>:</label>
   	 	<input required title="Ej. tuemail@mail.com" pattern="[A-Za-z0-9._%+-]{3,}@[a-zA-Z]{3,}([.]{1}[a-zA-Z]{2,}|[.]{1}[a-zA-Z]{2,}[.]{1}[a-zA-Z]{2,})" class="textboxEditarSolicitud" name="emailDependencia" type="text" id="emailDependencia" value="<?php echo $row_datosSolicitudes['emailDependencia']; ?>"/>
   	 	</div>
   	 	<div id="divPrograma" style="display:none">
   	 	<label class="formLabelEditarSolicitud" for="programa" id="labelPrograma">Programa:</label>
   	 	<input class="textboxEditarSolicitud" required class="textbox" name="programa" type="text" style="text-align:left;" id="programa" value="<?php echo $row_datosSolicitudes['programa']; ?>"/>  <br /> 
        </div>
        <div id="divFechaInicio" style="display:none">
        <label class="formLabelEditarSolicitud" for="fechaInicio" id="labelfechaInicio">Fecha de Inicio:</label>
        <input class="textboxEditarSolicitud" required="required" class="fecha" type="text" id="fechaInicio" name="fechaInicio" value="<?php echo $row_datosSolicitudes['fechaInicio']; ?>"/>
        </div>
        <div id="divFechaTermino" style="display:none">
        <label class="formLabelEditarSolicitud" for="fechaTermino" id="labelfechaTermino">Fecha de T&eacute;rmino:</label>
        <input class="textboxEditarSolicitud" required="required" class="fecha" type="text" id="fechaTermino" name="fechaTermino" value="<?php echo $row_datosSolicitudes['fechaTermino']; ?>"/>
        </div>
        <div id="divHoras" style="display:none">
        <label class="formLabelEditarSolicitud" for="horas" id="labelhoras">Horas(min. 480hrs):</label>
   	 	<input class="textboxEditarSolicitud" required title="Solo números" pattern="[0-9]{3}" name="horas" type="text" style="text-align:left; margin-left:50px;" id="horas" value="<?php echo $row_datosSolicitudes['horas']; ?>"/>
   	 	</div>
        <input name="accion" type="hidden" value="editar"/>
        <input name="numSolicitud" type="hidden" value="<?php echo $row_datosSolicitudes['numRegistro']; ?>"/>
        
        <input name="enviar" type="submit" id="enviar" class="enviar" value="Enviar"/>        
        <input name="cancelar" type="button" id="cancelar" class="cancelar" value="Cancelar" onClick="location.href='solicitudes.php'"/>
	</fieldset>
	</form>   
</div>
</div>

<script>
function validarTipo()
{
	var tipo = "<?php echo $row_datosSolicitudes['tipoSolicitud']?>";
	if (tipo == "beca-alumnos" || tipo == "beca-egresados")
	{
		document.getElementById("divPrograma").style.display = "inline";
		document.getElementById("divFechaInicio").style.display = "inline";
		document.getElementById("divFechaTermino").style.display = "inline";
		document.getElementById("divHoras").style.display = "inline";
		document.getElementById("divCurp").style.display = "inline";
		document.getElementById("divEmail").style.display = "inline";
		document.getElementById("divTelefono").style.display = "inline";
		document.getElementById("divTelefonoDep").style.display = "inline";
		document.getElementById("divEmailResp").style.display = "inline";
		document.getElementById("divResponsable").style.display = "inline";
		/*document.getElementById("labelPrograma").style.display = "inline";
		document.getElementById("labelfechaInicio").style.display = "inline";
		document.getElementById("labelfechaTermino").style.display = "inline";
		document.getElementById("labelhoras").style.display = "inline";*/
	}
	if (tipo == "residencia" || tipo == "practicas")
	{
		document.getElementById("tituloResponsable").style.display = "inline";
		document.getElementById("labeltituloResponsable").style.display = "inline";
		document.getElementById("divCurp").style.display = "inline";
		document.getElementById("divEmail").style.display = "inline";
		document.getElementById("divTelefono").style.display = "inline";
		document.getElementById("divTelefonoDep").style.display = "inline";
		document.getElementById("divEmailResp").style.display = "inline";
		document.getElementById("divResponsable").style.display = "inline";
	}

	if (tipo == "servicio-social")
	{
		document.getElementById("labeltituloResponsable").style.display = "inline";
		document.getElementById("divCurp").style.display = "inline";
		document.getElementById("divEmail").style.display = "inline";
		document.getElementById("divTelefono").style.display = "inline";
		document.getElementById("divTelefonoDep").style.display = "inline";
		document.getElementById("divEmailResp").style.display = "inline";
		document.getElementById("divResponsable").style.display = "inline";
	}
}
</script>

<br class="clearfloat" />

<div class="footer"><?php include("../includes/admin_footer.php"); ?>
</div>
</div>
</body>
</html>
