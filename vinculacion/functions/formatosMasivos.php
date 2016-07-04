<link rel="icon" href="../images/favicon.ico" type="image/ico" />
<?php
include '/fpdf/pdf_merge.php';

session_start();
try {
    require_once '../connections/conexion.php';


    $query = sprintf("SELECT * FROM tblsolicitudes WHERE status = 'Sin procesar'");
//    $query = sprintf("SELECT * FROM tblsolicitudes WHERE status = 'Entregado'");

    $resultados = mysqli_query($conexion, $query) or die(mysqli_error($conexion));
    $datos = array();

    while ($registro = mysqli_fetch_array($resultados, MYSQLI_ASSOC)) {
        $datos[] = $registro;
    }

    if (count($datos) > 0) {
        $pdf = new pdf_merge;
        $base_url = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER["REQUEST_URI"] . '?') . '/';
        $tempFiles = array();
        $idSolicitudes = '';

        foreach($datos as $dato){
           $numSolicitud = $dato['numRegistro'];

           $idSolicitudes = $idSolicitudes.$numSolicitud.',';
           $temp = tmpfile();
           $temp_file = tempnam(sys_get_temp_dir(), 'Carta');
           $tempFiles[] =  $temp_file;

            $tipoSolicitud = $dato['tipoSolicitud'];
            $formato = "";

            if ($tipoSolicitud == "residencia")
            {
                $formato = "formatoPresentacionResidencia.php";

            }
            else if ($tipoSolicitud == "practicas")
            {
                $formato = "formatoPresentacionPracticas.php";

            }
            else if ($tipoSolicitud == "beca-alumnos")
            {
                $formato = "formatoBecaAlumnos.php";

            }
            else if ($tipoSolicitud == "beca-egresados")
            {
                $formato = "formatoBecaEgresados.php";

            }
            else if ($tipoSolicitud == "constancia")
            {
                $formato= "formatoConstancia.php";

            }
            else if ($tipoSolicitud == "anexo-residencia")
            {
                $formato = "formatoAnexoResidencia.php";

            }
            else
            {
                $formato = "formatoPresentacionServicio.php";

            }

            $page = file_get_contents($base_url . $formato."?numSolicitud=".$numSolicitud, FILE_USE_INCLUDE_PATH);

           file_put_contents($temp_file, $page);

           $pdf->addPDF($temp_file);
        }



        $pdf->merge('browser'); // generate the file



        try {
            foreach ($tempFiles as $temp) {
                unlink($temp);
            }
        }catch (Exception $e){}


        $fecha = date("Y-m-d");
        $nombreUsuario = $_SESSION['usuario'];
        $idSolicitudes = rtrim($idSolicitudes,',');

        $query_consultarUsuario = "SELECT * FROM tblusuarios WHERE nomUsuario = '$nombreUsuario'";
        $consultarUsuario = mysqli_query($conexion,$query_consultarUsuario) or die(mysqli_error($conexion));

        $row_consultarUsuario = mysqli_fetch_assoc($consultarUsuario);
        $usuario = $row_consultarUsuario['idUsuario'];

        $query_procesarSolicitud = sprintf("UPDATE tblsolicitudes SET status = 'Procesado', fechaImpresion = '$fecha', usuario = '$usuario' WHERE numRegistro IN ($idSolicitudes)");
        $procesarSolicitud = mysqli_query($conexion, $query_procesarSolicitud) or die(mysqli_error($conexion));

        mysqli_close($conexion);
}else{
        echo 'No existen solicitudes abiertas por imprimir.';
    }

} catch (Exception $e) {
    echo 'Ocurrio un error al generar la solicitud. ' . $e->getMessage();
}
