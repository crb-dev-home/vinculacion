<?php
//header("Content-type: text/javascript; charset=iso-8859-1");
	if (isset($_POST["accion"])) 
	{
		$respuesta			="DONE";
		$varMensaje 		= "";
		$varEnviar 			= "";
		if (isset($_POST["idAlumno"]))
		{
			$idAlumno 			= $_POST['idAlumno'];
		}
		if (isset($_POST["nombre"]))
		{
			$nombre 			= utf8_decode($_POST['nombre']);
		}
		if (isset($_POST["apPaterno"]))
		{
			$apPaterno 			= utf8_decode($_POST['apPaterno']);
		}
		if (isset($_POST["apMaterno"]))
		{
			$apMaterno			= utf8_decode($_POST['apMaterno']);
		}
		if (isset($_POST["fechaNacimiento"]))
		{
			$fechaNacimiento	= $_POST['fechaNacimiento'];
		}
		if (isset($_POST["sexo"]))
		{
			$sexo 				= $_POST['sexo'];
		}
		if (isset($_POST["nss"]))
		{
			$nss 				= $_POST['nss'];
		}
		if (isset($_POST["curp"]))
		{
			$curp 				= strtoupper($_POST['curp']);
		}
		if (isset($_POST["domicilioAlumno"]))
		{
			$domicilioAlumno 	= utf8_decode($_POST['domicilioAlumno']);
		}
		if (isset($_POST["coloniaAlumno"]))
		{
			$coloniaAlumno 		= utf8_decode($_POST['coloniaAlumno']);
		}
		if (isset($_POST["ciudad"]))
		{
			$ciudad 			= utf8_decode($_POST['ciudad']);
		}
		if (isset($_POST["codigoPostal"]))
		{
			$codigoPostal 			= $_POST['codigoPostal'];
		}
		if (isset($_POST["telefono"]))
		{
			$telefono 			= $_POST['telefono'];
		}
		if (isset($_POST["email"]))
		{
			$email 				= $_POST['email'];
		}
		if (isset($_POST["carrera"]))
		{
			$carrera 			= utf8_decode($_POST['carrera']);
		}
		if (isset($_POST["semestre"]))
		{
			$semestre 			= $_POST['semestre'];
		}
		if (isset($_POST["creditos"]))
		{
			$creditos 			= $_POST['creditos'];
		}
		if (isset($_POST["accion"]))
		{
			$varAccion 			= $_POST["accion"];
		}
		
			
		try {
			require_once '../connections/conexion.php';
			
			if($varAccion == "eliminar")
			{
				$query_eliminarAlumno = sprintf("DELETE FROM tblAlumnos WHERE idAlumno = %s", $idAlumno);
				$eliminarAlumno = mysqli_query($conexion,$query_eliminarAlumno) or die(mysqli_error($conexion));
				if($eliminarAlumno != 1)
				{
						$varMensaje ="Error al eliminar Alumno!!!";
				}
				else 
				{
					$varMensaje ="Alumno Eliminado!!!";
				}
				$jsonEliminar=array("respuesta" => $respuesta,"mensaje" => $varMensaje);
				echo json_encode($jsonEliminar);
				mysqli_close($conexion);
			}
			if($varAccion == "editar")
			{
					
						$query_editarAlumno = sprintf("UPDATE tblAlumnos SET nomAlumno = '$nombre', apPaterno = '$apPaterno', apMaterno = '$apMaterno', fechaNacimiento = '$fechaNacimiento', sexo = '$sexo', nss = '$nss', curp = '$curp', carrera = '$carrera', email = '$email', telefono = '$telefono', domicilio = '$domicilioAlumno', colonia = '$coloniaAlumno', codigo = '$codigoPostal', semestre = '$semestre', creditos = '$creditos', ciudad = '$ciudad' WHERE idAlumno = '$idAlumno'");
						$editarAlumno = mysqli_query($conexion,$query_editarAlumno) or die(mysqli_error($conexion));
		
						if($editarAlumno != 1)
						{
								$varMensaje ="Error al editar Alumno!!!";								
						}
						else 
						{
							$varMensaje ="Alumno Editado!!!";
						}						
						$json=array("respuesta" => $respuesta,"mensaje" => $varMensaje);
						echo json_encode($json);
						mysqli_close($conexion);

			}	
			if($varAccion == "agregar")
			{
				$query_verificarAlumno = mysqli_query($conexion,"SELECT * FROM tblAlumnos WHERE idAlumno = '$idAlumno'") or die(mysqli_error($conexion));
				$verificarAlumno = mysqli_num_rows($query_verificarAlumno);
				
				if ($verificarAlumno == 0)
				{
					$query_agregarAlumno = sprintf("INSERT INTO tblalumnos (idAlumno, nomAlumno, apPaterno, apMaterno, fechaNacimiento, sexo,nss, curp, carrera, email, telefono, domicilio, colonia, codigo, semestre, creditos, ciudad) 
			VALUES ('$idAlumno', '$nombre', '$apPaterno', '$apMaterno', '$fechaNacimiento', '$sexo','$nss' '$curp', '$carrera', '$email', '$telefono', '$domicilioAlumno', '$coloniaAlumno', $codigoPostal, $semestre, $creditos, '$ciudad')");
					$agregarAlumno = mysqli_query($conexion,$query_agregarAlumno) or die(mysqli_error($conexion));
	
					if($agregarAlumno != 1)
					{
							$varMensaje ="Error al agregar Alumno!!!";
					}
					else 
					{
						$varMensaje ="Alumno agregado!!!";
					}
					$jsonAgregar=array("respuesta" => $respuesta,"mensaje" => $varMensaje);
					echo json_encode($jsonAgregar);
					mysqli_close($conexion);
				}
				else
				{
					$varMensaje = "Ya existe Alumno!!!";
					$jsonAgregar=array("respuesta" => $respuesta,"mensaje" => $varMensaje);
					echo json_encode($jsonAgregar);
					mysqli_close($conexion);
				}
				
			}
			if($varAccion == "consultar")
			{
				$query_datosAlumno = sprintf("SELECT `a`.`idAlumno` as `idAlumno`,`a`.`nomAlumno` as `nomAlumno`,`a`.`apPaterno` as `apPaterno`,`a`.`apMaterno` as `apMaterno`,`a`.`fechaNacimiento` as `fechaNacimiento`,`a`.`sexo` as `sexo`,`a`.`nss` as `nss`,`a`.`curp` as `curp`,`c`.`nomCarreraLargo` as `carrera`,`a`.`email` as `email`,`a`.`telefono` as `telefono`,`a`.`domicilio` as `domicilio`,`a`.`colonia` as `colonia`,`a`.`codigo` as `codigo`,`a`.`ciudad` as `ciudad`,`a`.`semestre` as `semestre`,`a`.`creditos` as `creditos`,`c`.`idCarrera` FROM `tblalumnos` `a` JOIN `tblcarreras` `c` ON `a`.`carrera`=`c`.`idCarrera`");
                $datosAlumno = mysqli_query($conexion,$query_datosAlumno) or die(mysqli_error($conexion));
					
				$jsonConsulta = array();
				while($row_datosAlumno = mysqli_fetch_array($datosAlumno,MYSQLI_ASSOC))
				{
					$jsonConsulta[] = array(
							'idAlumno' => $row_datosAlumno['idAlumno'],
							'nomAlumno' => utf8_encode($row_datosAlumno['nomAlumno']),
							'apPaterno' => utf8_encode($row_datosAlumno['apPaterno']),
							'apMaterno' => utf8_encode($row_datosAlumno['apMaterno']),
							'fechaNacimiento' => utf8_encode($row_datosAlumno['fechaNacimiento']),
							'sexo' => $row_datosAlumno['sexo'],
							'nss' => utf8_encode($row_datosAlumno['nss']),
							'curp' => utf8_encode($row_datosAlumno['curp']),
							'carrera' => utf8_encode($row_datosAlumno['carrera']),
							'semestre' => utf8_encode($row_datosAlumno['semestre']),
							'creditos' => utf8_encode($row_datosAlumno['creditos']),
							'email' => utf8_encode($row_datosAlumno['email']),							
							'telefono' => utf8_encode($row_datosAlumno['telefono']),							
							'domicilio' => utf8_encode($row_datosAlumno['domicilio']),
							'colonia' => utf8_encode($row_datosAlumno['colonia']),
							'ciudad' => utf8_encode($row_datosAlumno['ciudad']),
							'codigo' => utf8_encode($row_datosAlumno['codigo']),
							'idCarrera' => $row_datosAlumno['idCarrera']							
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