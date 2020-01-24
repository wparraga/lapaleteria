		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/proveedores/buscar_proveedores.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}


		function eliminar (id){
			var q= $("#q").val();
			swal({
				title: '¿Está seguro de eliminar el Proveedor?',
				text: "¡Si no lo está, puede cancelar la accíón!",
				type: 'question',
		        showCancelButton: true,
		        confirmButtonColor: '#d9534f',
		        cancelButtonColor: '#aaaaaa',
		        cancelButtonText: 'Cancelar',
		        confirmButtonText: 'Si, borrar Proveedor!'
		        }).then(function(result) {
		        if (result.value) {
			        $.ajax({
		        	type: "GET",
		        	url: "./ajax/proveedores/buscar_proveedores.php",
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

$( "#editar_proveedor" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/proveedores/editar_proveedor.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	function obtener_datos(id){
			var nombre_proveedor = $("#nombre_proveedor"+id).val();
			var direccion_proveedor = $("#direccion_proveedor"+id).val();
			var celular_proveedor = $("#celular_proveedor"+id).val();
			var convencional_proveedor = $("#convencional_proveedor"+id).val();
			var correo_proveedor = $("#correo_proveedor"+id).val();
			var ruc_proveedor = $("#ruc_proveedor"+id).val();
	
			$("#mod_nombres").val(nombre_proveedor);
			$("#mod_direccion").val(direccion_proveedor);
			$("#mod_celular").val(celular_proveedor);
			$("#mod_convencional").val(convencional_proveedor);
			$("#mod_correo").val(correo_proveedor);
			$("#mod_ruc").val(ruc_proveedor);
			$("#mod_id").val(id);
		
		}
	
		
		

