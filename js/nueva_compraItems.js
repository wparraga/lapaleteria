
		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/Compras/items_compraItems.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	function agregarcompra(id)
		{
			var pcompra=document.getElementById('pcompra_'+id).value;
			var cantidad=document.getElementById('cantidad_'+id).value;
			//Inicia validacion

			//Fin validacion
			$.ajax({
	        type: "POST",
	        url: "./ajax/compras/agregar_compraItems.php",
	        data: "id="+id+"&pcompra="+pcompra+"&cantidad="+cantidad,
			 beforeSend: function(objeto){
				$("#resultados").html("Mensaje: Cargando...");
			  },
	        success: function(datos){
			$("#resultados").html(datos);
			}
			});
		}
		
		
	function eliminar (id)
		{	
			$.ajax({
	        type: "GET",
	        url: "./ajax/ventaItems/agregar_ventaItems.php",
	        data: "id="+id,
			 beforeSend: function(objeto){
				$("#resultados").html("Mensaje: Cargando...");
			  },
	        success: function(datos){
			$("#resultados").html(datos);
			}
			});
		}
		
		$("#datos_facturacompra").submit(function(){
		  var id_proveedor = $("#id_proveedor").val();
		  var id_vendedor = $("#id_vendedor").val();
		  var fecha = $("#fecha").val();
		  var condiciones = $("#condiciones").val();
		  var subtotal = parseFloat($("#subtotal").val());
		  var iva = parseFloat($("#iva").val());
		  var total = parseFloat($("#total").val());
		  if (id_proveedor==""){
			  swal({
				type: "error",
				title: " Debe seleccionar un Proveedor",
				showConfirmButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Aceptar",
				closeOnConfirm: false
			  })
			  $("#nombre_proveedor").focus();
			  return false;
		  }
		  if (total==null || total==0){
		  	swal({
				type: "error",
				title: " No existen Productos asignados para Comprar",
				showConfirmButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Aceptar",
				closeOnConfirm: false
			  })
			  return false;
		  }

		  if (condiciones==1){
		  	var abono = total;
		  	var saldo=0;
		  	VentanaCentrada('./pdf/documentos/compraItems_pdf.php?id_proveedor='+id_proveedor+'&id_vendedor='+id_vendedor+'&fecha='+fecha+'&condiciones='+condiciones+'&subtotal='+subtotal+'&iva='+iva+'&total='+total+'&abono='+abono+'&saldo='+saldo,'Factura','','1024','768','true');
		  }
		  if (condiciones==2){
			  	var abono = parseFloat($("#abono").val());
			  	var saldo = total - abono;	  	
			  	if (abono>=total){
			  		swal({
			  			type: "error",
						title: " El abono no puede ser mayor o igual que el total a pagar",
						showConfirmButton: true,
						confirmButtonColor: "#d9534f",
						confirmButtonText: "Aceptar",
						closeOnConfirm: false
					})
					return false;
				}else{
					VentanaCentrada('./pdf/documentos/compraItems_pdf.php?id_cliente='+id_cliente+'&id_vendedor='+id_vendedor+'&fecha='+fecha+'&condiciones='+condiciones+'&subtotal='+subtotal+'&iva='+iva+'&total='+total+'&abono='+abono+'&saldo='+saldo,'Factura','','1024','768','true');
				}
		  }
	 	});
		
		$( "#guardar_proveedor" ).submit(function( event ) {
			$('#guardar_datos').attr("disabled", true);
			var parametros = $(this).serialize();
			$.ajax({
				type: "POST",
				url: "ajax/proveedores/nuevo_proveedor.php",
				data: parametros,
				beforeSend: function(objeto){
					$("#resultados_ajax").html("Mensaje: Cargando...");
				},
				success: function(datos){
					$("#resultados_ajax").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				}
			});
			event.preventDefault();
		})
		

		$( "#guardar_producto" ).submit(function( event ) {
			$('#guardar_datos').attr("disabled", true);
			var parametros = $(this).serialize();
			$.ajax({
				type: "POST",
				url: "ajax/items/nuevo_items.php",
				data: parametros,
				beforeSend: function(objeto){
					$("#resultados_ajax_productos").html("Mensaje: Cargando...");
				},
				success: function(datos){
					$("#resultados_ajax_productos").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				}
			});
			event.preventDefault();
		})
