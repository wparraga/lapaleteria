		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/items/buscar_items.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}


		function eliminar_producto (id){
			var q= $("#q").val();
			swal({
				title: '¿Está seguro de eliminar el Producto?',
				text: "¡Si no lo está, puede cancelar la accíón!",
				type: 'question',
				showCancelButton: true,
				confirmButtonColor: '#d9534f',
				cancelButtonColor: '#aaaaaa',
				cancelButtonText: 'Cancelar',
				confirmButtonText: 'Si, eliminar Producto!'
			}).then(function(result){
			if (result.value) {
				$.ajax({
					type: "GET",
				    url: "./ajax/items/buscar_items.php",
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