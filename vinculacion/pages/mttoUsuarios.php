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
	<link rel="stylesheet" href="../css/menu.css" type="text/css" />
	<link href='https://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css'/>
	<link href="../css/datatables.css" type="text/css" rel="stylesheet"/>
    <link href="../css/jquery-ui.css" type="text/css" rel="stylesheet"/>
    <link href="../css/theme.css" type="text/css" rel="stylesheet"/>
    <link href="../css/admin_main.css" type="text/css" rel="stylesheet"/>   
	
	<script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/funcionesMttoUsuario.js"></script>       

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
<h2 class="featured-title2">Mantenimiento de Usuarios</h2>
	<div id="content" class="content bg1">		
    <div id="divEditarUsuario" title="Editar Usuario">
	<p class="validarTips">No se permite vacio.</p>
	<form>
        	<label style="margin-left:30px">Usuario</label><br />
			<input class="txtbxEditarUsuario" disabled="disabled" id="idUsuario" type="text" value=""/><br />                        
			<label style="margin-left:30px">Nombre Usuario</label><br />
            <input class="txtbxEditarUsuario" disabled="disabled" maxlength="20" id="nombreUsuarioEditar" type="text" value=""/><br />
            <label style="margin-left:30px">Nuevo Nombre Usuario</label><br />
            <input class="txtbxEditarUsuario" id="nuevoNombreUsuario" maxlength="20" type="text" value=""/><br />			
            <label style="margin-left:30px">Nueva Contraseña</label><br />
            <input class="txtbxEditarUsuario" id="nuevoPassword" disabled="disabled" type="password" value=""/><br />
			<label style="margin-left:30px">Verifica Contraseña</label><br />
            <input class="txtbxEditarUsuario" id="validaPasswordEditar" disabled="disabled" type="password" value=""/><br />
			<input type="checkbox" onchange="habilitar()" id="cbpass" style="margin-left: 20px; margin-right: 10px"/>Desea actualizar su Contraseña?<br />
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px"/>
       </form>
    </div>
    <div id="contenidoTabla">


	<input id="agregarUsuario" type="button" value="Nuevo Usuario" style="height:36px; margin-bottom:10px; font-family: 'Marcellus', serif;"/>
		<table id="usuarios" style="width:100%;  text-align:center;">
			<thead>
                <tr>
					<th>Usuario</th>
					<th>Nombre Usuario</th>					
                </tr>			
			</thead>
		</table>

        <div id="divAltaUsuario" title="Nuevo Usuario">
        <p class="validateTips">No se permite vacio.</p>
          <form id="frmAltaUsuario" style="width:100%">  
              <label style="margin-left:20px">Usuario</label><br />
              <input class="txtbxEditar" id="username" type="text" value=""/><br />

              <label style="margin-left:20px">Nombre</label><br />
              <input class="txtbxEditar" id="nombreusuario" type="text" value=""/><br />
              
              <label style="margin-left:20px">Contraseña</label><br />
              <input class="txtbxEditar" id="password" type="password" value=""/><br />
              
              <label style="margin-left:20px">Verifica Contraseña</label><br />
              <input class="txtbxEditar" id="validaPassword" type="password" value=""/>
              
              <input type="submit" tabindex="-1" style="position:absolute; top:-1000px"/>
           </form>
        </div>
        <input id="reloadDT" type="button" style="display: none"/>
<script>

	function loadDT()
	{
		document.getElementById("reloadDT").click();
	}

	function habilitar()
	{
		if (document.getElementById("cbpass").checked)
		{
			document.getElementById('nuevoPassword').disabled = false;
			document.getElementById('validaPasswordEditar').disabled = false;
		}
		else
		{
			document.getElementById('nuevoPassword').disabled = true;
			document.getElementById('validaPasswordEditar').disabled = true;
		}
	}

	var dialog, form,
 
      usuario = $("#username"),
      nombre = $("#nombreusuario"),
      password = $("#password"),
	  validapassword = $("#validaPassword"),	  
      allFields = $( [] ).add( usuario ).add( nombre ).add( password ).add(validapassword),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Longitud de " + n + " debe ser entre " +
          min + " y " + max + " caracteres." );
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
	
	function checkPass(o, p)
	{
		if (o.val() != p.val())
		{
			p.addClass( "ui-state-error" );
		 	updateTips("No coincide el password");
			return false;
		}
		else
		{
			return true;
		}
	}
		

        function alta()
        {
            var valido = true;
			allFields.removeClass("ui-state-error");
						
			valido = valido && checkLength( usuario, "usuario", 3, 16 );
			valido = valido && checkLength( nombre, "nombre", 6, 20 );
			valido = valido && checkLength( password, "password", 5, 16 );
			
			valido = valido && checkRegexp( usuario, /^[a-z]([0-9a-z_\s])+$/i, "Usuario puede consistir de a-z, 0-9, guion bajo, espacios y debe comenzar con una letra." );
			valido = valido && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Campo password solo permite : a-z 0-9" );
			valido = valido && checkPass( password, validapassword);
			
			var user = document.getElementById("username").value;
			var nomUser = document.getElementById("nombreusuario").value;
			var pass = document.getElementById("password").value;	
			var data = {accion: "Alta", idUsuario: user, nombre: nomUser, password: pass};
			
            if (valido)
            {
                dialog.dialog( "close" );		
				$.ajax({
				url: '../functions/mttoUsuariosFunciones.php',
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
        
        dialog = $("#divAltaUsuario").dialog ({
          autoOpen : false,
          height: 400,
          width: 350,
          modal:true,
          resizable: false,
          buttons: {
                "Guardar": alta,
                "Cancelar": function() {
                  dialog.dialog( "close" );
                }
              },
              close: function() {
                form[ 0 ].reset();
                allFields.removeClass("ui-state-error");
              }
        });
        
        form = dialog.find("form").on("submit", function( event ) {
              event.preventDefault();
              alta();
            });
        
        $("#agregarUsuario").click (function (event)    // Open button Treatment
        {
            dialog.dialog("open");
        });
</script>
	</div>

<!-- end .content --></div>
<!-- InstanceEndEditable -->

<br class="clearfloat" />

<div class="footer"><?php include("../includes/admin_footer.php"); ?>
<!-- end .footer --></div>
<!-- end .container --></div>
</body>
</html>
