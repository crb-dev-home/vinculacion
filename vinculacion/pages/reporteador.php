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

	<link href="../css/datatables.css" type="text/css" rel="stylesheet"/>
    <link href="../css/TableTools.css" type="text/css" rel="stylesheet"/>
    <link href="../css/jquery-ui.css" type="text/css" rel="stylesheet"/>
    <link href="../css/theme.css" type="text/css" rel="stylesheet"/>   
	
	<script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.js"></script>
	<script src="../js/datatables.js"></script>
    <script src="../js/columnfilter.js"></script>
    <script src="../js/ZeroClipboard.js"></script>
    <script src="../js/TableTools.js"></script>
    <script src="../js/reporteadorFunciones.js"></script>

<style type="text/css">
@import url("../css/admin_main.css");
</style>
<link rel="stylesheet" href="../css/menu.css" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css'/>
</head>
<body>
<div class="container">
  <div class="header">
  <?php include("../includes/admin_header.php"); ?>
  <br class="clearfloat" />
  <?php include("../includes/menu_admin.php"); ?>
</div>


    
<span class="archive-title">Departamento de Gestión</span>
<h1 class="featured-title">Tecnológica y Vinculación</h1>
<h2 class="featured-title2">Historico Solicitudes</h2>

<div class="content bg1" style="width:100%">

<div id="rangoFechas">
<center>

    <label for="fechaInicio">Del</label>
    <input type="text" id="fechaInicio" name="fechaInicio" style="text-align:center" value=""/>
    <label for="fechaFinal">al</label>
    <input type="text" id="fechaFinal" name="fechaFinal" style="text-align:center" value=""/>
    <img height="20px" width="20px" src="../images/buscar.png" title="Buscar" class="accion" id="buscar"/>
    <img height="30px" width="30px" src="../images/todo.png" title="Mostrar Todo" class="accion" id="buscarTodo" name="buscarTodo"/>

</center>
</div>


<table id="reporteador"  style="width:100%; text-align:center;" class="cell-border">
			<thead>

                    <tr>
            		<th>No. Folio</th>
					<th>No. Control</th>
					<th>Nombre</th>
					<th>A. Paterno</th>
                    <th>A. Materno</th>
                    <th>Sexo</th>
                    <th>Carrera</th>
                    <th>Con Discapacidad?</th>
                    <th>Tipo de Solicitud</th>
                    <th>Fecha de solicitud</th>
                    <th>Fecha de impresión</th>                   
                    <th>Fecha de entregado</th>
                    <th>Estatus</th>
                    <th>Usuario</th>            
                    <th>Dependencia/Empresa</th>
                    <th>Tipo</th>
                    <th>Giro</th>
                    <th>Sector</th>
                    <th>Responsable Dependencia</th>
                    <th>Puesto Responsable</th>
                    <th>Telefono Dependencia</th>
                    <th>Email Dependencia</th>
                    <th>Programa/Proyecto</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Terminacion</th>
					</tr>
                    
                    <tr>
                	<th>No. Folio</th>
					<th>No. Control</th>
					<th>Nombre</th>
					<th>A. Paterno</th>
                    <th>A. Materno</th>
                    <th>Sexo</th>
                    <th>Carrera</th>
                    <th>Con Discapacidad?</th>
                    <th>Tipo de Solicitud</th>
                    <th>Fecha de solicitud</th>
                    <th>Fecha de impresión</th>                   
                    <th>Fecha de entregado</th>
                    <th>Estatus</th>
                    <th>Usuario</th>            
                    <th>Dependencia/Empresa</th>
                    <th>Tipo</th>
                    <th>Giro</th>
                    <th>Sector</th>
                    <th>Responsable Dependencia</th>
                    <th>Puesto Responsable</th>
                    <th>Telefono Dependencia</th>
                    <th>Email Dependencia</th>
                    <th>Programa/Proyecto</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Terminacion</th>
                    
                    </tr>
              </thead>
			  
		</table>

<script language="JavaScript"> 
$(document).ready(  
  /* This is the function that will get executed after the DOM is fully loaded */
  function() 
  {
	 document.getElementById("buscar").click();
	 var date = new Date();
	 var today = new Date();
	 var firstDay = new Date(date.getFullYear(), date.getMonth(), 1); 
   
    $( "#fechaInicio" ).datepicker({
		defaultDate: "+1w",
		dateFormat:"yy-mm-dd",
      	changeMonth: true,//this option for allowing user to select month
      	changeYear: true, //this option for allowing user to select from year range
		onClose: function( selectedDate ) 
		{
			$( "#fechaFinal" ).datepicker( "option", "minDate", selectedDate);
		}
    }).datepicker("setDate",firstDay);
	
	
	$( "#fechaFinal" ).datepicker({
		defaultDate: "+1w",
		dateFormat:"yy-mm-dd",
	    changeMonth: true,//this option for allowing user to select month
    	changeYear: true, //this option for allowing user to select from year range
		onClose: function( selectedDate ) 
		{
			$( "#fechaInicio" ).datepicker( "option", "maxDate", selectedDate);
		}
    }).datepicker("setDate",today);	
	
  }
); 
</script>
</div>


<br class="clearfloat" />

<div class="footer"><?php include("../includes/admin_footer.php"); ?>
</div>
</div>
</body>
</html>
