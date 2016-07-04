<?php
session_start();
	if (isset($_GET["numSolicitud"])) 
	{
		$varMensaje = "";
		$numSolicitud = "";
		$tipoSolicitud = "";
		$varSolicitud = $_GET["numSolicitud"];
		$varAccion = $_GET["accion"];
		$fecha = date("Y-m-d");
		$puestoResponsable = "N/A";
		$tituloResponsable = "N/A";
		if (isset($_POST['puestoResponsable']))
		{
			$puestoResponsable = $_POST['puestoResponsable'];
		}
		if (isset($_POST['tituloResponsable']))
		{
			$tituloResponsable = $_POST['tituloResponsable'];
		}
		if (isset($_GET["email"])) 
		{$varEmailAlumno = $_GET["email"];}
		if (isset($_GET["telefono"]))
		{$varTelAlumno = $_GET["telefono"];}
		if (isset($_GET["responsableDependencia"]))
		{$varRespDep = $_GET["responsableDependencia"];}
		if (isset($_GET["telefonoDependencia"]))
		{$varTelDep = $_GET["telefonoDependencia"];}
		if (isset($_GET["emailDependencia"]))
		{$varEmailDep = $_GET["emailDependencia"];}	
		if (isset($_GET["lstDependencias"]))
		{$varDependencia = $_GET["lstDependencias"];}		
		
		$tipo = "";
		$sector = "";
		$programa = "N/A";	
		if (isset($_GET['programa']))
		{
			$programa = $_GET['programa'];
		}
		if (isset($_GET['proyecto']))
		{
			$programa = $_GET['proyecto'];
		}
		if (isset($_GET['tipo']))
		{
			$tipo = $_GET['tipo'];
		}
		if (isset($_GET['sector']))
		{
			$sector = $_GET['sector'];
		}
		if (isset($_GET['curp']))
		{
			$curp = strtoupper($_GET['curp']);
		}
		
		$nombreUsuario = $_SESSION['usuario'];
			
		try {
			require_once '../connections/conexion.php';
			$query_consultarUsuario = "SELECT * FROM tblusuarios WHERE nomUsuario = '$nombreUsuario'"; 
			$consultarUsuario = mysqli_query($conexion,$query_consultarUsuario) or die(mysqli_error($conexion));
			$row_consultarUsuario = mysqli_fetch_assoc($consultarUsuario);
			$usuario = $row_consultarUsuario['idUsuario'];
			
			if($varAccion == "eliminar")
			{
				$query_eliminarSolicitud = sprintf("DELETE FROM tblsolicitudes WHERE numRegistro = '$varSolicitud'");
				$eliminarSolicitud = mysqli_query($conexion, $query_eliminarSolicitud) or die(mysqli_error($conexion));
				
				$query_eliminarAnexo = sprintf("DELETE FROM tblanexo WHERE idSolicitud = '$varSolicitud'");
				$eliminarAnexo = mysqli_query($conexion, $query_eliminarAnexo) or die(mysqli_error($conexion));
				
				if($eliminarSolicitud == 1)
				{
						$varMensaje ="Solicitud Eliminada!!!";
				}
				else
				{
						$varMensaje ="Error al eliminar solicitud!!!";
				}
				mysqli_close($conexion);
			}
			if($varAccion == "procesar")
			{
				$query_procesarSolicitud = sprintf("UPDATE tblsolicitudes SET status = 'Procesado', fechaImpresion = '$fecha', usuario = '$usuario' WHERE numRegistro = '$varSolicitud'");
				$procesarSolicitud = mysqli_query($conexion, $query_procesarSolicitud) or die(mysql_error($conexion));
				$query_consultarSolicitud = sprintf("SELECT * FROM tblsolicitudes WHERE numRegistro = '$varSolicitud'");
				$consultarSolicitud = mysqli_query($conexion, $query_consultarSolicitud) or die(mysql_error($conexion));
				$row_consultarSolicitud = mysqli_fetch_assoc($consultarSolicitud);
				if($procesarSolicitud == 1)
				{
						$varMensaje ="Solicitud Procesada!!!";
						$numSolicitud = $row_consultarSolicitud['numRegistro'];
						$tipoSolicitud = $row_consultarSolicitud['tipoSolicitud'];
				}
				else
				{
						$varMensaje ="Error al procesar solicitud!!!";
				}
				mysqli_close($conexion);
			}
			if($varAccion == "editar")
			{
				$query_editarSolicitud = sprintf("UPDATE tblsolicitudes SET emailAlumno = '$varEmailAlumno', telAlumno = '$varTelAlumno', idDependencia = '$varDependencia', responsableDependencia = '$varRespDep', telDependencia = '$varTelDep', emailDependencia = '$varEmailDep',  curp = '$curp' WHERE numRegistro = '$varSolicitud'");
				$editarSolicitud = mysqli_query($conexion,$query_editarSolicitud) or die(mysqli_error($conexion));

				if($editarSolicitud == 1)
				{
						$varMensaje = "Solicitud Guardada!!!";
				}
				else
				{
						$varMensaje ="Error al procesar solicitud!!!";
				}
				mysqli_close($conexion);
			}
			if($varAccion == "entregar")
			{				 
				$query_editarSolicitud = sprintf("UPDATE tblsolicitudes SET status = 'Entregado', fechaEntregado = '$fecha',usuario = '$usuario' WHERE numRegistro = '$varSolicitud'");
				$editarSolicitud = mysqli_query($conexion,$query_editarSolicitud) or die(mysqli_error($conexion));

				if($editarSolicitud == 1)
				{
						$varMensaje = "Solicitud Entregada!!!";
				}
				else
				{
						$varMensaje ="Error al procesar solicitud!!!";
				}
				mysqli_close($conexion);
			}			
						
		} catch (PDOException $e) {
			echo 'Error al eliminar datos: '. $e->getMessage();
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestión Tecnológica y Vinculación</title>
<link rel="icon" href="../images/favicon.ico" type="image/ico" />
</head>
<body onload="javascript:enviarForm();">
<form name="frmAcciones" action="../pages/solicitudes.php" method="post" style="display:none">
<input name="accionesSolicitud" type="hidden" value="<?php echo $varMensaje?>"/>
<input name="numSolicitud" type="hidden" value="<?php echo $numSolicitud?>"/>
<input name="tipoSolicitud" type="hidden" value="<?php echo $tipoSolicitud?>"/>
<input type="submit" name="enviar" />
</form>

<script language="javascript">
	function enviarForm()
	{
		document.frmAcciones.submit();
	}
</script>
</body>
</html>

