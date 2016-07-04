<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
	session_start();
	if(!isset($_SESSION['usuario'])) 
	{
  		header('Location: ../_admin.php'); 
  		exit();
	}

?>
<title>Gestión Tecnológica y Vinculación</title>
	<link rel="icon" href="../images/favicon.ico" type="image/ico" />
	<link href="../css/datatables.css" type="text/css" rel="stylesheet"/>
    <link href="../css/TableTools.css" type="text/css" rel="stylesheet"/>
    <link href="../css/jquery-ui.css" type="text/css" rel="stylesheet"/>
    <link href="../css/theme.css" type="text/css" rel="stylesheet"/>  
    <link href="../css/admin_main.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/menu.css" type="text/css" />
	<link href='https://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css'/>  
	
	<script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/columnfilter.js"></script>
    <script src="../js/ZeroClipboard.js"></script>
    <script src="../js/TableTools.js"></script> 
    <script src="../js/dependenciasFunciones.js"></script>       

</head>
<body onload="loadDT()">
<div class="container">
  	<div class="header">
 		<?php include("../includes/admin_header.php"); ?>
 		<br class="clearfloat" />
 		<?php include("../includes/menu_admin.php"); ?>
	</div>
	<span class="archive-title">Departamento de Gestión</span>
	<h1 class="featured-title">Tecnológica y Vinculación</h1>
	<h2 class="featured-title2">Dependencias</h2>
	<div id="content" class="content bg1">
		<div id="divEditarDependencia" title="Editar Dependencia/Empresa">
	    <p class="validateTips"></p>
	    	<form style="width:100%">
	    		<input class="textbox" id="idDependencia" type="hidden" value=""/>
	            <label style="margin-left:20px">Nombre Largo:</label><br />
				<input class="txtbxEditar" title="Solo letras" id="editarNombreLargo" type="text" value=""/><br />
				<label style="margin-left:20px">Nombre Corto:</label><br />
				<input class="txtbxEditar" title="Solo letras" id="editarNombreCorto" type="text" value=""/><br />
				<label style="margin-left:20px">RFC:</label><br />
				<input class="txtbxEditar" id="editarRFC" type="text" value=""/><br />
				<label style="margin-left:20px">Tipo:</label><br />
	            <select class="txtbxEditar" name="editarTipo" id="editarTipo">
	            	<option value="Dependencia">Dependencia</option>
	                <option value="Empresa">Empresa</option>
				</select><br />                        
				<label style="margin-left:20px">Sector:</label><br />
	            <select class="txtbxEditar" name="editarSector" id="editarSector">
		            <option value="Educativo">Educativo</option>
		            <option value="Publico">Público</option>
		            <option value="Privado">Privado</option>
		            <option value="Social">Social</option>
	            </select><br />
	            <label style="margin-left:20px">Giro:</label>
		        <select class="txtbxEditar" name="editarGiro" id="editarGiro">
		        		<option value="N/A">N/A</option>
		                <option value="Industrial">Industrial</option>
		                <option value="Servicios">Servicios</option>
		                <option value="Otro">Otro</option>
		        </select>
		        <label style="margin-left:20px">Calle Y Número:</label><br />
				<input class="txtbxEditar" id="editarDomicilio" type="text" value=""/><br />
				<label style="margin-left:20px">Colonia:</label><br />
				<input class="txtbxEditar" id="editarColonia" type="text" value=""/><br />
				<label style="margin-left:20px">Ciudad:</label><br />
				<input class="txtbxEditar" id="editarCiudad" type="text" value=""/><br />
				<label style="margin-left:20px">Codigo Postal:</label><br />
				<input class="txtbxEditar" id="editarCP" type="text" value=""/><br />
	            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px"/>
			</form>
		</div>
		<div id="contenidoTabla">
			<input id="nuevaDep" type="button" value="Nueva Dependencia/Empresa" style="height:36px; margin-bottom:5px;font-family: 'Marcellus', serif"/><!-- <input id="editarDep" type="button" value="Editar Dependencia" style="height:36px; margin-left:30px; margin-bottom:5px; font-family: 'Marcellus', serif"/> -->
	        <table id="dependencias" style="text-align:center">
		        <thead>
		        	<tr>
						<th></th>
		                <th>Nombre</th>
		                <th>Nombre Corto</th>
		                <th></th>
		                <th>Sector</th> 
		                <th>Tipo</th>
		                <th>Giro</th>
		                <th></th>
		                <th></th>
		                <th></th>
		                <th></th>		                                 
					</tr>
		            <tr>
		            	<th>ID</th>
		                <th>Nombre</th>
		                <th>Nombre Corto</th>
		                <th>RFC</th>
		                <th>Sector</th> 
		                <th>Tipo</th>
		                <th>Giro</th>
		                <th>Domicilio</th>
		                <th>Colonia</th>
		                <th>Ciudad</th>
		                <th>Codigo Postal</th>		                
					</tr>                                          
				</thead>                     
	        </table>
	        <div id="divAgregarDependencia" title="Nueva Dependencia/Empresa">
	        <p class="validateTips">No se permite vacio.</p>
	        	<form id="frmAgregarDependencia" style="width:100%">
	        	<label style="margin-left:20px">Nombre Largo:</label><br />
				<input class="txtbxEditar" title="Solo letras" id="nombreLargo" type="text" value=""/><br />
				<label style="margin-left:20px">Nombre Corto:</label><br />
				<input class="txtbxEditar" title="Solo letras" id="nombreCorto" type="text" value=""/><br />
				<label style="margin-left:20px">RFC:</label><br />
				<input class="txtbxEditar" id="RFC" type="text" value=""/><br />
		        <label style="margin-left:20px">Tipo:</label><br />
		        <select class="txtbxEditar" name="tipo" id="tipo"  onchange="validarGiro()">
		        	<option selected="selected">---</option>
		            <option value="Dependencia">Dependencia</option>
		            <option value="Empresa">Empresa</option>
				</select><br />                 
		        <label style="margin-left:20px">Sector:</label><br />
		        <select class="txtbxEditar" name="sector" id="sector">
		            <option selected="selected">---</option>
		            <option value="Educativo">Educativo</option>
		            <option value="Publico">Público</option>
		            <option value="Privado">Privado</option>
		            <option value="Social">Social</option>
	            </select>
	            <label style="margin-left:20px">Giro:</label><br />
	            <select class="txtbxEditar" name="giro" id="giro">
	            		<option selected="selected">---</option>
		        		<option value="N/A">N/A</option>
		                <option value="Industrial">Industrial</option>
		                <option value="Servicios">Servicios</option>
		                <option value="Otro">Otro</option>
		        </select>
		        <label style="margin-left:20px">Calle Y Número:</label><br />
				<input class="txtbxEditar" id="domicilio" type="text" value=""/><br />
				<label style="margin-left:20px">Colonia:</label><br />
				<input class="txtbxEditar" id="colonia" type="text" value=""/><br />
				<label style="margin-left:20px">Ciudad:</label><br />
				<input class="txtbxEditar" id="ciudad" type="text" value=""/><br />
				<label style="margin-left:20px">Codigo Postal:</label><br />
				<input class="txtbxEditar" id="CP" type="text" value=""/><br />
	            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px"/>
				</form>
			</div>
	        <input id="reloadDT" type="button" style="display: none"/>
	<script>
	var dialog, form, dialogEditar, formEditar,
	nombreLargo = $("#nombreLargo"),
	nombreCorto = $("#nombreCorto"),
	RFC	= $("#RFC"),
	tipo = $("#tipo"),
	sector = $("#sector"),
	giro = $("#giro"),
	edNombreLargo= $("#editarNombreLargo"),
	edNombreCorto = $("#editarNombreCorto"),
	tipoEditar = $("#editarTipo"),
	sectorEditar = $("#editarSector"),
	allFields = $( [] ).add( nombreLargo ).add( nombreCorto ).add( tipo ).add( giro ).add( sector ).add( edNombreLargo ).add( edNombreCorto ).add( tipoEditar ).add( sectorEditar ),
	tips = $( ".validateTips" );
	
	function loadDT()
	{
		document.getElementById("reloadDT").click();
	}
	
	function updateTips( t ){
		tips
		.text( t )
		.addClass( "ui-state-highlight" );
		setTimeout(function() {
			tips.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
	}

	function validarGiro()
	{
		var tipo = document.getElementById("tipo").value;
		if (tipo == "Dependencia")
		{
			document.getElementById("giro").value = "N/A";
		}
		else
			document.getElementById("giro").value = "---";
	}
			
	function verificarVacio(nombreLargoAlta,nombreCortoAlta,tipoAlta,sectorAlta, giroAlta,rfcAlta)
	{
		var tipoDep = document.getElementById("tipo").value;
		
		if (nombreLargoAlta == "")
		{
			nombreLargo.addClass("ui-state-error");
	        updateTips("Ingrese Nombre");
	        return false;
	    }
		if (nombreCortoAlta == "")
		{
			nombreCorto.addClass("ui-state-error");
	        updateTips("Ingrese Nombre");
	        return false;
	    }
		else if(rfcAlta == "")
		{
			RFC.addClass("ui-state-error");
			updateTips("Ingrese RFC");
			return false;
		}
		else if (tipoAlta == "---")
	    {
		    tipo.addClass("ui-state-error");
		    updateTips("Seleccione Tipo");
		    return false;
		}
		else if (sectorAlta == "---")
	    {
	    	sector.addClass("ui-state-error");
	        updateTips("Seleccione Sector");
	        return false;
		}
		else if (giroAlta == "---")
		{
			giro.addClass("ui-state-error");
	        updateTips("Seleccione Giro");
	        return false;
		}
		else if (giroAlta == "N/A" && tipoDep == "Empresa")
		{
			giro.addClass("ui-state-error");
	        updateTips("Seleccione Giro");
	        return false;
		}
		else
		{
	    	return true;
	    }
	}
			
	function checkRegexp( o, regexp, n )
	{
		if ( !( regexp.test( o.val() ) ) ) 
		{
			o.addClass( "ui-state-error" );
			updateTips( n );
			return false;
		} 
		else 
		{
			return true;
		}
	}
			
	function agregar()
	{
		var valido = true;
		allFields.removeClass("ui-state-error");

		var nombreLargoAlta = document.getElementById("nombreLargo").value;
		var nombreCortoAlta = document.getElementById("nombreCorto").value;
		var rfcAlta = document.getElementById("RFC").value;
		var sectorAlta = document.getElementById("sector").value;
		var tipoAlta = document.getElementById("tipo").value;
		var giroAlta = document.getElementById("giro").value;
		var domicilioAlta = document.getElementById("domicilio").value;
		var coloniaAlta = document.getElementById("colonia").value;
		var ciudadAlta = document.getElementById("ciudad").value;
		var codigoAlta = document.getElementById("CP").value;
		var data = {accion: "agregar", nomDependencia: nombreLargoAlta,nombreCorto: nombreCortoAlta,rfc: rfcAlta, tipo: tipoAlta, sector: sectorAlta,giro: giroAlta,domicilio: domicilioAlta,colonia: coloniaAlta,ciudad: ciudadAlta,codigo: codigoAlta};
		
		valido = valido && verificarVacio(nombreLargoAlta, nombreCortoAlta, tipoAlta, sectorAlta, giroAlta,rfcAlta);



	    
	    
	    if (valido)
	    {
	    	dialog.dialog( "close" );
	    	$.ajax({
				url: '../functions/dependenciasFunciones.php',
				type: 'POST',
				dataType: 'json',
				data: data,
				success: function(alta)
				{
						alert(alta.mensaje);
						document.getElementById("reloadDT").click();
				},
				error: function(e)
				{
				   console.log(e.responseText);	
				}
			});	
		}
	}
	      
	    dialog = $("#divAgregarDependencia").dialog ({
	    autoOpen : false,
	    height: 700,
	    width: 350,
	    modal:true,
	    resizable: false,
	    buttons: {
	    	"Guardar": agregar,
	        "Cancelar": function() {
		        dialog.dialog( "close" );
			}
	    },
		close: function() {
	    	form[ 0 ].reset();
			$(".ui-state-error").removeClass("ui-state-error");
	        }
		});
	        
	           
	    $("#nuevaDep").click (function (event)    // Open button Treatment
	    {
	    	dialog.dialog("open");
		});
	
	</script>
	</div>
</div>
<br class="clearfloat" />
<div class="footer"><?php include("../includes/admin_footer.php"); ?>
</div>
</div>
</body>
</html>
