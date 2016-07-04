<?php
	$validar = "";
	
	if (isset($_GET['numControl'])) 
	{
		$varControl = $_GET['numControl'];
		$varTipoSolicitud = $_GET['tipo'];
		$tipo = "";
		
		if ($varTipoSolicitud == "residencia" or $varTipoSolicitud == "practicas" or $varTipoSolicitud == "anexo")
		{
			$tipo = "Empresa";
		}
		else
		{
			$tipo = "Dependencia";
		}
		
		try 
		{
			require_once '../connections/conexion.php';
			//Datos Alumno
			$query_datosAlumno = sprintf("SELECT `idAlumno`, `nomAlumno`, `apPaterno`, `apMaterno`, `fechaNacimiento`, `sexo`, `curp`, `nomCarreraLargo` as 'carrera', `email`, `telefono`, `domicilio`, `colonia`, `codigo`, `semestre`, `creditos`, `ciudad`,TIMESTAMPDIFF(YEAR,fechaNacimiento,CURRENT_DATE) as edad FROM `tblalumnos` JOIN `tblcarreras`  ON `carrera`=`idCarrera` WHERE idAlumno = '$varControl'");
			$datosAlumno = mysqli_query($conexion, $query_datosAlumno) or die(mysqli_error($conexion));
			$row_datosAlumno = mysqli_fetch_assoc($datosAlumno);
			$totalRows_datosAlumno = mysqli_num_rows($datosAlumno);
			//Datos dependencias
			$query_datosDependencia = sprintf("SELECT * FROM tbldependencias WHERE tipo = '$tipo' ORDER BY nomDependencia");
			$datosDependencia = mysqli_query($conexion, $query_datosDependencia) or die(mysqli_error($conexion));
			$totalRows_datosDependencia = mysqli_num_rows($datosDependencia);
			mysqli_close($conexion);			
		} catch (PDOException $e) 
		{
			echo 'Error: '. $e->getMessage();
		}
		
		$validar = "1";
	}
	else	
	{
		$validar = "0";		
	}
?>