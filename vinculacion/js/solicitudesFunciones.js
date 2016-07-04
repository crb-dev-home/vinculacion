$(document).ready(function(){
	var table = $('table').dataTable({
							"sDom": '<"top"lf>rt<"bottom"ip><"clear">',
							"scrollX": "100%",
							"scrollXInner": "110%",
							"autoWidth": false,
							"order": [[ 1, "desc" ]],
							"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {

																	if ( aData[4] != "0000-00-00" && aData[10] != "Sin procesar" )
																	{
																		$('td', nRow).css('background-color', '#C6EFCE');
																	}},	
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
	/*.columnFilter({
					
					aoColumns: [
                                    null,
									{
                                         type: "text"          
                                    },								
									{
                                         type: "select",
                                         values: [ 'Residencia', 'Servicio Social']
                                    },
                                    null,
									null,
									null,
									{
                                         type: "text"          
                                    },
									{
                                         type: "text"          
                                    },
									{
                                         type: "text"          
                                    },
									{
                                         type: "text"          
                                    }                                     
                                 ]
				});*/
	table.fnDraw();
});


function procesar(numRegistro)
{
	if (confirm("Desea generar la carta?"))
	{
		var url = "../functions/solicitudesFunciones.php?accion=procesar&numSolicitud="+numRegistro;
		window.open(url,"_self");
		document.getSelection()
	}
}

function entregar(numRegistro,fechaImpresion)
{
	if (fechaImpresion != "0000-00-00")
	{
		if (confirm("Desea marcar como entregado?"))
		{
			var url = "../functions/solicitudesFunciones.php?accion=entregar&numSolicitud="+numRegistro;
			window.open(url,"_self");
		}
	}
	else
	{
		alert("No se ha generado la carta");
	}
}

function eliminar(numRegistro)
{
	if (confirm("Desea eliminar solicitud?"))
	{
		var url = "../functions/solicitudesFunciones.php?accion=eliminar&numSolicitud="+numRegistro;
		window.open(url,"_self");
	}
		
}

function editar(numRegistro)
{
	var url = "editarSolicitud.php?numSolicitud="+numRegistro;
	window.open(url,"_self");
}

function solicitudMasiva(){

	if (confirm("Desea generar todas las cartas actualmente abiertas?"))
	{
		var url = '../functions/formatosMasivos.php';
		window.open(url);
	}

}