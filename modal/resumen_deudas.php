	<?php
		if (isset($con))
		{
	?>
	<script>
		function imprimir(){
		  var objeto=document.getElementById('imprimeme');  //obtenemos el objeto a imprimir
		  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
		  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
		  ventana.document.close();  //cerramos el documento
		  ventana.print();  //imprimimos la ventana
		  ventana.close();  //cerramos la ventana
		}
	</script>
	<!-- Modal -->
	<div class="modal fade" id="resumenDeudas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		<div id="imprimeme">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-usd'></i> Listado de Deudores</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="abonos_cliente" name="abonos_cliente">
			<div id="resultados_ajax3"></div>

            <div class="container-fluid">
              	<span id="resultado"></span>
            </div> 
			
		  </div>
		</div>  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cerrar</button>
			<button type='submit' class="btn btn-success" onclick="imprimir();"<span class="glyphicon glyphicon-print"></span> Imprimir</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>