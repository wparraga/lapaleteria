		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q1= $("#q1").val();
			var q2= $("#q2").val();
			var t1= $("#q1").val();
			var t2= $("#q2").val();

			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/ventas/resumen_ventas.php?action=ajax&page='+page+'&q1='+q1+'&q2='+q2+'&t1='+t1+'&t2='+t2,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}
