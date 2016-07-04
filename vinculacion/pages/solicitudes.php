<!-- InstanceBegin template="/Templates/admin_template.dwt.php" codeOutsideHTMLIsLocked="false" --><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/html">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
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
    <link href="../css/jquery-ui.css" type="text/css" rel="stylesheet"/>
    <link href="../css/theme.css" type="text/css" rel="stylesheet"/> 
    
	<script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.js"></script>
	<script src="../js/datatables.js"></script>
	<script src="../js/columnfilter.js"></script>
    <script src="../js/solicitudesFunciones.js"></script>


<!-- InstanceEndEditable -->
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
<!-- end .header --></div>

<!-- InstanceBeginEditable name="Content" -->
    
<span class="archive-title">Departamento de Gestión</span>
<h1 class="featured-title">Tecnológica y Vinculación</h1>
<h2 class="featured-title2">Solicitudes Abiertas</h2>

<div class="content bg1" style="width:100%">

<?php if (isset($_POST['accionesSolicitud'])):?>
<?php $mensaje = $_POST['accionesSolicitud'];?>
<script language="JavaScript"> 
	var mensaje = "<?php echo $mensaje ?>";
	var tipoSolicitud = "<?php echo $_POST['tipoSolicitud'];?>";
	alert(mensaje);
	if (mensaje == "Solicitud Procesada!!!")
	{
		var numSolicitud = "<?php echo $_POST['numSolicitud'];?>";
		
		if (tipoSolicitud == "residencia")
		{
			var url = "../functions/formatoPresentacionResidencia.php?numSolicitud="+numSolicitud;
			window.open(url);
		}
		else if (tipoSolicitud == "practicas")
		{
			var url = "../functions/formatoPresentacionPracticas.php?numSolicitud="+numSolicitud;
			window.open(url);
		}
		else if (tipoSolicitud == "beca-alumnos")
		{
			var url = "../functions/formatoBecaAlumnos.php?numSolicitud="+numSolicitud;
			window.open(url);
		}
		else if (tipoSolicitud == "beca-egresados")
		{
			var url = "../functions/formatoBecaEgresados.php?numSolicitud="+numSolicitud;
			window.open(url);
		}
		else if (tipoSolicitud == "constancia")
		{
			var url = "../functions/formatoConstancia.php?numSolicitud="+numSolicitud;
			window.open(url);
		}
		else if (tipoSolicitud == "anexo-residencia")
		{
			var url = "../functions/formatoAnexoResidencia.php?numSolicitud="+numSolicitud;
			window.open(url);
		}
		else
		{
			var url = "../functions/formatoPresentacionServicio.php?numSolicitud="+numSolicitud;
			window.open(url);
		}		
	}
	//window.location = "solicitudes.php";
</script>
<?php endif;?>
<?php
		try 
		{	
			require_once '../connections/conexion.php';

			$query_datosSolicitudes = sprintf("SELECT 
        `s`.`numRegistro` AS `numRegistro`,
        `s`.`status` AS `estatus`,
        `s`.`tipoSolicitud` AS `tipoSolicitud`,
        `s`.`fechaSolicitud` AS `fechaSolicitud`,
        `s`.`fechaImpresion` AS `fechaImpresion`,
        `s`.`usuario` AS `usuario`,
        `s`.`idAlumno` AS `idAlumno`,
        `a`.`nomAlumno` AS `nomAlumno`,
        `a`.`apPaterno` AS `apPaterno`,
        `a`.`apMaterno` AS `apMaterno`
    FROM
        (`tblsolicitudes` `s`
        JOIN `tblalumnos` `a` ON ((`a`.`idAlumno` = `s`.`idAlumno`)))
    WHERE
        (`s`.`status` <> 'Entregado')");
			$datosSolicitudes = mysqli_query($conexion, $query_datosSolicitudes) or die(mysqli_error($conexion));		
		}
		 catch (PDOException $e) 
		{
			echo 'Error: '. $e->getMessage();
		}		
?>
		<table id="solicitudes" style="width:100%;  text-align:center;" class="cell-border">
			<input type="button" onclick="solicitudMasiva()" value="imprimir solicitudes abiertas" class="enviar" style="width:200px;margin-left:0px;background-size: 200px 30px;"></button>
			<thead>
	
					<!--<tr>
                    <th></th>
                    <th>No. Folio</th>
                    <th>Tipo_de_Solicitud</th>
                    <th></th>
                    <th></th>
                    <th></th>
					<th>No. Control</th>
					<th>Nombre</th>
					<th>A. Paterno</th>
                    <th>A. Materno</th>                
					</tr>-->
                    
                    <tr>
	                <th>__Acciones__</th>
                    <th>No.Folio</th>                    
                    <th>Tipo de Solicitud</th>
                    <th>Fecha de solicitud</th>
                    <th>Fecha de impresión</th>
                    <th>Usuario</th>
                    <th>No. Control</th>	
					<th>Nombre</th>
					<th>A. Paterno</th>
                    <th>A. Materno</th>
					<th>Estatus</th>
					</tr>
              </thead>
			  <tbody>

                 <?php while($row_datosSolicitudes = mysqli_fetch_assoc($datosSolicitudes)){ ?>
                 <tr>
                 <!-- <img class="accion" height="20px" width="20px" style="margin-left:10px" src="../images/editar.png" title="Editar Solicitud" onclick="editar('<?php echo $row_datosSolicitudes['numRegistro']; ?>');"/> -->
                 <td><img class="accion" height="30px" width="30px" src="../images/print.png" title="Generar Carta" onclick="procesar('<?php echo $row_datosSolicitudes['numRegistro']; ?>');"/><img class="accion" height="30px" width="30px" style="margin-left:10px" src="../images/remove.png" title="Eliminar Solicitud" onclick="eliminar('<?php echo $row_datosSolicitudes['numRegistro']; ?>');"/><img class="accion" height="30px" width="30px" style="margin-left:10px" src="../images/entregar.png" title="Entregado" onclick="entregar('<?php echo $row_datosSolicitudes['numRegistro']; ?>','<?php echo $row_datosSolicitudes['fechaImpresion']; ?>');"/></td>
                 <td><?php echo $row_datosSolicitudes['numRegistro']; ?></td>                 
                 <td><?php echo $row_datosSolicitudes['tipoSolicitud']; ?></td> 
                 <td><?php echo $row_datosSolicitudes['fechaSolicitud']; ?></td>
                 <td><?php echo $row_datosSolicitudes['fechaImpresion']; ?></td>
                 <td><?php echo $row_datosSolicitudes['usuario']; ?></td>
                 <td><?php echo $row_datosSolicitudes['idAlumno']; ?></td>
                 <td><?php echo $row_datosSolicitudes['nomAlumno']; ?></td>
                 <td><?php echo $row_datosSolicitudes['apPaterno']; ?></td>
                 <td><?php echo $row_datosSolicitudes['apMaterno']; ?></td>
				  <td><?php echo $row_datosSolicitudes['estatus']; ?></td>
				 </tr>
                 <?php }; ?>  
               </tbody>
  
		</table>

<?php mysqli_close($conexion);?> 
<!-- end .content --></div>

<!-- InstanceEndEditable -->

<br class="clearfloat" />

<div class="footer"><?php include("../includes/admin_footer.php"); ?>
<!-- end .footer --></div>
<!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
