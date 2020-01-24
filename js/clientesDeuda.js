$(document).ready(function(){
	load(1);
});

function load(page){
	var q= $("#q").val();
	$("#loader").fadeIn('slow');
	$.ajax({
		url:'./ajax/clientes/clientes_deuda.php?action=ajax&page='+page+'&q='+q,
		beforeSend: function(objeto){
			$('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
		},
		success:function(data){
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');
		}
	})
}

$( "#abonar_pagar" ).submit(function( event ) {
$('#guardar_datos').attr("disabled", true);
 var parametros = $(this).serialize();
	 $.ajax({
	 	type: "POST",
		url: "ajax/clientes/abonar_pagar.php",
		data: parametros,
		beforeSend: function(objeto){
			$("#resultados_ajax_abonarpagar").html("Mensaje: Cargando...");
		},
		success: function(datos){
			$("#resultados_ajax_abonarpagar").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		}
	});
  event.preventDefault();
})

function obtener_datos(id){
	var cedula_cliente = $("#cedula_cliente"+id).val();
	var nombre_cliente = $("#nombre_cliente"+id).val();
	var saldo_cliente = $("#saldo_cliente"+id).val();
	$("#cedula").val(cedula_cliente);
	$("#nombre").val(nombre_cliente);
	$("#saldo_actual").val(saldo_cliente);
	$("#id").val(id);
}

function procesoVerDeudores(tabla){
	var resultado=""; 
    var parametros = {
    	"tabla" : tabla
    };
    request = $.ajax({
    	data:  parametros,
        url:   'ajax/clientes/deudas_cliente.php',
        type:  'post',
        success: function (response) {
        	$("#resultado").html(response);
        }
    });
}

function procesoVerarticulosdadosacredito(id_cliente){
	var resultadocreditos=""; 
    var parametros = {
    	"id_cliente" : id_cliente
    };
    request = $.ajax({
    	data:  parametros,
        url:   'ajax/clientes/clientes_credito.php',
        type:  'post',
        success: function (response) {
        	$("#resultadocreditos").html(response);
        }
    });
}

function procesoVerAbonos(id_cliente){
	var resultadoabonos=""; 
    var parametros = {
    	"id_cliente" : id_cliente
    };
    request = $.ajax({
    	data:  parametros,
        url:   'ajax/clientes/clientes_abonos.php',
        type:  'post',
        success: function (response) {
        	$("#resultadoabonos").html(response);
        }
    });
}

function procesoVerabonostotales(id_cliente,nom_cliente){
	var resultadoabonostotales=""; 
    var parametros = {
    	"id_cliente" : id_cliente,
        "nom_cliente" : nom_cliente
    };
    request = $.ajax({
    	data:  parametros,
        url:   'ajax/clientes/abonos_cliente.php',
        type:  'post',
        success: function (response) {
        	$("#resultadoabonostotales").html(response);
        }
    });
}