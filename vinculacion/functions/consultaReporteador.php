<?php
if (isset($_POST['fechaInicio']))
{
	if($_POST['fechaInicio'] != "")
	{
		$fechaInicio = "'".$_POST['fechaInicio']."'";
	}
	else
	{
		$fechaInicio = "CURDATE()-DAYOFMONTH(CURDATE())";
	}
	
}
else
{
	$fechaInicio = "CURDATE()-DAYOFMONTH(CURDATE())";
}
	

if (isset($_POST['fechaFinal']))
{
	if($_POST['fechaFinal'] != "")
	{
		$fechaFinal = "'".$_POST['fechaFinal']."'";
	}
	else
	{
		$fechaFinal = "CURDATE()";
	}
}
else
{
	$fechaFinal = "CURDATE()";
}

$mostrarTodo = "";

if(isset ($_POST['buscarTodo']))
{
	$mostrarTodo = $_POST['buscarTodo'];
}
		try 
		{	
			require_once '../connections/conexion.php';
			
			if ($mostrarTodo == "")
			{
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
        `e`.`nomCarreraLargo` AS `carrera`,
        `s`.`conDiscapacidad` AS `conDiscapacidad`,
        `d`.`nomDependencia` AS `nomDependencia`,
        `d`.`tipo` AS `tipo`,
		`d`.`giro` AS `giro`,
        `d`.`sector` AS `sector`,
        `s`.`responsableDependencia` AS `responsableDependencia`,
        `s`.`puestoResponsable` AS `puestoResponsable`,
        `s`.`telDependencia` AS `telDependencia`,
        `s`.`emailDependencia` AS `emailDependencia`,
        `s`.`programa` AS `programa`,
        `s`.`fechaInicio` AS `fechaInicio`,
        `s`.`fechaTermino` AS `fechaTermino`,
        `s`.`usuario` AS `usuario`
    FROM
        ((`tblsolicitudes` `s`
        JOIN `tblalumnos` `a` ON ((`a`.`idAlumno` = `s`.`idAlumno`)))
        JOIN `tbldependencias` `d` ON ((`d`.`idDependencia` = `s`.`idDependencia`))
		JOIN `tblcarreras` `e` ON ((`a`.`carrera` = `e`.`idCarrera`))) WHERE fechaSolicitud BETWEEN $fechaInicio AND $fechaFinal");
				$datosSolicitudes = mysqli_query($conexion, $query_datosSolicitudes) or die(mysqli_error($conexion));	
				
				while($row_datosSolicitudes = mysqli_fetch_array($datosSolicitudes, MYSQLI_ASSOC))
				{				
					$json[] = array(
							'numRegistro' => $row_datosSolicitudes['numRegistro'],          
							'idAlumno' => utf8_encode($row_datosSolicitudes['idAlumno']),
							'nomAlumno' => utf8_encode($row_datosSolicitudes['nomAlumno']),
							'apPaterno' => utf8_encode($row_datosSolicitudes['apPaterno']),
							'apMaterno' => utf8_encode($row_datosSolicitudes['apMaterno']),
							'sexo' => utf8_encode($row_datosSolicitudes['sexo']),
							'carrera' => utf8_encode($row_datosSolicitudes['carrera']),
							'conDiscapacidad' => utf8_encode($row_datosSolicitudes['conDiscapacidad']),
							'tipoSolicitud' => utf8_encode($row_datosSolicitudes['tipoSolicitud']),
							'fechaSolicitud' => utf8_encode($row_datosSolicitudes['fechaSolicitud']),               
							'fechaImpresion' => utf8_encode($row_datosSolicitudes['fechaImpresion']),
							'fechaEntregado' => utf8_encode($row_datosSolicitudes['fechaEntregado']),
							'usuario' => utf8_encode($row_datosSolicitudes['usuario']),
							'estatus' => utf8_encode($row_datosSolicitudes['status']),
							'nomDependencia' => utf8_encode($row_datosSolicitudes['nomDependencia']),
							'tipo' => utf8_encode($row_datosSolicitudes['tipo']),
							'giro' => utf8_encode($row_datosSolicitudes['giro']),
							'sector' => utf8_encode($row_datosSolicitudes['sector']),                 
							'responsableDependencia' => utf8_encode($row_datosSolicitudes['responsableDependencia']),
							'puestoResponsable' => utf8_encode($row_datosSolicitudes['puestoResponsable']),
							'telDependencia' => utf8_encode($row_datosSolicitudes['telDependencia']),
							'emailDependencia' => utf8_encode($row_datosSolicitudes['emailDependencia']), 
							'programa' => utf8_encode($row_datosSolicitudes['programa']),
							'fechaInicio' => utf8_encode($row_datosSolicitudes['fechaInicio']),
							'fechaTermino' => utf8_encode($row_datosSolicitudes['fechaTermino']) 
									);
														
				}
				echo json_encode($json);
				mysqli_close($conexion);
			}
			else 
			{
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
        `e`.`nomCarreraLargo` AS `carrera`,
        `s`.`conDiscapacidad` AS `conDiscapacidad`,
        `d`.`nomDependencia` AS `nomDependencia`,
		`d`.`tipo` AS `tipo`,
		`d`.`giro` AS `giro`,
        `d`.`sector` AS `sector`,
        `s`.`responsableDependencia` AS `responsableDependencia`,
        `s`.`puestoResponsable` AS `puestoResponsable`,
        `s`.`telDependencia` AS `telDependencia`,
        `s`.`emailDependencia` AS `emailDependencia`,
        `s`.`programa` AS `programa`,
        `s`.`fechaInicio` AS `fechaInicio`,
        `s`.`fechaTermino` AS `fechaTermino`,
        `s`.`usuario` AS `usuario`
    FROM
        ((`tblsolicitudes` `s`
        JOIN `tblalumnos` `a` ON ((`a`.`idAlumno` = `s`.`idAlumno`)))
        JOIN `tbldependencias` `d` ON ((`d`.`idDependencia` = `s`.`idDependencia`))
		JOIN `tblcarreras` `e` ON ((`a`.`carrera` = `e`.`idCarrera`)))");
				$datosSolicitudes = mysqli_query($conexion, $query_datosSolicitudes) or die(mysqli_error($conexion));
				
				while($row_datosSolicitudes = mysqli_fetch_array($datosSolicitudes, MYSQLI_ASSOC))
				{
					$json[] = array(
							'numRegistro' => $row_datosSolicitudes['numRegistro'],
							'idAlumno' => utf8_encode($row_datosSolicitudes['idAlumno']),
							'nomAlumno' => utf8_encode($row_datosSolicitudes['nomAlumno']),
							'apPaterno' => utf8_encode($row_datosSolicitudes['apPaterno']),
							'apMaterno' => utf8_encode($row_datosSolicitudes['apMaterno']),
							'sexo' => utf8_encode($row_datosSolicitudes['sexo']),
							'carrera' => utf8_encode($row_datosSolicitudes['carrera']),
							'conDiscapacidad' => utf8_encode($row_datosSolicitudes['conDiscapacidad']),
							'tipoSolicitud' => utf8_encode($row_datosSolicitudes['tipoSolicitud']),
							'fechaSolicitud' => utf8_encode($row_datosSolicitudes['fechaSolicitud']),
							'fechaImpresion' => utf8_encode($row_datosSolicitudes['fechaImpresion']),
							'fechaEntregado' => utf8_encode($row_datosSolicitudes['fechaEntregado']),
							'usuario' => utf8_encode($row_datosSolicitudes['usuario']),
							'estatus' => utf8_encode($row_datosSolicitudes['status']),
							'nomDependencia' => utf8_encode($row_datosSolicitudes['nomDependencia']),
							'tipo' => utf8_encode($row_datosSolicitudes['tipo']),
							'giro' => utf8_encode($row_datosSolicitudes['giro']),
							'sector' => utf8_encode($row_datosSolicitudes['sector']),
							'responsableDependencia' => utf8_encode($row_datosSolicitudes['responsableDependencia']),
							'puestoResponsable' => utf8_encode($row_datosSolicitudes['puestoResponsable']),
							'telDependencia' => utf8_encode($row_datosSolicitudes['telDependencia']),
							'emailDependencia' => utf8_encode($row_datosSolicitudes['emailDependencia']),
							'programa' => utf8_encode($row_datosSolicitudes['programa']),
							'fechaInicio' => utf8_encode($row_datosSolicitudes['fechaInicio']),
							'fechaTermino' => utf8_encode($row_datosSolicitudes['fechaTermino'])
					);
				
				}
				echo json_encode($json);
				mysqli_close($conexion);
			}
		}
		 catch (PDOException $e) 
		{
			echo 'Error: '. $e->getMessage();
		}		
?>