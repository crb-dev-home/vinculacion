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
    <link href="../css/jquery-ui.css" type="text/css" rel="stylesheet"/>
    <link href="../css/theme.css" type="text/css" rel="stylesheet"/>  
    <link href="../css/admin_main.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/menu.css" type="text/css" />
	<link href='https://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css'/>  
	
	<script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/mttoAlumnosFunciones.js"></script>       

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
	<h2 class="featured-title2">Alumnos</h2>
	<div id="content" class="content bg1">
	<div class="formSection2" id="divAltaAlumno" title="Alta Alumno">	
	<p class="validateTips"></p>	
		<form style="width:100%">
	       
	    <table style="margin-left: 20px;margin-right: 20px;" cellspacing="10">
	    	<tr>
	    		<td colspan="3">
	    			<label class="formLabel2" for="idAlumno">Numero de Control:</label>
	   	 			<input class="textbox2" name="idAlumno" required title="8 digitos" type="text" style="text-align:left;margin-left: 0;" pattern="[0-9]{8,}" maxlength="8"  id="idAlumno" value=""/>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			<label class="formLabel2" for="nombre">Nombre:</label>
	   	 			<input class="textbox2" name="nombre" id="nombre" required type="text" style="text-align:left" maxlength="30" value=""/></td>
	    		<td>
	    			<label class="formLabel2" for="apPaterno">Apellido Paterno:</label>
	   	 			<input class="textbox2" name="apPaterno" required type="text" style="text-align:left" id="apPaterno" maxlength="30" value=""/>		
	    		</td>
	    		<td>
	    			<label class="formLabel2" for="apMaterno">Apellido Materno:</label>
	   	 			<input class="textbox2" name="apMaterno" required type="text" style="text-align:left" id="apMaterno"  maxlength="30" value=""/>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
		    		<label class="formLabel2" for="fechaNacimiento">Fecha de Nacimiento:</label>
		        	<input required="required" class="textbox2" type="text" id="fechaNacimiento" name="fechaNacimiento"  value=""/><br/>
		    	</td>
	    		<td>
	    			<label class="formLabel2" for="sexo"/>Sexo:</label>
					<input type="radio" name="sexo" id="sexo" value="F" checked="checked"/>Femenino
		        	<input type="radio" name="sexo" id="sexo" value="M" />Masculino
	    		</td>	    		
<!--	    		<td>-->
<!--	    			<label class="formLabel2" for="curp">CURP:</label>-->
<!--   	 				<input required title="Debe ser de 18 caracteres" pattern=".{18,}" maxlength="18" class="textbox2" value="" name="curp" type="text" style="text-align:left; text-transform:uppercase" id="curp" /><span><a href="javascript:consultarCURP()"><img height="35px" width="35px" style="margin-left:5px" src="../images/curp.png" title="Consulta Curp"/></a></span>-->
<!--	    		</td>-->
	    	</tr>
			<tr>
				<td colspan="3">
					<table width="100%">
						<tr>
							<td colspan="2" width="50%">
								<label class="formLabel2" for="seguroSocial">Numero de Seguro Social (NSS):</label>
								<input required class="textbox2" style="text-align:left" name="seguroSocial" type="text" maxlength="11"  pattern=".{11,}"  id="seguroSocial" onkeypress="return soloNumeros(event)" value=""/><span><a href="javascript:consultarIMSS()"><img height="35px" width="35px" style="margin-left:5px" src="../images/imss.png" title="Consulta Curp"/></a></span>
							</td>

							<td  colspan="2" width="50%">
								<label class="formLabel2" for="curp">CURP:</label>
								<input required title="Debe ser de 18 caracteres" pattern=".{18,}" maxlength="18" class="textbox2" name="curp" type="text" style="text-align:left;text-transform: uppercase" onkeyup="this.value = this.value.toUpperCase();" id="curp" /><span><a href="javascript:consultarCURP()"><img height="35px" width="35px" style="margin-left:5px" src="../images/curp.png" title="Consulta Curp"/></a></span>
							</td>
						</tr>
					</table>
				</td>

			</tr>
	    	<tr>	
	    		<td>
	    			<label class="formLabel2" for="domicilioAlumno">Calle y Numero:</label>
	   	 			<input required class="textbox2" name="domicilioAlumno" type="text" style="text-align:left" id="domicilioAlumno" maxlength="50" value=""/>
	    		</td>
	    		<td>
	    			 <label class="formLabel2" for="coloniaAlumno">Colonia:</label>
	   	 			<input required class="textbox2" name="coloniaAlumno" type="text" style="text-align:left" id="coloniaAlumno" maxlength="50" value=""/>
	    		</td>
	    		<td>
					<label class="formLabel2" for="ciudad">Ciudad:</label>
					<input required class="textbox2" name="ciudad" type="text" style="text-align:left" id="ciudad" maxlength="20" value=""/>
				</td>
			</tr>
			<tr>
				<td>
					<label class="formLabel2" for="codigoPostal">Código Postal:</label>
					<input required class="textbox2" name="codigoPostal" type="text" style="text-align:left" id="codigoPostal" maxlength="20" value=""/>
				</td>   		
	    		<td>
	    			<label class="formLabel2" for="telefono">Teléfono (10 digitos):</label>
	   	 			<input class="textbox2" required title="Ej. 6641234578" pattern="[0-9]{10,}" name="telefono" type="text" style="text-align:left;width: 200px;margin-left: 0;" id="telefono" value=""/>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td colspan="3">
	    			<label class="formLabel2" for="email">Email:</label>
	   	 			<input required title="Ej. tuemail@mail.com" pattern="[A-Za-z0-9._%+-]{3,}@[a-zA-Z]{3,}([.]{1}[a-zA-Z]{2,}|[.]{1}[a-zA-Z]{2,}[.]{1}[a-zA-Z]{2,})" class="textbox2" name="email" type="text" style="text-align:left" id="email" value=""/>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			<label class="formLabel2" for="carrera">Carrera:</label>
	    			<select required class="textbox2" name="carrera" style="text-align:left" id="carrera">
		    			<option value="1">Arquitectura</option>
		                <option value="2">Contador Público</option>
		                <option value="3">Ing. Ambiental</option>                
		                <option value="4">Ing. Biomèdica</option>
		                <option value="5">Ing. Bioquìmica</option>
		                <option value="6">Ing. Civil</option>
		                <option value="7">Ing. Electromecànica</option>
		                <option value="8">Ing. Electrònica</option>
		                <option value="9">Ing. en Aeronàutica</option>
		                <option value="10">Ing. en Diseño Industrial</option>
		                <option value="11">Ing. en Gestiòn Empresarial</option>
		                <option value="12">Ing. en Informàtica</option>
		                <option value="13">Ing. en Logìstica</option>
		                <option value="14">Ing. en Nanotecnologìa</option>
		                <option value="15">Ing. en Sistemas Computacionales</option>
		                <option value="16">Ing. en Tecnologìas de la Informaciòn y Comunicaciones</option>
		                <option value="17">Ing. Industrial</option>
		                <option value="18">Ing. Quìmica</option>
		                <option value="19">Ing. Mecánica</option>
		                <option value="20">Ing. en Administraciòn</option>	    			
	    			</select>
	    		</td>
	    		<td>
	    			<label class="formLabel2" for="semestre">Semestre:</label>
	   	 			<input required class="textbox2" name="semestre" type="text" style="text-align:left" id="semestre" onkeypress="return soloNumeros(event)" maxlength="2" value=""/>
	    		</td>
	    		<td>
	    			<label class="formLabel2" for="creditos">Creditos:</label>
	   	 			<input required class="textbox2" name="creditos" type="text" style="text-align:left" id="creditos" onkeypress="return soloNumeros(event)" maxlength="3" value=""/>
	    		</td>
	    		
	    	</tr>
	    	
	    </table>
	    <input type="submit" id="submitAlta" tabindex="-1" style="position:absolute; top:-1000px"/>
		</form>   
	</div>
	
	
	<div class="formSection2" id="divEditarAlumno" title="Editar Alumno">	
		<p class="validateTipsEditar"></p>
		<form style="width:100%">
	       
	    <table style="margin-left: 20px;margin-right: 20px;" cellspacing="10">
	    	<tr>
	    		<td colspan="3">
	    			<label class="formLabel2" for="idAlumnoEditar">Numero de Control:</label>
	   	 			<input class="textbox2" name="idAlumnoEditar" required readonly type="text" style="text-align:left;margin-left: 0;" maxlength="8"  id="idAlumnoEditar"/>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			<label class="formLabel2" for="nombreEditar">Nombre:</label>
	   	 			<input class="textbox2" name="nombreEditar" id="nombreEditar" required type="text" style="text-align:left" maxlength="30"/>
	    		</td>
	    		<td>
	    			<label class="formLabel2" for="apPaternoEditar">Apellido Paterno:</label>
	   	 			<input class="textbox2" name="apPaternoEditar" required type="text" style="text-align:left" id="apPaternoEditar" maxlength="30"/>		
	    		</td>
	    		<td>
	    			<label class="formLabel2" for="apMaternoEditar">Apellido Materno:</label>
	   	 			<input class="textbox2" name="apMaternoEditar" required type="text" style="text-align:left" id="apMaternoEditar"  maxlength="30"/>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
		    		<label class="formLabel2" for="fechaNacimientoEditar">Fecha de Nacimiento:</label>
		        	<input required="required" class="textbox2" type="text" id="fechaNacimientoEditar" name="fechaNacimientoEditar"  value=""/><br/>
		    	</td>
	    		<td>
	    			<label class="formLabel2" for="sexoEditar"/>Sexo:</label>
					<input type="radio" name="sexoEditar" id="sexoEditarF" value="F" />Femenino
		        	<input type="radio" name="sexoEditar" id="sexoEditarM" value="M" />Masculino
	    		</td>	    		
<!--	    		<td>-->
<!--	    			<label class="formLabel2" for="curpEditar">CURP:</label>-->
<!--   	 				<input required title="Debe ser de 18 caracteres" pattern=".{18,}" maxlength="18" class="textbox2" name="curpEditar" type="text" style="text-align:left; text-transform:uppercase" id="curpEditar" /><span><a href="javascript:consultarCURP()"><img height="35px" width="35px" style="margin-left:5px" src="../images/curp.png" title="Consulta Curp"/></a></span>-->
<!--	    		</td>-->
	    	</tr>
			<tr>
				<td colspan="3">
					<table width="100%">
						<tr>
							<td colspan="2" width="50%">
								<label class="formLabel2" for="seguroSocialEditar">Numero de Seguro Social (NSS):</label>
								<input required class="textbox2" style="text-align:left" name="seguroSocialEditar" type="text" maxlength="11"  pattern=".{11,}"  id="seguroSocialEditar" onkeypress="return soloNumeros(event)" value=""/><span><a href="javascript:consultarIMSS()"><img height="35px" width="35px" style="margin-left:5px" src="../images/imss.png" title="Consulta Curp"/></a></span>
							</td>

							<td  colspan="2" width="50%">
								<label class="formLabel2" for="curpEditar">CURP:</label>
								<input required title="Debe ser de 18 caracteres" pattern=".{18,}" maxlength="18" class="textbox2" name="curpEditar" id="curpEditar" type="text" style="text-align:left;text-transform: uppercase" onkeyup="this.value = this.value.toUpperCase();" /><span><a href="javascript:consultarCURP()"><img height="35px" width="35px" style="margin-left:5px" src="../images/curp.png" title="Consulta Curp"/></a></span>
							</td>
						</tr>
					</table>
				</td>

			</tr>
	    	<tr>	
	    		<td>
	    			<label class="formLabel2" for="domicilioAlumnoEditar">Calle y Numero:</label>
	   	 			<input required class="textbox2" name="domicilioAlumnoEditar" type="text" style="text-align:left" id="domicilioAlumnoEditar" maxlength="50"/>
	    		</td>
	    		<td>
	    			 <label class="formLabel2" for="coloniaAlumnoEditar">Colonia:</label>
	   	 			<input required class="textbox2" name="coloniaAlumnoEditar" type="text" style="text-align:left" id="coloniaAlumnoEditar" maxlength="50" />
	    		</td>
	    		<td>
					<label class="formLabel2" for="ciudadEditar">Ciudad:</label>
					<input required class="textbox2" name="ciudadEditar" type="text" style="text-align:left" id="ciudadEditar" maxlength="20"/>
				</td>
			</tr>
			<tr>
				<td>
					<label class="formLabel2" for="codigoPostalEditar">Código Postal:</label>
					<input required class="textbox2" name="codigoPostalEditar" type="text" style="text-align:left" id="codigoPostalEditar" maxlength="20"/>
				</td>   		
	    		<td>
	    			<label class="formLabel2" for="telefonoEditar">Teléfono (10 digitos):</label>
	   	 			<input class="textbox2" required title="Ej. 6641234578" pattern="[0-9]{10,}" name="telefonoEditar" type="text" style="text-align:left;width: 200px;margin-left: 0;" id="telefonoEditar"/>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td colspan="3">
	    			<label class="formLabel2" for="emailEditar">Email:</label>
	   	 			<input required title="Ej. tuemail@mail.com" pattern="[A-Za-z0-9._%+-]{3,}@[a-zA-Z]{3,}([.]{1}[a-zA-Z]{2,}|[.]{1}[a-zA-Z]{2,}[.]{1}[a-zA-Z]{2,})" class="textbox2" name="emailEditar" type="text" style="text-align:left" id="emailEditar"/>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			<label class="formLabel2" for="carreraEditar">Carrera:</label>
	    			<select class="textbox2" name="carreraEditar" style="text-align:left" id="carreraEditar">
	    				<option value="1">Arquitectura</option>
		                <option value="2">Contador Público</option>
		                <option value="3">Ing. Ambiental</option>                
		                <option value="4">Ing. Biomèdica</option>
		                <option value="5">Ing. Bioquìmica</option>
		                <option value="6">Ing. Civil</option>
		                <option value="7">Ing. Electromecànica</option>
		                <option value="8">Ing. Electrònica</option>
		                <option value="9">Ing. en Aeronàutica</option>
		                <option value="10">Ing. en Diseño Industrial</option>
		                <option value="11">Ing. en Gestiòn Empresarial</option>
		                <option value="12">Ing. en Informàtica</option>
		                <option value="13">Ing. en Logìstica</option>
		                <option value="14">Ing. en Nanotecnologìa</option>
		                <option value="15">Ing. en Sistemas Computacionales</option>
		                <option value="16">Ing. en Tecnologìas de la Informaciòn y Comunicaciones</option>
		                <option value="17">Ing. Industrial</option>
		                <option value="18">Ing. Quìmica</option>
		                <option value="19">Ing. Mecánica</option>
		                <option value="20">Ing. en Administraciòn</option>
	    			</select>
	    		</td>
	    		<td>
	    			<label class="formLabel2" for="semestreEditar">Semestre:</label>
	   	 			<input required class="textbox2" name="semestreEditar" type="text" style="text-align:left" id="semestreEditar" onkeypress="return soloNumeros(event)" maxlength="2"/>
	    		</td>
	    		<td>
	    			<label class="formLabel2" for="creditosEditar">Creditos:</label>
	   	 			<input required class="textbox2" name="creditosEditar" type="text" style="text-align:left" id="creditosEditar" onkeypress="return soloNumeros(event)" maxlength="3"/>
	    		</td>
	    		
	    	</tr>
	    	
	    </table>
	    <input type="submit" id="submitEditar" tabindex="-1" style="position:absolute; top:-1000px"/>
		</form>   
	</div>
	
	<div id="contenidoTabla">
		<input id="nuevoAlumno" type="button" value="Alta Alumno" style="height:36px; margin-bottom:5px;font-family: 'Marcellus', serif"/><!-- <input id="editarDep" type="button" value="Editar Dependencia" style="height:36px; margin-left:30px; margin-bottom:5px; font-family: 'Marcellus', serif"/> -->
	        <table id="alumnos" style="text-align:center">
		        <thead>
		        	    <tr>
		            	<th>No. Control</th>
		                <th>Nombre</th>
		                <th>Ap. Paterno</th>
		                <th>Ap. Materno</th>
		                <th>Fecha Nacimiento</th> 
		                <th>Sexo</th>
						<th>NSS</th>
		                <th>CURP</th>
		                <th>Carrera</th>
		                <th>Semestre</th>
		                <th>Creditos</th>
		                <th>Email</th>
		                <th>Telefono</th>
		                <th>Domicilio</th>
		                <th>Colonia</th>
		                <th>Codigo Postal</th>
		                <th>Ciudad</th>		                
					</tr>                                          
				</thead>                     
	        </table>	
	</div>
	<input id="reloadDT" type="button" style="display: none" />
<script> 

var dialog, form, dialogEditar, formEditar,
numControl = $("#idAlumno"),
nombreAlumno = $("#nombre"),
apellidoPaterno = $("#apPaterno"),
apellidoMaterno = $("#apMaterno"),
fNac = $("#fechaNacimiento"),
sexoAlumno = $("#sexo"),
curpAlumno = $("#curp"),
nssAlumno = $("#seguroSocial"),
domicilio = $("#domicilioAlumno"),
colonia = $("#coloniaAlumno"),
codigo = $("#codigoPostal"),
ciudadAlumno = $("#ciudad"),
telefonoAlumno = $("#telefono"),
emailAlumno = $("#email"),
carreraAlumno = $("#carrera"),
semestreAlumno = $("#semestre"),
creditosAlumno = $("#creditos"),
allFields = $([]).add(numControl).add(nombreAlumno).add(apellidoPaterno).add(apellidoMaterno).add(fNac).add(sexoAlumno).add(nssAlumno).add(curpAlumno).add(domicilio).add(colonia).add(codigo).add(ciudadAlumno).add(telefonoAlumno).add(emailAlumno).add(carreraAlumno).add(semestreAlumno).add(creditosAlumno),
allFieldsEditar = $([]).add($("#idAlumnoEditar")).add($("#nombreEditar")).add($("#apPaternoEditar")).add($("#apMaternoEditar")).add($("#fechaNacimientoEditar")).add($("#sexoEditar")).add($("#seguroSocialEditar")).add($("#curpEditar")).add($("#domicilioAlumnoEditar")).add($("#coloniaAlumnoEditar")).add($("#codigoPostalEditar")).add($("#ciudadEditar")).add($("#telefonoEditar")).add($("#emailEditar")).add($("#carreraEditar")).add($("#semestreEditar")).add($("#creditosEditar")),
tips = $( ".validateTips" ),
tipsEditar = $( ".validateTipsEditar" );

function loadDT()
{
	document.getElementById("reloadDT").click();
}

function consultarCURP()
{
	var url = "https://consultas.curp.gob.mx/CurpSP/";
	window.open(url);
}

function updateTips( t )
{
	tips
	.text( t )
	.addClass( "ui-state-highlight" );
	setTimeout(function() {
		tips.removeClass( "ui-state-highlight", 1500 );
	}, 500 );
}


function soloNumeros(e){
	var key = window.Event ? e.which : e.keyCode
	return (key >= 48 && key <= 57)
}

function verificarVacio(idAlumno, nombre, apPaterno, apMaterno, fechaNacimiento, sexo, nss, curp, carrera, email, telefono, domicilioAlumno, coloniaAlumno, codigoPostal, semestre, creditos, ciudad)
{
		
	if (idAlumno == "")
	{
		numControl.addClass("ui-state-error");
        updateTips("Ingrese No. de Control");
        return false;
    }
	if (nombre == "")
	{
		nombreAlumno.addClass("ui-state-error");
        updateTips("Ingrese Nombre");
        return false;
    }
	else if (apPaterno == "")
    {
		apellidoPaterno.addClass("ui-state-error");
	    updateTips("Ingrese Apellido");
	    return false;
	}
//	else if (apMaterno == "")
//    {
//		apellidoMaterno.addClass("ui-state-error");
//        updateTips("Ingrese Apellido");
//        return false;
//	}
	else if (fechaNacimiento == "")
	{
		fNac.addClass("ui-state-error");
        updateTips("Ingrese Fecha de Nacimiento");
        return false;
	}
	else if (sexo == "")
	{
		sexoAlumno.addClass("ui-state-error");
        updateTips("Ingrese Sexo");
        return false;
	}
	else if (nss == "")
	{
		nssAlumno.addClass("ui-state-error");
		updateTips("Ingrese NSS");
		return false;
	}
	else if (curp == "")
	{
		curpAlumno.addClass("ui-state-error");
        updateTips("Ingrese CURP");
        return false;
	}
	else if (domicilioAlumno == "")
	{
		domicilio.addClass("ui-state-error");
        updateTips("Ingrese Calle y Numero");
        return false;
	}
	else if (coloniaAlumno == "")
	{
		colonia.addClass("ui-state-error");
        updateTips("Ingrese Colonia");
        return false;
	}
	else if (ciudad == "")
	{
		ciudadAlumno.addClass("ui-state-error");
        updateTips("Ingrese Ciudad");
        return false;
	}
	else if (codigoPostal == "")
	{
		codigo.addClass("ui-state-error");
        updateTips("Ingrese Codigo Postal");
        return false;
	}
	else if (telefono == "")
	{
		telefonoAlumno.addClass("ui-state-error");
        updateTips("Ingrese Telefono");
        return false;
	}
	else if (email == "")
	{
		emailAlumno.addClass("ui-state-error");
        updateTips("Ingrese Email");
        return false;
	}
	else if (carrera == "")
	{
		carreraAlumno.addClass("ui-state-error");
        updateTips("Ingrese Carrera");
        return false;
	}
	
	
	else if (semestre == "")
	{
		semestreAlumno.addClass("ui-state-error");
        updateTips("Ingrese Semestre");
        return false;
	}
	else if (creditos == "")
	{
		creditosAlumno.addClass("ui-state-error");
        updateTips("Ingrese Total de Creditos Acumulados");
        return false;
	}	
	else
	{
    	return true;
    }
}
	
function alta()
{
	allFields.removeClass("ui-state-error");
	var valido = true;
	var idAlumno = document.getElementById("idAlumno").value;
	var nombre = document.getElementById("nombre").value;
	var apPaterno = document.getElementById("apPaterno").value;
	var apMaterno = document.getElementById("apMaterno").value;
	var fechaNacimiento = document.getElementById("fechaNacimiento").value;
	var sexo = document.getElementById("sexo").value;
	var nss = document.getElementById("seguroSocial").value;
	var curp = document.getElementById("curp").value;
	var carrera = document.getElementById("carrera").value;
	var semestre = document.getElementById("semestre").value;
	var creditos = document.getElementById("creditos").value;
	var email = document.getElementById("email").value;
	var telefono = document.getElementById("telefono").value;
	var domicilioAlumno = document.getElementById("domicilioAlumno").value;
	var coloniaAlumno = document.getElementById("coloniaAlumno").value;
	var codigoPostal = document.getElementById("codigoPostal").value;
	var ciudad = document.getElementById("ciudad").value;
	
	var data = {accion: "agregar", idAlumno:idAlumno, nombre:nombre, apPaterno:apPaterno, apMaterno:apMaterno, fechaNacimiento:fechaNacimiento, sexo:sexo, curp:curp, domicilioAlumno:domicilioAlumno, coloniaAlumno:coloniaAlumno, ciudad:ciudad, codigoPostal:codigoPostal, telefono:telefono, email:email, carrera:carrera, semestre:semestre, creditos:creditos};
	
	valido = valido && verificarVacio(idAlumno, nombre, apPaterno, apMaterno, fechaNacimiento, sexo, nss, curp, carrera, email, telefono, domicilioAlumno, coloniaAlumno, codigoPostal, semestre, creditos, ciudad);


    if (valido)
    {
    	dialog.dialog( "close" );
    	$.ajax({
			url: '../functions/mttoAlumnosFunciones.php',
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
			   alert(e.responseText);
			}
		});	
	}
}
      
    dialog = $("#divAltaAlumno").dialog ({
    autoOpen : false,
    height: 600,
    width: 750,
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
        
           
    $("#nuevoAlumno").click (function (event)    // Open button Treatment
    {
    	dialog.dialog("open");
   	});

    $( "#fechaNacimiento" ).datepicker({
		defaultDate: "+1w",
		dateFormat:"yy-mm-dd",
      	changeMonth: true,//this option for allowing user to select month
      	changeYear: true, //this option for allowing user to select from year range
      	yearRange: "-80:+0",
		onClose: function( selectedDate ) 
		{
			$( "#fechaNacimiento" ).datepicker( "option", "minDate", selectedDate );
		}
    });
</script>
</div>

<br class="clearfloat" />

<div class="footer"><?php include("../includes/admin_footer.php"); ?>
</div>
</div>
</body>
</html>
