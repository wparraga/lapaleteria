	$(document).ready(function(){
		load(1);
		$( "#resultados" ).load( "ajax/Compras/editar_facturacioncompraItems.php" );
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
		var nombre_producto=document.getElementById('nombre_producto_'+id).value;
		var cantidad=document.getElementById('cantidad_'+id).value;
		//Inicia validacion
		var valor=pcompra*cantidad;

		//Fin validacion
		$.ajax({
        type: "POST",
        url: "./ajax/Compras/editar_facturacioncompraItems.php",
        data: "id="+id+"&pcompra="+pcompra+"&cantidad="+cantidad+"&nombre_producto="+nombre_producto+"&valor="+valor,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
		  success: function(datos){
		  	$("#resultados").html(datos);
		  }
		});
	}
		
	function eliminardeldetalle(iddet,idpro,cant)
	{
		$.ajax({
			type: "GET",
			url: "./ajax/Compras/editar_facturacioncompraItems.php",
			data: "iddet="+iddet+"&idpro="+idpro+"&cant="+cant,
			beforeSend: function(objeto){
				$("#resultados").html("Mensaje: Cargando...");
			},
			success: function(datos){
				$("#resultados").html(datos);
			}
		});
	}
		
	$("#datos_facturacompra").submit(function(event){
		var id_proveedor = $("#id_proveedor").val();
		if (id_proveedor==""){
			alert("Debes seleccionar un Proveedor");
			$("#nombre_proveedor").focus();
				 false;
		}
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "ajax/Compras/editar_compraItems.php",
			data: parametros,
			beforeSend: function(objeto){
				$(".editar_compra").html("Mensaje: Cargando...");
			},
			success: function(datos){
				$(".editar_compra").html(datos);
			}
		});
		event.preventDefault();
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
		$('#guardar_datos_producto').attr("disabled", true);
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
				$('#guardar_datos_producto').attr("disabled", false);
				load(1);
			}
		});
		event.preventDefault();
	})

	function ver_compraItem(id_compra){
		VentanaCentrada('./pdf/documentos/ver_compraItems.php?id_compra='+id_compra,'Factura','','1024','768','true');
	}