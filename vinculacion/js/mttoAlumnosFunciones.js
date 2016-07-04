$(document).ready(function(){
	
	var oTable = $('#alumnos').dataTable({
							"sDom": '<"top"lf>rt<"bottom"ip><"clear">',
							"scrollX": "100%",
							"scrollXInner": "110%",
							"autoWidth": false,	
							"language":{
													"sProcessing":     "Procesando...",
													"sLengthMenu":     "Mostrar _MENU_ registros",
													"sZeroRecords":    "No se encontraron resultados",
													"sEmptyTable":     "Ning&uacute;n dato disponible en esta tabla",
													"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
													"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
													"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
													"sInfoPostFix":    "",
													"sSearch":         "Buscar:",
													"sUrl":            "",
													"sInfoThousands":  ",",
													"sLoadingRecords": "Cargando...",
													"oPaginate": {
														"sFirst":    "Primero",
														"sLast":     "&Uacute;ltimo",
														"sNext":     "Siguiente",
														"sPrevious": "Anterior"
																},
													"oAria": {
														"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
														"sSortDescending": ": Activar para ordenar la columna de manera descendente"
															  }
										}
										});
	
		
	oTable.fnDraw();
	
	$('#alumnos tbody').on( 'click', 'tr', function () {
		$(this).addClass('selected');
		var rowData = oTable.fnGetData(this);
		Editar(rowData);
    } );
	
		
	$("#reloadDT").on('click',function(e)
			{		
				var data = {accion: "consultar"};
				$.ajax({
					url: '../functions/mttoAlumnosFunciones.php',
					type: 'POST',
					dataType: 'json',
					data: data,
					success: function(s)
					{
						
							console.log(s);
							oTable.fnClearTable();
							for(var i = 0; i < s.length; i++) 
							{
							 oTable.fnAddData([
										s[i]['idAlumno'],
										s[i]['nomAlumno'],
										s[i]['apPaterno'],
										s[i]['apMaterno'],
										s[i]['fechaNacimiento'],
										s[i]['sexo'],
								        s[i]['nss'],
										s[i]['curp'],
										s[i]['carrera'],
										s[i]['semestre'],
										s[i]['creditos'],
										s[i]['email'],
										s[i]['telefono'],
										s[i]['domicilio'],
										s[i]['colonia'],
										s[i]['codigo'],
										s[i]['ciudad'],
										s[i]['idCarrera']										
											   ]);										
							}// End For
					},
					error: function(e)
					{
					   console.log(e.responseText);	
					}
				});				
			});
	
	form = dialog.find("form").on("submit", function( event ) {
    	event.preventDefault();
    	alta();
	});

    dialogEditar = $("#divEditarAlumno").dialog ({
        autoOpen : false,
        height: 600,
        width: 750,
        modal:true,
        resizable: false,
        buttons: {
        	"Eliminar": function() {
     	        eliminar();
     		},
        	"Guardar": function() {
     	        ejecutarEditar();
     		},
            "Cancelar": function() {
    	        dialogEditar.dialog( "close" );
    		}
        },
    	close: function() {
    		formEditar[ 0 ].reset();
    		oTable.$('tr.selected').removeClass('selected');
    		allFieldsEditar.removeClass("ui-state-error");
            }
    	});
            
        formEditar = dialogEditar.find("form").on("submit", function( event ) {
        	event.preventDefault();
        	ejecutarEditar();
    	});
        function eliminar()
        {      
        	
        			var rowData = oTable.fnGetData('tr.selected');        			
		        	dialogEditar.dialog( "close" );
		        	if(rowData != null)
					{
			        		if (confirm("Desea eliminar al Alumno?"))
			        		{
				        		var idAlumno = rowData[0];
				        		//alert(idAlumno);
			        			var data = {accion:"eliminar", idAlumno:idAlumno};
			        			$.ajax({			        		
								url: '../functions/mttoAlumnosFunciones.php',
								type: 'POST',
								dataType: 'json',
								data: data,
								success: function(s)
								{
										alert(s.mensaje);
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
		        	else
					{
						alert("Seleccione alumno a eliminar");		
					}		        	
        }
	function Editar(datos)
	{
		var i = 0;
		if(datos != null)
			{
			document.getElementById("idAlumnoEditar").value = datos[0];
			document.getElementById("nombreEditar").value = datos[1];
			document.getElementById("apPaternoEditar").value = datos[2];
			document.getElementById("apMaternoEditar").value = datos[3];
			document.getElementById("fechaNacimientoEditar").value = datos[4];
			if (datos[5] == 'M')
			{
				document.getElementById("sexoEditarM").checked = true;
			}
			else
			{
				document.getElementById("sexoEditarF").checked = true;
			}
			document.getElementById("seguroSocialEditar").value = datos[6];
			document.getElementById("curpEditar").value = datos[7];

			var registro;
			for (i = 0;i < document.getElementById("carreraEditar").options.length;i++)
			{
				registro = document.getElementById("carreraEditar").options[i];
				if (registro.value == datos[17])
						registro.selected = true;
			}
			document.getElementById("semestreEditar").value = datos[9];
			document.getElementById("creditosEditar").value = datos[10];
			document.getElementById("emailEditar").value = datos[11];
			document.getElementById("telefonoEditar").value = datos[12];
			document.getElementById("domicilioAlumnoEditar").value = datos[13];
			document.getElementById("coloniaAlumnoEditar").value = datos[14];
			document.getElementById("codigoPostalEditar").value = datos[15];
			document.getElementById("ciudadEditar").value = datos[16];
		
				dialogEditar.dialog("open");
			}
		else
			{
				alert("Seleccione Alumno a editar");		
			}
	}

	function ejecutarEditar()
	{
		allFieldsEditar.removeClass("ui-state-error");
		var valido = true;
		var idAlumnoEditar = document.getElementById("idAlumnoEditar").value;
		var nombreEditar = document.getElementById("nombreEditar").value;
		var apPaternoEditar = document.getElementById("apPaternoEditar").value;
		var apMaternoEditar = document.getElementById("apMaternoEditar").value;
		var fechaNacimientoEditar = document.getElementById("fechaNacimientoEditar").value;
		var sexoEditar = "";
		if (document.getElementById("sexoEditarM").checked == true)
		{
			sexoEditar = "M";
		}
		else
		{
			sexoEditar = "F";			
		}

		var nssEditar = document.getElementById("seguroSocialEditar").value;
		var curpEditar = document.getElementById("curpEditar").value;
		var carreraEditar = document.getElementById("carreraEditar").value;
		var semestreEditar = document.getElementById("semestreEditar").value;
		var creditosEditar = document.getElementById("creditosEditar").value;
		var emailEditar = document.getElementById("emailEditar").value;
		var telefonoEditar = document.getElementById("telefonoEditar").value;
		var domicilioAlumnoEditar = document.getElementById("domicilioAlumnoEditar").value;
		var coloniaAlumnoEditar = document.getElementById("coloniaAlumnoEditar").value;
		var codigoPostalEditar = document.getElementById("codigoPostalEditar").value;
		var ciudadEditar = document.getElementById("ciudadEditar").value;
		
		var data = {accion: "editar", idAlumno:idAlumnoEditar, nombre:nombreEditar, apPaterno:apPaternoEditar, apMaterno:apMaternoEditar, fechaNacimiento:fechaNacimientoEditar, sexo:sexoEditar,nss:nssEditar, curp:curpEditar, domicilioAlumno:domicilioAlumnoEditar, coloniaAlumno:coloniaAlumnoEditar, ciudad:ciudadEditar, codigoPostal:codigoPostalEditar, telefono:telefonoEditar, email:emailEditar, carrera:carreraEditar, semestre:semestreEditar, creditos:creditosEditar};
		
		valido = valido && verificarVacioEditar(idAlumnoEditar, nombreEditar, apPaternoEditar, apMaternoEditar, fechaNacimientoEditar, sexoEditar, nssEditar, curpEditar, carreraEditar, emailEditar, telefonoEditar, domicilioAlumnoEditar, coloniaAlumnoEditar, codigoPostalEditar, semestreEditar, creditosEditar, ciudadEditar);
		

		if (valido)
	    {
			
			dialogEditar.dialog( "close" );
			$.ajax({
				url: '../functions/mttoAlumnosFunciones.php',
				type: 'POST',
				dataType: 'json',
				data: data,
				success: function(s)
				{
						alert(s.mensaje);
						document.getElementById("reloadDT").click();
				},
				error: function(e)
				{
				   console.log(e.responseText);	
				}
			});		    	
	    	
	    }
	}
	
	function updateTipsEditar( t )
	{
		tipsEditar
		.text( t )
		.addClass( "ui-state-highlight" );
		setTimeout(function() {
			tipsEditar.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
	}

	
	function verificarVacioEditar(idAlumno, nombre, apPaterno, apMaterno, fechaNacimiento, sexo,nss, curp, carrera, email, telefono, domicilioAlumno, coloniaAlumno, codigoPostal, semestre, creditos, ciudad)
	{
					
		if (idAlumno == "")
		{
			$("#idAlumnoEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese No. de Control");
	        return false;
	    }
		if (nombre == "")
		{
			$("#nombreEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese Nombre");
	        return false;
	    }
		else if (apPaterno == "")
	    {
			$("#apPaternoEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese Apellido");
		    return false;
		}
		// else if (apMaterno == "")
        // {
		// 	("#apMaternoEditar").addClass("ui-state-error");
		// 	updateTipsEditar("Ingrese Apellido");
	     //    return false;
		// }
		else if (fechaNacimiento == "")
		{
			$("#fechaNacimientoEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese Fecha de Nacimiento");
	        return false;
		}
		else if (sexo == "")
		{
			$("#sexoEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese Sexo");
	        return false;
		}
		else if (nss == "")
		{
			$("#seguroSocialEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese NSS");
			return false;
		}

		else if (curp == "")
		{
			$("#curpEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese CURP");
	        return false;
		}
		else if (domicilioAlumno == "")
		{
			$("#domicilioAlumnoEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese Calle y Numero");
	        return false;
		}
		else if (coloniaAlumno == "")
		{
			$("#coloniaAlumnoEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese Colonia");
	        return false;
		}
		else if (ciudad == "")
		{
			$("#ciudadEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese Ciudad");
	        return false;
		}
		else if (codigoPostal == "")
		{
			$("#codigoPostalEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese Codigo Postal");
	        return false;
		}
		else if (telefono == "")
		{
			$("#telefonoEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese Telefono");
	        return false;
		}
		else if (email == "")
		{
			$("#emailEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese Email");
	        return false;
		}
		else if (carrera == "")
		{
			$("#carreraEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese Carrera");
	        return false;
		}
		
		
		else if (semestre == "")
		{
			$("#semestreEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese Semestre");
	        return false;
		}
		else if (creditos == "")
		{
			$("#creditosEditar").addClass("ui-state-error");
			updateTipsEditar("Ingrese Total de Creditos Acumulados");
	        return false;
		}	
		else
		{
	    	return true;
	    }
	}

	function soloNumeros(e){
		var key = window.Event ? e.which : e.keyCode
		return (key >= 48 && key <= 57)
	}
});	
