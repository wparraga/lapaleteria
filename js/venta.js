		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/ventaItems/buscar_venta.php?action=ajax&page='+page+'&q='+q,
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

		function procesoVerDetalleventa(vi_codigo,numero,fecha,cliente,total){
			var resultado=""; 
	        var parametros = {
		            "vi_codigo" : vi_codigo,
		            "numero" : numero,
		            "fecha" : fecha,
		            "cliente" : cliente,
		            "total" : total,
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


		
		function imprimir_ventaItem(id_venta){
			VentanaCentrada('./pdf/documentos/ver_ventaItems.php?id_venta='+id_venta,'Factura','','1024','768','true');
		}
