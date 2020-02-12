	$(document).ready(function(){
		load(1);
		$( "#resultados" ).load( "ajax/Compras/editar_facturacioncompraItems.php" );
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
		
	$("#datos_facturaventa").submit(function(event){
		var id_cliente = $("#id_cliente").val();
		if (id_cliente==""){
			alert("Debes seleccionar un Cliente");
			$("#nombre_cliente").focus();
				 false;
		}
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "ajax/ventaItems/editar_ventaItems.php",
			data: parametros,
			beforeSend: function(objeto){
				$(".editar_venta").html("Mensaje: Cargando...");
			},
			success: function(datos){
				$(".editar_venta").html(datos);
			}
		});
		event.preventDefault();
	});

	function ver_compraItem(id_compra){
		VentanaCentrada('./pdf/documentos/ver_compraItems.php?id_compra='+id_compra,'Factura','','1024','768','true');
	}