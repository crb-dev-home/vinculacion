$(document).ready(function() {
	
	var oTable = $('#reporteador').dataTable({	
										"sDom": '<"top"l>rt<"bottom"ip><"clear">',
										"scrollX": "100%",
										"scrollXInner": "110%",
										"order": [[ 0, "desc" ]],
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
													},
													{
														 type: "text"          
													},
													{
														 type: "select",
														 values: [ 'Masculino', 'Femenino']
													},
													{
														 type: "text"												        
													},												
													{
														 type: "select",
														 values: [ 'Si', 'No']
													},
													{
														 type: "select",
														 values: ['Servicio Social','Residencia','Practicas','Beca Alumnos','Beca Egresados','Constancia','Anexo']
													},
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
											type: "select",
											values: ['Entregado','Procesado','Sin procesar']
										},

													{
														 type: "text"												        
													},								
													{
														 type: "text"												        
													},
													{
														 type: "select",
														 values: [ 'Dependencia', 'Empresa']												        
													},
													{
														 type: "select",
														 values: ['N/A', 'Industrial', 'Servicios','Otro']												        
													},
													{
														 type: "select",
														 values: [ 'Educativo', 'Publico','Privado','Social']												        
													},
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
							"sFileName":"Reporte_"+fecha+".xls",
							"oSelectorOpts": { "filter": "applied"}
						}
						]
		
		
	});
	$(tableTools.fnContainer()).insertBefore('#reporteador_wrapper');
	oTable.fnDraw();
	
	$("#buscar").on('click',function(e)
	{
			var fechaInicio = document.getElementById("fechaInicio").value;
			var fechaFinal = document.getElementById("fechaFinal").value;	
			var data = {fechaInicio: fechaInicio, fechaFinal: fechaFinal};

			e.preventDefault(); 		
			$.ajax({
				url: '../functions/consultaReporteador.php',
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
										s[i]['numRegistro'],
										s[i]['idAlumno'],
										s[i]['nomAlumno'],
										s[i]['apPaterno'],
										s[i]['apMaterno'],
										s[i]['sexo'],
										s[i]['carrera'],
										s[i]['conDiscapacidad'],
										s[i]['tipoSolicitud'],
										s[i]['fechaSolicitud'],
										s[i]['fechaImpresion'],
										s[i]['fechaEntregado'],
								        s[i]['estatus'],
										s[i]['usuario'],
										s[i]['nomDependencia'],
										s[i]['tipo'],
										s[i]['giro'],
										s[i]['sector'],
										s[i]['responsableDependencia'],
										s[i]['puestoResponsable'],
										s[i]['telDependencia'],
										s[i]['emailDependencia'],
										s[i]['programa'],
										s[i]['fechaInicio'],
										s[i]['fechaTermino']
											   ]);										
							}// End For
				},
				error: function(e)
				{
				   console.log(e.responseText);	
				}
			});
	});
			
			
			$("#buscarTodo").on('click',function(e)
					{	
							var data = {buscarTodo: "buscarTodo"};

							e.preventDefault(); 		
							$.ajax({
								url: '../functions/consultaReporteador.php',
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
														s[i]['numRegistro'],
														s[i]['idAlumno'],
														s[i]['nomAlumno'],
														s[i]['apPaterno'],
														s[i]['apMaterno'],
														s[i]['sexo'],
														s[i]['carrera'],
														s[i]['conDiscapacidad'],
														s[i]['tipoSolicitud'],
														s[i]['fechaSolicitud'],
														s[i]['fechaImpresion'],
														s[i]['fechaEntregado'],
												        s[i]['estatus'],
														s[i]['usuario'],
														s[i]['nomDependencia'],
														s[i]['tipo'],
														s[i]['giro'],
														s[i]['sector'],
														s[i]['responsableDependencia'],
														s[i]['puestoResponsable'],
														s[i]['telDependencia'],
														s[i]['emailDependencia'],
														s[i]['programa'],
														s[i]['fechaInicio'],
														s[i]['fechaTermino']
														
															   ]);										
											}// End For
								},
								error: function(e)
								{
								   console.log(e.responseText);	
								}
							});
					});

	
	
	
	
	
} );