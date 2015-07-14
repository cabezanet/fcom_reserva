$(function(e){

	$('#botonBuscar').click(function(e){
		e.preventDefault();
		//console.log(lector.getJsonObject().toString());
		var dni = lector.getJsonObject().get("dni");
		$('#dni').val(dni).change();
		//$('#dni').change();	
	});

	$('#dni').on('change', function(){
		
		//console.log('{"dni":"' + $('#dni').val() + '"}');
		//$('#panelResult').fadeToggle('slow');
		$.ajax({
	    	   	type: "POST",
				url: "search",
				data: {dni: + $('#dni').val()},
				
				success: function(respuesta){
					$('#resultsearch').html(respuesta);
					programclick(respuesta);
					//$('#panelResult').fadeIn('slow');
					//console.log('{"dni":"' + $('#dni').val() + '"}');
	        		
		        	},
				error: function(xhr, ajaxOptions, thrownError){
						alert(xhr.status);
	        			alert(thrownError);
						}
	      			});
	});

	function programclick(respuesta) {
			$('.list-group-item').each(function(){
  					
					$(this).on('click',function(e){

						//console.log(document.getElementsByTagName("a")[0].innerHTML);
						//e.preventDefault();
						//alert('Formulario de Reserva atendida...');
					    $( '#myModal' ).modal();
					   	var $dataEvent = $(this).data('event');
					   	$('titulo').val($dataEvent.titulo);
						console.log($(this).data('event'));					   
					    $('#myModal').on('shown.bs.modal', function(e){
					      jQuery('#lector').hide();
					    });

					    $('#myModal').on('hidden.bs.modal', function(e){
					      jQuery('#lector').show();
					    })
						
					});
				});
		}
});


