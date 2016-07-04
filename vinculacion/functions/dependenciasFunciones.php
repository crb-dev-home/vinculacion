<?php
//header("Content-type: text/javascript; charset=iso-8859-1");
	if (isset($_POST["accion"])) 
	{
		$respuesta="DONE";
		$varMensaje = "";
		$varEnviar = "";
		$idDependencia = "";
		if (isset($_POST['idDependencia']))
		{
			$idDependencia = $_POST['idDependencia'];
		}
		if (isset($_POST['nomDependencia']))
		{
			$nomDependencia = utf8_decode($_POST['nomDependencia']);
		}
		if (isset($_POST['nombreCorto']))
		{
			$nombreCorto = utf8_decode($_POST['nombreCorto']);
		}
		if (isset($_POST['tipo']))
		{
			$tipo = $_POST['tipo'];
		}
		if (isset($_POST['sector']))
		{
			$sector =  utf8_decode($_POST['sector']);
		}
		$rfc = "";
		if (isset($_POST['rfc']))
		{
			$rfc = $_POST['rfc'];
		}
		$giro = "N/A";
		if (isset($_POST['giro']))
		{
			$giro = $_POST['giro'];
		}
		$domicilio = "";
		if (isset($_POST['domicilio']))
		{
			$domicilio = utf8_decode($_POST['domicilio']);
		}
		$colonia = "";
		if (isset($_POST['colonia']))
		{
			$colonia = utf8_decode($_POST['colonia']);
		}
		$ciudad = "";
		if (isset($_POST['ciudad']))
		{
			$ciudad = $_POST['ciudad'];
		}
		$codigo = "";
		if (isset($_POST['codigo']))
		{
			$codigo = $_POST['codigo'];
		}
		
		$varAccion = $_POST["accion"];
			
		try {
			require_once '../connections/conexion.php';
			
			if($varAccion == "eliminar")
			{
				$query_eliminarDependencia = sprintf("DELETE FROM tbldependencias WHERE idDependencia = %s", $idDependencia);
				$eliminarDependencia = mysqli_query($conexion,$query_eliminarDependencia) or die(mysqli_error($conexion));
				if($eliminarDependencia != 1)
				{
						$varMensaje ="Error al eliminar Dependencia!!!";
				}
				else 
				{
					$varMensaje ="Dependencia Eliminada!!!";
				}
				$jsonEliminar=array("respuesta" => $respuesta,"mensaje" => $varMensaje);
				echo json_encode($jsonEliminar);
				mysqli_close($conexion);
			}
			if($varAccion == "editar")
			{
					
						$query_editarDependencia = sprintf("UPDATE tbldependencias SET nomDependencia = '$nomDependencia', cortoDependencia = '$nombreCorto',RFC = '$rfc',tipo = '$tipo', sector = '$sector',giro = '$giro',domicilio = '$domicilio', colonia = '$colonia',ciudad = '$ciudad',codigo = '$codigo' WHERE idDependencia = '$idDependencia'");
						$editarDependencia = mysqli_query($conexion,$query_editarDependencia) or die(mysqli_error($conexion));
		
						if($editarDependencia != 1)
						{
								$varMensaje ="Error al editar Dependencia!!!";								
						}
						else 
						{
							$varMensaje ="Dependencia Editada!!!";
						}						
						$json=array("respuesta" => $respuesta,"mensaje" => $varMensaje);
						echo json_encode($json);
						mysqli_close($conexion);

			}	
			if($varAccion == "agregar")
			{
				$query_verificarDependencia = mysqli_query($conexion,"SELECT * FROM tbldependencias WHERE nomDependencia = '$nomDependencia'") or die(mysqli_error($conexion));
				$verificarDependencia = mysqli_num_rows($query_verificarDependencia);
				
				if ($verificarDependencia == 0)
				{
					$query_agregarDependencia = sprintf("INSERT INTO tbldependencias(nomDependencia,cortoDependencia,RFC,tipo,sector,giro,domicilio,colonia,ciudad,codigo) VALUES ('$nomDependencia','$nombreCorto','$rfc','$tipo','$sector','$giro','$domicilio','$colonia','$ciudad','$codigo')");
					$agregarDependencia = mysqli_query($conexion,$query_agregarDependencia) or die(mysqli_error($conexion));
	
					if($agregarDependencia != 1)
					{
							$varMensaje ="Error al agregar Dependencia!!!";
					}
					else 
					{
						$varMensaje ="Dependencia agregada!!!";
					}
					$jsonAgregar=array("respuesta" => $respuesta,"mensaje" => $varMensaje);
					echo json_encode($jsonAgregar);
					mysqli_close($conexion);
				}
				else
				{
					$varMensaje = "Ya existe una dependencia con ese nombre!!!";
					$jsonAgregar=array("respuesta" => $respuesta,"mensaje" => $varMensaje);
					echo json_encode($jsonAgregar);
					mysqli_close($conexion);
				}
				
			}
			if($varAccion == "consultar")
			{
				$query_datosDependencia = sprintf("SELECT * FROM tbldependencias ORDER BY nomDependencia");
                $datosDependencia = mysqli_query($conexion,$query_datosDependencia) or die(mysqli_error($conexion));
					
				$jsonConsulta = array();
				while($row_datosDependencia = mysqli_fetch_array($datosDependencia,MYSQLI_ASSOC))
				{
					$jsonConsulta[] = array(
							'idDependencia' => $row_datosDependencia['idDependencia'],
							'nomDependencia' => utf8_encode($row_datosDependencia['nomDependencia']),
							'corto' => utf8_encode($row_datosDependencia['cortoDependencia']),
							'rfc' => $row_datosDependencia['RFC'],
							'sector' => utf8_encode($row_datosDependencia['sector']),
							'tipo' => $row_datosDependencia['tipo'],
							'giro' => utf8_encode($row_datosDependencia['giro']),
							'domicilio' => utf8_encode($row_datosDependencia['domicilio']),
							'colonia' => utf8_encode($row_datosDependencia['colonia']),
							'ciudad' => utf8_encode($row_datosDependencia['ciudad']),
							'codigo' => utf8_encode($row_datosDependencia['codigo'])
					);
						
				}	
				echo json_encode($jsonConsulta);
				mysqli_close($conexion);
			}		
			
						
		} catch (PDOException $e) {
			echo 'Error al eliminar datos: '. $e->getMessage();
		}
	}
?>