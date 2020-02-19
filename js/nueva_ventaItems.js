
		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/ventaItems/items_ventaItems.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	function agregar (id)
		{
			var precio_venta=document.getElementById('precio_venta_'+id).value;
			var cantidad=document.getElementById('cantidad_'+id).value;
			var existen=document.getElementById('existen_'+id).value;
			var seguridad=document.getElementById('seguridad_'+id).value;
			var pv=parseFloat(precio_venta);
			var cant=parseFloat(cantidad);
			var exi=parseFloat(existen);
			//Inicia validacion
			if(cant>exi){
				swal({
					type: "error",
					title: " la Cantidad ingresada es mayor a las que existen.",
					showConfirmButton: true,
					confirmButtonColor: "#d9534f",
					confirmButtonText: "Aceptar",
					closeOnConfirm: false
					})
				document.getElementById('cantidad_'+id).focus();
				return false;
			}
			if(pv<seguridad){
				var str1 = "El precio no es seguro, puede vender el Items hasta en: $";
				var res = str1.concat(seguridad);
				swal({
					type: "error",
					title: res,
					showConfirmButton: true,
					confirmButtonColor: "#d9534f",
					confirmButtonText: "Aceptar",
					closeOnConfirm: false
					})
				
				document.getElementById('precio_venta_'+id).focus();
				return false;
			}
			//Fin validacion
			$.ajax({
	        type: "POST",
	        url: "./ajax/ventaItems/agregar_ventaItems.php",
	        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&existen="+existen,
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
		
		$("#datos_factura").submit(function(){
		  var id_cliente = $("#id_cliente").val();
		  var id_vendedor = $("#id_vendedor").val();
		  var fecha = $("#fecha").val();
		  var condiciones = $("#condiciones").val();
		  var subtotal = parseFloat($("#subtotal").val());
		  var iva = parseFloat($("#iva").val());
		  var total = parseFloat($("#total").val());
		  if (id_cliente==""){
			  swal({
				type: "error",
				title: " Debe seleccionar un cliente",
				showConfirmButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Aceptar",
				closeOnConfirm: false
			  })
			  $("#nombre_cliente").focus();
			  return false;
		  }
		  if (total==null || total==0){
		  	swal({
				type: "error",
				title: " No existen articulos asignados para la Venta",
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
		  	VentanaCentrada('./pdf/documentos/ventaItems_pdf.php?id_cliente='+id_cliente+'&id_vendedor='+id_vendedor+'&fecha='+fecha+'&condiciones='+condiciones+'&subtotal='+subtotal+'&iva='+iva+'&total='+total+'&abono='+abono+'&saldo='+saldo,'Factura','','1024','768','true');
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
					VentanaCentrada('./pdf/documentos/ventaItems_pdf.php?id_cliente='+id_cliente+'&id_vendedor='+id_vendedor+'&fecha='+fecha+'&condiciones='+condiciones+'&subtotal='+subtotal+'&iva='+iva+'&total='+total+'&abono='+abono+'&saldo='+saldo,'Factura','','1024','768','true');
				}
		  }
	 	});
		
		$( "#guardar_cliente" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/clientes/nuevo_cliente.php",
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
					url: "ajax/nuevo_producto.php",
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
