		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/ventaItems/buscar_ventaItems.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					
				}
			})
		}


		function procesoVerDetalleventa(vi_codigo,numero,fecha,cliente){
			var resultado=""; 
	        var parametros = {
		            "vi_codigo" : vi_codigo,
		            "numero" : numero,
		            "fecha" : fecha,
		            "cliente" : cliente,
		    };
		    request = $.ajax({
		        data:  parametros,
		        url:   'ajax/ventaItems/detalle_ventas.php',
		        type:  'post',
		        success: function (response) {
		                $("#resultado").html(response);
		        }
		    });
		}

		function eliminarventaitems (id){
			var q= $("#q").val();
			swal({
				title: '¿Está seguro de eliminar la venta?, SI HACE CLIC EN ACEPTAR YA NO SE PODRÁ RECUPERAR LA INFORMACIÓN!!',
				text: "¡Si no lo está, puede cancelar la accíón!",
				type: 'question',
				showCancelButton: true,
				confirmButtonColor: '#d9534f',
				cancelButtonColor: '#aaaaaa',
				cancelButtonText: 'Cancelar',
				confirmButtonText: 'ACEPTAR.'
			}).then(function(result){
			if (result.value) {
				$.ajax({
					type: "GET",
				    url: "./ajax/ventaItems/buscar_ventaItems.php",
				    data: "id="+id,"q":q,
					beforeSend: function(objeto){
						$("#resultados").html("Mensaje: Cargando...");
					},
					success: function(datos){
						$("#resultados").html(datos);
						load(1);
					}
				});
			}
		})
		}


		
		function imprimir_ventaItem(id_venta){
			VentanaCentrada('./pdf/documentos/ver_ventaItems.php?id_venta='+id_venta,'Factura','','1024','768','true');
		}
