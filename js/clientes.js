$(document).ready(function(){
	load(1);
});

function load(page){
	var q= $("#q").val();
	$("#loader").fadeIn('slow');
	$.ajax({
		url:'./ajax/clientes/buscar_clientes.php?action=ajax&page='+page+'&q='+q,
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
		title: '¿Está seguro de eliminar el cliente?',
		text: "¡Si no lo está, puede cancelar la accíón!",
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#d9534f',
		cancelButtonColor: '#aaaaaa',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, eliminar Cliente!'
	}).then(function(result){
	if (result.value) {
		$.ajax({
			type: "GET",
		    url: "./ajax/clientes/buscar_clientes.php",
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


$( "#editar_cliente" ).submit(function( event ) {
$('#actualizar_datos').attr("disabled", true);
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/clientes/editar_cliente.php",
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
	var cedula_cliente = $("#cedula_cliente"+id).val();
	var nombre_cliente = $("#nombre_cliente"+id).val();
	var telefono_cliente = $("#telefono_cliente"+id).val();
	var direccion_cliente = $("#direccion_cliente"+id).val();
	$("#mod_cedula").val(cedula_cliente);
	$("#mod_nombre").val(nombre_cliente);
	$("#mod_telefono").val(telefono_cliente);
	$("#mod_direccion").val(direccion_cliente);
	$("#mod_id").val(id);
}