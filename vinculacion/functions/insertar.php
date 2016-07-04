<?php
	if (isset($_POST['enviar'])) 
	{
		$idAlumno = $_POST['idAlumno'];
		$dependencia = "";
		$nombreCorto = "";
		$tipo = "";
		$sector = "";
		$programa = "N/A";
		$puestoResponsable = "N/A";
		$tituloResponsable = "N/A";
		$asesorExterno = 'N/A';
		$puestoAsesorExterno = 'N/A';
		$casoEmergencias = "";
		$discapacidad = "No";
		$fechaInicio = "";
		$fechaTermino = "";
		$horas = "480";
		$anexo = "";
		$conAtencionA = "";
				
		if (isset($_POST['lstDependencias']))
		{
			$dependencia = $_POST['lstDependencias'];
		}
		$curp = "N/A";
		if (isset($_POST['programa']))
		{
			$programa = $_POST['programa'];
		}
		if (isset($_POST['proyecto']))
		{
			$programa = $_POST['proyecto'];
		}
		if (isset($_POST['tipo']))
		{
			$tipo = $_POST['tipo'];
		}
		if (isset($_POST['sector']))
		{
			$sector = $_POST['sector'];
		}
		if (isset($_POST['curp']))
		{
			$curp = strtoupper($_POST['curp']);
		}
		if (isset($_POST['discapacidad']))
		{
			$discapacidad = $_POST['discapacidad'];
		}
		if (isset($_POST['puestoResponsable']))
		{
			$puestoResponsable = $_POST['puestoResponsable'];
		}
		if (isset($_POST['asesorExterno']))
		{
			$asesorExterno = $_POST['asesorExterno'];
		}
		if (isset($_POST['puestoAsesorExterno']))
		{
			$puestoAsesorExterno = $_POST['puestoAsesorExterno'];
		}
		if (isset($_POST['conAtencionA'])) //CRB01
		{
			$conAtencionA = $_POST['conAtencionA'];
		}
		if (isset($_POST['tituloResponsable']))
		{
			$tituloResponsable = $_POST['tituloResponsable'];
		}
		if (isset($_POST['nuevaDependencia']))
		{
			$nuevaDependencia = $_POST['nuevaDependencia'];
		}
		if (isset($_POST['nombreCorto']))
		{
			$nombreCorto = $_POST['nombreCorto'];
		}


 		$fechaSolicitud = date("Y-m-d");
 		$fechaImpreso = '0000-00-00'; 
		$status = "Sin procesar";
		$usuario = "";
		$tipoSolicitud = $_POST['tipoSolicitud'];
		if ($tipoSolicitud == "anexo-residencia")
		{
			$fechaImpreso = date("Y-m-d");
			$usuario = "Alumno";
			$programa = $_POST['nomProy'];
		}
		
		$nomAlumno = $_POST['nombre'];
		
		$responsableDependencia = "N/A";
		if (isset($_POST['responsableDependencia']))
		{
			$responsableDependencia = $_POST['responsableDependencia'];
		}
		$telefonoDependencia = "N/A";
		if (isset($_POST['telefonoDependencia']))
		{
			$telefonoDependencia = $_POST['telefonoDependencia'];
		}
		$emailDependencia = "N/A";
		if (isset($_POST['emailDependencia']))
		{
			$emailDependencia = $_POST['emailDependencia'];
		}		
		$giro = "N/A";
		if (isset($_POST['giro']))
		{
			$giro = $_POST['giro'];
		}
		$rfc = "";
		if (isset($_POST['rfc']))
		{
			$rfc = $_POST['rfc'];
		}
				
					
		$domicilioDep = "";
		if (isset($_POST['domicilioDep']))
		{
			$domicilioDep = $_POST['domicilioDep'];
		}
		$coloniaDep = "";
		if (isset($_POST['coloniaDep']))
		{
			$coloniaDep = $_POST['coloniaDep'];
		}
		$ciudadDep = "";
		if (isset($_POST['ciudadDep']))
		{
			$ciudadDep = $_POST['ciudadDep'];
		}
		$codigoDep = "";
		if (isset($_POST['codigoDep']))
		{
			$codigoDep = $_POST['codigoDep'];
		}		
		if (isset($_POST['fechaInicio']))
		{
			$fechaInicio = $_POST['fechaInicio'];
		}
		if (isset($_POST['fechaTermino']))
		{
			$fechaTermino = $_POST['fechaTermino'];
		}
		if (isset($_POST['horas']))
		{
			$horas = $_POST['horas'];
		}
		
		if (isset($_POST['nomProy']))
		{
			$nomProy = $_POST['nomProy'];
		}
		if (isset($_POST['perProy']))
		{
			$perProy = $_POST['perProy'];
		}
		if (isset($_POST['numRes']))
		{
			$numRes = $_POST['numRes'];
		}
		if (isset($_POST['casoEmergencias']))
		{
			$casoEmergencias = $_POST['casoEmergencias'];
		}
		if (isset($_POST['opcion']))
		{
			$opcion = $_POST['opcion'];
		}
		
		//Anexo
		$area = "";
		$extension = "N/A";
		$nomAcuerdo = "";
		$puestoAcuerdo = "";
		$mision = "";
		$horario = "";
		$dias = "";
		$fechaReporte = "";
		$pago = "";
		$importe = "";
	
		if(isset($_POST['area']))
		{
			$area = $_POST['area'];
		}
		if(isset($_POST['extension']))
		{
			$extension = $_POST['extension'];
		}
		if(isset($_POST['nomAcuerdo']))
		{
			$nomAcuerdo = $_POST['nomAcuerdo'];
		}
		if(isset($_POST['puestoAcuerdo']))
		{
			$puestoAcuerdo = $_POST['puestoAcuerdo'];
		}
		if(isset($_POST['mision']))
		{
			$mision = $_POST['mision'];
		}
		if(isset($_POST['horario']))
		{
			$horario = $_POST['horario'];
		}		
		if(isset($_POST['dias']))
		{
			$dias = $_POST['dias'];
		}
		if(isset($_POST['fechaReporte']))
		{
			$fechaReporte = $_POST['fechaReporte'];
		}
		if(isset($_POST['pago']))
		{
			$pago = $_POST['pago'];
		}
		if(isset($_POST['importe']))
		{
			$importe = $_POST['importe'];
		}

				
		$varMensaje = "";
		
		try {
			require_once '../connections/conexion.php';
			//Verificar si existe una solicitud de la misma categoria sin procesar
			$query_verificarSolicitud = mysqli_query($conexion,"SELECT * FROM tblsolicitudes WHERE idAlumno = '$idAlumno' AND status = '$status' AND tipoSolicitud = '$tipoSolicitud'") or die(mysqli_error());
			$verificarSolicitud = mysqli_num_rows($query_verificarSolicitud);
			
				
			if ($verificarSolicitud == 0)
			{
			if ($nuevaDependencia != "")
			{
				$query_verificarDependencia = mysqli_query($conexion,"SELECT * FROM tbldependencias WHERE nomDependencia = '$nuevaDependencia'") or die(mysqli_error($conexion));
				$verificarDependencia = mysqli_num_rows($query_verificarDependencia);
				
				if ($verificarDependencia == 0)
				{
					$insertarDependencia = mysqli_query($conexion,"INSERT INTO tbldependencias(nomDependencia,cortoDependencia,RFC,tipo,sector,giro,domicilio,colonia,ciudad,codigo) VALUES ('$nuevaDependencia','$nombreCorto','$rfc','$tipo','$sector','$giro','$domicilioDep','$coloniaDep','$ciudadDep','$codigoDep')") or die(mysqli_error($conexion));
									
					if($insertarDependencia == 1)
					{
						$query_datosDependencia = sprintf("SELECT idDependencia FROM tbldependencias WHERE nomDependencia = '$nuevaDependencia'");
						$datosDependencia = mysqli_query($conexion,$query_datosDependencia) or die(mysqli_error($conexion));
						$row_datosDependencia = mysqli_fetch_assoc($datosDependencia);
						$dependencia = $row_datosDependencia['idDependencia'];
					}
					else
					{
							$varMensaje = "Error al enviar solicitud!!!";
					}
				}
				else
				{
						$query_datosDependencia = sprintf("SELECT idDependencia FROM tbldependencias WHERE nomDependencia = '$nuevaDependencia'");
						$datosDependencia = mysqli_query($conexion,$query_datosDependencia) or die(mysqli_error($conexion));
						$row_datosDependencia = mysqli_fetch_assoc($datosDependencia);
						$dependencia = $row_datosDependencia['idDependencia'];
				}
				
			}
		

			$datosSolicitud = mysqli_query($conexion,"INSERT INTO tblsolicitudes (idAlumno,conDiscapacidad,idDependencia,fechaSolicitud,fechaImpresion,fechaEntregado,status,tipoSolicitud,responsableDependencia,tituloResponsable,puestoResponsable,conAtencionA,telDependencia, extension, emailDependencia,programa,fechaInicio,fechaTermino,horas,usuario)
																		VALUES ('$idAlumno','$discapacidad','$dependencia','$fechaSolicitud','$fechaImpreso','','$status','$tipoSolicitud','$responsableDependencia','$tituloResponsable','$puestoResponsable','$conAtencionA','$telefonoDependencia', '$extension', '$emailDependencia','$programa','$fechaInicio','$fechaTermino','$horas','$usuario')") or die(mysqli_error($conexion));
			$idSolicitudDatos = mysqli_query($conexion,"SELECT numRegistro FROM tblsolicitudes WHERE idAlumno = '$idAlumno' AND status = '$status' AND tipoSolicitud = '$tipoSolicitud'") or die(mysqli_error());
			$row_datosSol = mysqli_fetch_assoc($idSolicitudDatos);
			$idSolicitud = $row_datosSol['numRegistro'];
			
			
			
			if ($tipoSolicitud == "anexo-residencia" && $datosSolicitud == 1)
			{
				$datosAnexo = mysqli_query($conexion,"INSERT INTO tblanexo (idSolicitud, nomPersona, puestoPersona,nomAsesorExt,puestoAsesorExt, mision, horario, dias, area, fechaReporte, apoyoEconomico, importeLetra, nomProyecto, periodo, opcionEle, numReside, acudirEmergencias) VALUES ('$idSolicitud','$nomAcuerdo','$puestoAcuerdo','$asesorExterno','$puestoAsesorExterno','$mision','$horario','$dias','$area','$fechaReporte','$pago','$importe', '$nomProy', '$perProy','$opcion', '$numRes', '$casoEmergencias')") or die(mysqli_error($conexion));
				$anexo = "imprimir";
				
			}
			
			
			if($datosSolicitud == 1)
			{
					$varMensaje ="Solicitud enviada. <br> <br> Favor de pasar al dia siguiente por su documento con horario unidad otay de 8:00 a 14:00 y tomas aquino 8:00 a 18:00";
			}
			else
			{
					$varMensaje ="Error al enviar solicitud.";
			}
			
			mysqli_close($conexion);
			}
			else
				{//"Ya existe una solicitud abierta. Favor de comunicarse al departamento de Gestion Tecnol&Oacute;gica y Vinculaci&Oacute;n"
					$varMensaje = "Ya existe una solicitud abierta.Favor de comunicarse al departamento de Gestion Tecnol&oacute;gica y Vinculaci&oacute;n";
				}
						
		} catch (PDOException $e) {
			echo 'Error al insertar datos: '. $e->getMessage();
		}
	}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gesti&oacute;n Tecnol&oacute;gica y Vinculaci&oacute;n</title>
<link rel="icon" href="../images/favicon.ico" type="image/ico" />
</head>
<body onload="javascript:enviarForm();">
<form name="enviado" action="<?php echo '../pages/'.$tipoSolicitud.'.php'?>" method="post" style="display:none">
<input name="insertado" type="hidden" value="<?php echo $varMensaje?>"/>
<input name="imprimir" type="hidden" value="<?php echo $anexo?>"/>
<input name="solicitud" type="hidden" value="<?php echo $idSolicitud?>"/>
<input type="submit" name="enviar" />
</form>

<script language="javascript">
	function enviarForm()
	{
		document.enviado.submit();
	}
</script>
</body>
</html>

