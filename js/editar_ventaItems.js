	$(document).ready(function(){
		load(1);
		$( "#resultados" ).load( "ajax/ventaItems/editar_facturacionventaItems.php" );
	});

	function load(page){
		var q= $("#q").val();
		$("#loader").fadeIn('slow');
		$.ajax({
			url:'./ajax/ventaItems/items_editarventaItems.php?action=ajax&page='+page+'&q='+q,
			beforeSend: function(objeto){
				$('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			},
			success:function(data){
				$(".outer_div").html(data).fadeIn('slow');
				$('#loader').html('');
			}
		})
	}

	function agregarproducto(id)
		{
			var nombre_producto=document.getElementById('nombre_producto_'+id).value;
			var precio_venta=document.getElementById('precio_venta_'+id).value;
			var cantidad=document.getElementById('cantidad_'+id).value;
			var existen=document.getElementById('existen_'+id).value;
			var seguridad=document.getElementById('seguridad_'+id).value;
			var pv=parseFloat(precio_venta);
			var cant=parseFloat(cantidad);
			var exi=parseFloat(existen);
			var pvalor=precio_venta*cantidad;
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
	        url: "./ajax/ventaItems/editar_facturacionventaItems.php",
	        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&nombre_producto="+nombre_producto+"&pvalor="+pvalor,
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
			url: "./ajax/ventaItems/editar_facturacionventaItems.php",
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