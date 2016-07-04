$(document).ready(function(){
	
	var oTable = $('table').dataTable({
							"sDom": '<"top"l>rt<"bottom"ip><"clear">',
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
										})
										.columnFilter({
									aoColumns: [
													null,													
													{
														 type: "text"          
													},
													{
														 type: "text"          
													},
													null,
													{
														 type: "select",
														 values: ['Educativo','Publico','Privado','Social']          
													},
													{
														 type: "select",
														 values: ['Dependencia','Empresa']          
													},
													{
														 type: "select",
														 values: ['N/A','Industrial','Servicios','Otro']          
													},
													null,
													null,
													null,
													null																										                                     
												 ]
									});
		var today = new Date();	
		var fecha = today.getDate()+"-"+(today.getMonth()+1)+"-"+today.getFullYear();
		var tableTools = new $.fn.dataTable.TableTools(oTable,{
		"sSwfPath":"//cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf",		   
		   "aButtons":[
		   				{
							"sExtends":"copy",
							"sButtonText":"Copiar",
							"oSelectorOpts": { "filter": "applied"}
							
						},
						{
			   				"sExtends":"xls",
							"mColumns": [1,2,3,4,5,6,7,8,9],
							"sFileName":"Reporte Dependencias-Empresas_"+fecha+".xls",
							"oSelectorOpts": { "filter": "applied"}
						}
						]
		
		
	});
	$(tableTools.fnContainer()).insertBefore('#dependencias_wrapper');
	oTable.fnDraw();
	
	$('#dependencias tbody').on( 'click', 'tr', function () {
        /*if ( $(this).hasClass('selected') ) 
        {
            $(this).removeClass('selected');
        }
        else 
        {
        	oTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }*/
		$(this).addClass('selected');
		var rowData = oTable.fnGetData(this);
		Editar(rowData);
    } );
	
		
	$("#reloadDT").on('click',function(e)
			{
				var data = {accion: "consultar"};
				$.ajax({
					url: '../functions/dependenciasFunciones.php',
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
										s[i]['idDependencia'],
										s[i]['nomDependencia'],
										s[i]['corto'],
										s[i]['rfc'],
										s[i]['sector'],
										s[i]['tipo'],
										s[i]['giro'],
										s[i]['domicilio'],
										s[i]['colonia'],
										s[i]['ciudad'],
										s[i]['codigo']
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
        agregar();
	});

    dialogEditar = $("#divEditarDependencia").dialog ({
        autoOpen : false,
        height: 700,
        width: 350,
        modal:true,
        resizable: false,
        buttons: {
        	"Guardar": ejecutarEditar,
            "Cancelar": function() {
    	        dialogEditar.dialog( "close" );
    		}
        },
    	close: function() {
    		formEditar[ 0 ].reset();
    		oTable.$('tr.selected').removeClass('selected');
            allFields.removeClass("ui-state-error");
            }
    	});
            
        formEditar = dialogEditar.find("form").on("submit", function( event ) {
        	event.preventDefault();
        	ejecutarEditar();
    	});
	
	function Editar(datos)
	{
		if(datos != null)
			{
				document.getElementById("idDependencia").value = datos[0];
				document.getElementById("editarNombreLargo").value = datos[1];
				document.getElementById("editarNombreCorto").value = datos[2];
				document.getElementById("editarRFC").value = datos[3];
				document.getElementById("editarSector").value = datos[4];
				document.getElementById("editarTipo").value = datos[5];
				document.getElementById("editarGiro").value = datos[6];
				document.getElementById("editarDomicilio").value = datos[7];
				document.getElementById("editarColonia").value = datos[8];
				document.getElementById("editarCiudad").value = datos[9];
				document.getElementById("editarCP").value = datos[10];
		
				dialogEditar.dialog("open");
			}
		else
			{
				alert("Seleccione dependencia a editar");		
			}
	}

	function ejecutarEditar(){
		allFields.removeClass("ui-state-error");
		var valido = true;	
		var idDependencia = document.getElementById("idDependencia").value;
		var nomDependencia = document.getElementById("editarNombreLargo").value;
		var nombreCorto = document.getElementById("editarNombreCorto").value;
		var rfc = document.getElementById("editarRFC").value;
		var sector = document.getElementById("editarSector").value;
		var tipo = document.getElementById("editarTipo").value;
		var giro = document.getElementById("editarGiro").value;
		var domicilio = document.getElementById("editarDomicilio").value;
		var colonia = document.getElementById("editarColonia").value;
		var ciudad = document.getElementById("editarCiudad").value;
		var codigo = document.getElementById("editarCP").value;
		//alert(idDependencia+" "+nomDependencia+" "+tipo+" "+sector);
		var data = {accion: "editar", idDependencia: idDependencia, nomDependencia: nomDependencia,nombreCorto: nombreCorto,rfc: rfc, tipo: tipo, sector: sector,giro: giro,domicilio: domicilio,colonia: colonia,ciudad: ciudad,codigo: codigo};
		
		valido = valido && verificarVacioEditar(nomDependencia, nombreCorto);
		if (valido)
	    {		
			dialogEditar.dialog( "close" );
			$.ajax({
				url: '../functions/dependenciasFunciones.php',
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
	    	
	    	/*var url = "../functions/dependenciasFunciones.php?accion=editar&idDependencia="+idDependencia+"&nomDependencia="+nomDependencia+"&tipo="+tipo+"&sector="+sector;
			window.open(url,"_self");*/
	    }
	}
	
	function verificarVacioEditar(nombreLargo, nombreCorto){
		if (nombreLargo == "")
		{
			$("#editarNombreLargo").addClass("ui-state-error");
	        updateTips("Ingrese Nombre");
	        return false;
	    }
		else if (nombreCorto == "")
		{
			$("#editarNombreCorto").addClass("ui-state-error");
	        updateTips("Ingrese Nombre");
	        return false;
	    }
		else
		{
	    	return true;
	    }
	}
	  
});	
