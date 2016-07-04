<?php
	$varMensaje = "";	
	try {
		
		if (isset($_POST['accion'])){
			$varAccion = $_POST['accion'];
			$respuesta="DONE";

			$idConfiguracion = "";
			$valorConfiguracion = "";

			if (isset($_POST['idConfiguracion'])){
				$idConfiguracion =  $_POST['idConfiguracion'];
			}

			if (isset($_POST['valorConfiguracion'])){
				$valorConfiguracion = $_POST['valorConfiguracion'];
			}

			require_once '../connections/conexion.php';
			
			 if($varAccion == 'guardar')
			{

				$query = sprintf("UPDATE tblconfiguraciones SET valor = '$valorConfiguracion' WHERE id = '$idConfiguracion'" );

				$datos = mysqli_query($conexion,$query) or die(mysqli_error($conexion));
				if($datos==1){
					$varMensaje ="Se guardo la configuracion!!!";
				}else{
					$varMensaje ="Error al guardar la configuracion!!!";
					$varEnviar = "1";
				}
				$json=array("respuesta" => $respuesta,"mensaje" => $varMensaje);
				echo json_encode($json);
				mysqli_close($conexion);
			}

			if($varAccion == "consultar")
			{
				$query = sprintf("SELECT * FROM tblconfiguraciones WHERE id='$idConfiguracion'");
				$datos = mysqli_query($conexion,$query) or die(mysqli_error($conexion));

				$json = "";
				if($row_datosUsuarios = mysqli_fetch_array($datos,MYSQLI_ASSOC))
				{
					$json=array("id" => $row_datosUsuarios['id'],"valor" => $row_datosUsuarios['valor']);
			
				}
				echo json_encode($json);
				mysqli_close($conexion);
			}
		}
	} catch (Exception $e) {
		echo 'Error: '. $e->getMessage();
	}
?>

