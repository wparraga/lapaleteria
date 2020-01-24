		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/celulares/buscar_editcelulares.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

		
		

$( "#editar_celulares" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/celulares/editar_celulares.php",
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
			var cel_codigo = $("#cel_codigo"+id).val();
			var cel_marca = $("#cel_marca"+id).val();
			var cel_modelo = $("#cel_modelo"+id).val();
			var cel_operadora = $("#cel_operadora"+id).val();
			var cel_tecnologia = $("#cel_tecnologia"+id).val();
			var aso_imesn = $("#aso_imesn"+id).val();
			var aso_iccid = $("#aso_iccid"+id).val();
			var aso_guia = $("#aso_guia"+id).val();
			var aso_numtelefono = $("#aso_numtelefono"+id).val();
			var aso_costo = $("#aso_costo"+id).val();
			var aso_costomasiva = $("#aso_costomasiva"+id).val();
			var aso_pvp = $("#aso_pvp"+id).val();
			var aso_ganancia = $("#aso_ganancia"+id).val();
			var aso_seguridad = $("#aso_seguridad"+id).val();
			var descripcion =cel_marca.concat(" ",cel_modelo," ",cel_tecnologia);

			$("#mod_idaso").val(id);	
			$("#mod_idcel").val(cel_codigo);
			$("#mod_marca").val(descripcion);
			$("#mod_imesn").val(aso_imesn);
			$("#mod_iccid").val(aso_iccid);
			$("#mod_guia").val(aso_guia);
			$("#mod_numtelefono").val(aso_numtelefono);
			$("#mod_costo").val(aso_costo);
			$("#mod_costomasiva").val(aso_costomasiva);
			$("#mod_pvp").val(aso_pvp);
			$("#mod_ganancia").val(aso_ganancia);
			$("#mod_seguridad").val(aso_seguridad);
	}
	
		
		

