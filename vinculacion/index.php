<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Gestión Tecnológica y Vinculación</title>
<link rel="icon" href="images/favicon.ico" type="image/ico" />
<script src="js/jquery.js"></script>
<style type="text/css">
@import url("css/main.css");
</style>
<link rel="stylesheet" href="css/menu.css" type="text/css" />
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<link href='https://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css'/>
</head>
<body>
<div id="bloqueo" style="width:100%;height:200%;display:none;background-color:#FFF;left:0;top:0;position:absolute;opacity:0.7;" ></div>
<div class="container">
  <div class="header">
  <?php include("includes/header.php"); ?>
  <br class="clearfloat" />
  <?php include("includes/menu.php"); ?>
</div>

<span class="archive-title">Departamento de Gestión</span>
<h1 class="featured-title">Tecnológica y Vinculación</h1>
<div class="content bg1">

    <?php require_once 'functions/validacion.php'; ?>
    <?php
$numcontrol = isset($_POST['numControl']) ? $_POST['numControl'] : null;
$tiposolicitud = isset ($_POST['tipoSolicitud']) ? $_POST['tipoSolicitud'] : null;
$bandera = isset($_GET['band']) ? $_GET['band'] : null;
if ($bandera == 'true'){
	$numcontrol = isset($_GET['id']) ? $_GET['id'] : null;
}
//Esto guardara el error.
$errores = array();
$existe = 'SI';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	//Valida que el campo nombre no esté vacío.
   if (!validaRequerido($numcontrol)) 
   {
      $errores[] = 'Debe capturar número de control.';
   }
   //Valida que el campo no sea menor de 8 caracteres.
   if (!validarLongitud($numcontrol)) 
   {
      $errores[] = 'Número de control debe ser de 8 caracteres.';
   }
   //Valida que el campo tenga solo valores 0-9.
   if (!validaNumerico($numcontrol)) 
   {
      $errores[] = 'Debe ser numerico.';
   }
   if(!$errores){
	   	require_once 'connections/conexion.php';
	   	//Datos Alumno
	   	$query_datosAlumno = sprintf("SELECT idAlumno FROM `tblalumnos` WHERE idAlumno = '$numcontrol'");
	   	$datosAlumno = mysqli_query($conexion, $query_datosAlumno) or die(mysqli_error($conexion));
	   	$row_datosAlumno = mysqli_fetch_assoc($datosAlumno);
	   	$totalRows_datosAlumno = mysqli_num_rows($datosAlumno);
	   	mysqli_close($conexion);
	   	 
	   	if($totalRows_datosAlumno == 0 ){
	   		$existe = 'NO';
	   	}
	   	if ($existe == 'NO'){
	   		 
	   		header('Location: pages/registroAlumno.php?numControl='.$numcontrol.'&tipo='.$tiposolicitud); //crb01
	   	}
   }  
   if ($tiposolicitud == "Seleccione el tipo de solicitud")
   {
	   $errores[] = 'Debes seleccionar un elemento de la lista';
   } 
   if(!$errores && $existe == 'SI')
   {	
	   	if($tiposolicitud == "servicio")
	   	{
	   		header('Location: pages/servicio-social.php?numControl='.$numcontrol.'&tipo='.$tiposolicitud);
	   	}
	   	if($tiposolicitud == "residencia")
	   	{
	   		header('Location: pages/residencia.php?numControl='.$numcontrol.'&tipo='.$tiposolicitud);
	   	}
	   	if($tiposolicitud == "practicas")
	   	{
	   		header('Location: pages/practicas.php?numControl='.$numcontrol.'&tipo='.$tiposolicitud);
	   	}
	   	if($tiposolicitud == "alumnos")
	   	{
	   		header('Location: pages/beca-alumnos.php?numControl='.$numcontrol.'&tipo='.$tiposolicitud);
	   	}
	   	if($tiposolicitud == "egresados")
	   	{
	   		header('Location: pages/beca-egresados.php?numControl='.$numcontrol.'&tipo='.$tiposolicitud);
	   	}
	   	if($tiposolicitud == "constancia")
	   	{
	   		header('Location: pages/constancia.php?numControl='.$numcontrol.'&tipo='.$tiposolicitud);
	   	}
	   	if($tiposolicitud == "anexo")
	   	{
	   		header('Location: pages/anexo-residencia.php?numControl='.$numcontrol.'&tipo='.$tiposolicitud);
	   	}   	 
     exit; 
	}
}
?>
    <h2> Bienvenidos </h2>
    <p>Bienvenidos a la p&aacute;gina de el departamento de Departamento de Gesti&oacute;n Tecnol&oacute;gica y Vinculaci&oacute;n. Aquí podrás solicitar tu carta de presentación para Becas de Servicio Social, Residencia, Prácticas,  etc., y acudir&aacute;s al departamento solo a recoger tu carta firmada o para alguna aclaraci&oacute;n.</p>
    <p>Ingresa tu número de control y selecciona el tipo de solicitud:</p>
    <form name="consultaAlumno" id="consultaAlumno" method="post">
      <p>
        <label for="numControl"></label>
        <input type="text" name="numControl" id="numControl" style="text-align:center" maxlength="8" value="<?php echo $numcontrol ?>" />
        <input name="consultar" type="submit" id="consultar" class="consultar" value="Consultar"/>
      </p>
      <p>
        <select name="tipoSolicitud" id="tipoSolicitud" style="width:220px">
        	<option selected="selected">Seleccione el tipo de solicitud</option>
                <optgroup label="Cartas de presentaci&oacute;n">                
                <option value="residencia">Residencias Profesionales</option>
                <option value="practicas">Pr&aacute;cticas Profesionales</option>
            </optgroup>
            <optgroup label="Becas Servicio Social">
            	<option value="servicio">Carta de Presentacion</option>
            	<option value="alumnos">Postulacion Alumnos Inscritos</option>
                <option value="egresados">Postulacion Egresados</option>
                <option value="constancia">Constancia de conlusi&oacute;n</option>
            </optgroup>
            <optgroup label="Anexos">
            	<option value="anexo">Anexo al Convenio de Colaboración</option>
            </optgroup>
        </select>
      </p>
      <p>&nbsp;</p>
    </form>
    
     <div id="divAltaAlumno" style="display: none;">    	
    </div>
    
    <?php if ($existe == 'NO'){
    	echo '<ul style="color:#F00">';
		echo '<li>No existen datos relacionados a este usuario, capture información</li><input name="altaAlumno" type="button" id="altaAlumno" class="consultar" value="Alta" style="float: left;" onclick="location.href="../index.php"/>';?>
    	<script> 
    		activaBoton(true);
            </script>
    <?php }?>
    
    
    
    <?php 
	if ($errores)
	{
		echo '<ul style="color:#F00">';
		foreach ($errores as $error)
			echo '<li>'.$error.'</li>';
		
	}
	?>  
	
<div id='fbox-background'>
<div id='fbox-close'>
</div>
<div id='fbox-display'>
<div id='fbox-button'>
</div>
<iframe allowtransparency='true' frameborder='0' scrolling='no' src='//www.facebook.com/plugins/likebox.php?
href=https://www.facebook.com/Bolsa-de-Trabajo-ITT-1404346779886692&width=402&height=255&colorscheme=light&show_faces=true&show_border=false&stream=false&header=false'
style='border: none; overflow: hidden; background: #fff; width: 402px; height: 214px;'></iframe>
</div>
</div>	
<!-- end .content --></div>
<script type='text/javascript'>
//<![CDATA[
jQuery.cookie = function (key, value, options) {
// key and at least value given, set cookie...
if (arguments.length > 1 && String(value) !== "[object Object]") {
options = jQuery.extend({}, options);
if (value === null || value === undefined) {
options.expires = -1;
}
if (typeof options.expires === 'number') {
var days = options.expires, t = options.expires = new Date();
t.setDate(t.getDate() + days);
}
value = String(value);
return (document.cookie = [
encodeURIComponent(key), '=',
options.raw ? value : encodeURIComponent(value),
options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
options.path ? '; path=' + options.path : '',
options.domain ? '; domain=' + options.domain : '',
options.secure ? '; secure' : ''
].join(''));
}
// key and possibly options given, get cookie...
options = value || {};
var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;
return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
};
//]]>
</script>
<script type='text/javascript'>
jQuery(document).ready(function($){
if($.cookie('popup_facebook_box') != 'yes'){
$('#fbox-background').delay(3000).fadeIn('medium');
$('#fbox-button, #fbox-close').click(function(){
$('#fbox-background').stop().fadeOut('medium');
});
}
$.cookie('popup_facebook_box', 'yes', { path: '/', expires: 1 });
});

////////////////////



</script>
<br class="clearfloat" />

<div class="footer"><?php include("includes/footer.php"); ?>
</div>
</div>
</body>
</html>
