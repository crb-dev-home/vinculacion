$(document).ready(function(){
	var oTable = $('table').dataTable({
							"sDom": '<"top"lf>rt<"bottom"ip><"clear">',
							"scrollX": "100%",
							"scrollXInner": "110%",
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
										
										
	$('#usuarios tbody').on( 'click', 'tr', function () {
        /*if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
        	oTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }*/
		$(this).addClass('selected');
		var rowData = oTable.fnGetData(this);
		Editar(rowData);
    } );
	
	var nombreEditar = $("#nuevoNombreUsuario"),
    passwordEditar = $("#nuevoPassword"),
	validapasswordEditar = $("#validaPasswordEditar"),
	allFieldsEditar = $( [] ).add( nombreEditar ).add( passwordEditar ).add(validapasswordEditar)
	tipsEditar = $( ".validarTips" );
	
		
	$("#reloadDT").on('click',function(e)
			{
				var data = {accion: "consultar"};
				$.ajax({
					url: '../functions/mttoUsuariosFunciones.php',
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
										s[i]['idUsuario'],
										s[i]['nomUsuario']
											   ]);										
							}// End For
					},
					error: function(e)
					{
					   console.log(e.responseText);	
					}
				});				
			});
	
    dialogEditar = $("#divEditarUsuario").dialog ({
        autoOpen : false,
        height: 500,
        width: 400,
        modal:true,
        resizable: false,
        buttons: { 
        	"Eliminar": function() {
     	        eliminar();
     		},
        	"Guardar": ejecutarEditar,
            "Cancelar": function() {
    	        dialogEditar.dialog( "close" );
    		},
        },
    	close: function() {
    		formEditar[ 0 ].reset();
    		oTable.$('tr.selected').removeClass('selected');
    		allFieldsEditar.removeClass("ui-state-error"); 
            $("#nuevoPassword").prop("disabled",true);
            $("#validaPasswordEditar").prop("disabled",true);
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
			        	if(rowData[0] == "admin")
			        		{
			        			alert("No se puede eliminar este usuario");
			        		}
			        	else
			        		{
			        		if (confirm("Desea eliminar usuario?"))
			        		{
				        		var idUsuario = rowData[0];
			        			var data = {accion:"Eliminar", idUsuario:idUsuario};
				        		$.ajax({			        		
								url: '../functions/mttoUsuariosFunciones.php',
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
					}
		        	else
					{
						alert("Seleccione usuario a eliminar");		
					}		        	
        }
	
	
	function Editar(datos)
	{
		if(datos != null)
			{
				if(datos[0] == "admin")
				{
					alert("No se puede editar este usuario");
					oTable.$('tr.selected').removeClass('selected');
				}
				else
				{
					document.getElementById("idUsuario").value = datos[0];
					document.getElementById("nombreUsuarioEditar").value = datos[1];
					document.getElementById("nuevoNombreUsuario").value = datos[1];
			
					dialogEditar.dialog("open");
				}
			}
		else
			{
				alert("Seleccione usuario a editar");		
			}
	}

	function ejecutarEditar(){
		allFieldsEditar.removeClass("ui-state-error");
		var valido = true;	
		var idUsuario = document.getElementById("idUsuario").value;
		var nomUsuario = document.getElementById("nuevoNombreUsuario").value;
		var pass = document.getElementById("nuevoPassword").value;
		var passValida = document.getElementById("nuevoPassword").value;

		var data = {accion: "Editar", nombre: nomUsuario, idUsuario: idUsuario, password: pass};
		
		valido = valido && checkLengthEdit( nombreEditar, "nombre", 6, 20 );		
		
		if(document.getElementById("cbpass").checked) 
		{
			valido = valido && checkLengthEdit( passwordEditar, "password", 5, 16 );
			valido = valido && checkRegexpEdit( passwordEditar, /^([0-9a-zA-Z])+$/, "Campo password solo permite : a-z 0-9" );
			valido = valido && checkPassEdit(passwordEditar, validapasswordEditar );
		}			
		if (valido)
	    {		
			dialogEditar.dialog( "close" );
			$.ajax({
				url: '../functions/mttoUsuariosFunciones.php',
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


    function checkLengthEdit( o, n, min, max ) 
	{
	
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTipsEdit( "Longitud de " + n + " debe ser entre " +
          min + " y " + max + " caracteres." );
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexpEdit( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTipsEdit( n );
        return false;
      } else {
        return true;
      }
    }
	
	function checkPassEdit(o, p)
	{
		if (o.val() != p.val())
		{
			p.addClass( "ui-state-error" );
			updateTipsEdit("No coincide el password");
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function updateTipsEdit( t ) {
		tipsEditar
	        .text( t )
	        .addClass( "ui-state-highlight" );
	      setTimeout(function() {
	    	  tipsEditar.removeClass( "ui-state-highlight", 1500 );
	      }, 500 );
	    }
										
										
});





















