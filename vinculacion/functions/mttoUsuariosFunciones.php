<?php
	$varMensaje = "";	
	try {
		
		if (isset($_POST['accion'])){
			$varAccion = $_POST['accion'];
			$respuesta="DONE";
			$varControl = "";
			$varNombre = "";			
			$varMensaje = "";
			$varEnviar = "";
			$varPassword = "";
			
			
			if (isset($_POST['password'])){
				$varPassword = $_POST['password'];
			}
			if (isset($_POST['idUsuario'])){		
				$varControl = $_POST['idUsuario'];
			}
			if (isset($_POST['nombre'])){
				$varNombre = utf8_decode($_POST['nombre']);
			}
			
			//Configuracion fechas beca
			$inicioBeca = "";
			$finBeca = "";
			if (isset($_POST['inicioBeca']))
			{
				$inicioBeca = $_POST['inicioBeca'];
			}
			if (isset($_POST['finBeca']))
			{
				$finBeca = $_POST['finBeca'];
			}

			require_once '../connections/conexion.php';
			
			if($varAccion == 'Eliminar'){
				$query_usuarios = sprintf("DELETE FROM tblusuarios WHERE idUsuario = '$varControl'");
				$datosUsuario = mysqli_query($conexion,$query_usuarios) or die(mysqli_error($conexion));	
				if($datosUsuario==1){
					$varMensaje ="Usuario Eliminado!!!";
					$varEnviar = "1";
				}else{
					$varMensaje ="Error al eliminar el usuario!!!";
				}	
				$jsonEliminar=array("respuesta" => $respuesta,"mensaje" => $varMensaje);
				echo json_encode($jsonEliminar);
				mysqli_close($conexion);
			}elseif($varAccion == 'Editar')
			{
				if($varPassword != "")
				{
					$query_usuarios = sprintf("UPDATE tblusuarios SET nomUsuario = '$varNombre', password = sha('$varPassword') WHERE idUsuario = '$varControl'" );
				}
				else
				{
					$query_usuarios = sprintf("UPDATE tblusuarios SET nomUsuario = '$varNombre' WHERE idUsuario = '$varControl'" );
				}
				$datosUsuario = mysqli_query($conexion,$query_usuarios) or die(mysqli_error($conexion));
				if($datosUsuario==1){
					$varMensaje ="Se modifico el usuario!!!";
				}else{
					$varMensaje ="Error al modificar el usuario!!!";
					$varEnviar = "1";
				}
				$json=array("respuesta" => $respuesta,"mensaje" => $varMensaje);
				echo json_encode($json);
				mysqli_close($conexion);
			}
			elseif($varAccion == 'Alta')
			{
				$query_verificarUsuario = mysqli_query($conexion,"SELECT * FROM tblusuarios WHERE idUsuario = '$varControl'") or die(mysqli_error($conexion));
				$verificarUsuario = mysqli_num_rows($query_verificarUsuario);
					
					if ($verificarUsuario == 0)
					{				
						$query_usuarios = sprintf("INSERT INTO tblusuarios (idUsuario, nomUsuario, password) VALUES ('$varControl', '$varNombre', sha('$varPassword'))" );	
						$datosUsuario = mysqli_query($conexion,$query_usuarios) or die(mysqli_error($conexion));
						if($datosUsuario==1){
							$varMensaje ="Se realizo el alta!!!";
							$varEnviar = "1";
						}else{
							$varMensaje ="Error al ejecutar el alta!!!";
							$varEnviar = "1";
						}
					}
					else
					{
						$varMensaje = "Ya existe un usuario con ese nombre!!!";
						$varEnviar = "1";					
					}
					$jsonAgregar=array("respuesta" => $respuesta,"mensaje" => $varMensaje);
					echo json_encode($jsonAgregar);
					mysqli_close($conexion);
			}
			if($varAccion == "consultar")
			{
				$query_datosUsuarios = sprintf("SELECT * FROM tblusuarios");
				$datosUsuarios = mysqli_query($conexion,$query_datosUsuarios) or die(mysqli_error($conexion));
					
				$jsonConsulta = array();
				while($row_datosUsuarios = mysqli_fetch_array($datosUsuarios,MYSQLI_ASSOC))
				{
					$jsonConsulta[] = array(
							'idUsuario' => $row_datosUsuarios['idUsuario'],
							'nomUsuario' => utf8_encode($row_datosUsuarios['nomUsuario']),
					);
			
				}
				echo json_encode($jsonConsulta);
				mysqli_close($conexion);
			}
			
			
			if($varAccion == 'guardarFecha')
			{
				$query_fechas = sprintf("UPDATE tblfechabeca SET fechaInicioBeca = '$inicioBeca', fechaTerminoBeca = '$finBeca'" );
				
				$fechas = mysqli_query($conexion,$query_fechas) or die(mysqli_error($conexion));
				
				if($fechas == 1)
				{
					$varMensaje ="Se guardaron las fechas!!!";
				}
				else
				{
					$varMensaje ="Error al guardar fechas!!!";
					$varEnviar = "1";
				}
				$json = array("respuesta" => $respuesta,"mensaje" => $varMensaje);
				echo json_encode($json);
				mysqli_close($conexion);
			}
		}
	} catch (Exception $e) {
		echo 'Error: '. $e->getMessage();
	}
?>

