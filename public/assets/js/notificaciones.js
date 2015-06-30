$(function(e){

	$('.list-group').on('click',function(e){
		
		var $id = $(this).data('sourceid');
		var $item = $(this);

		$('input:text[name=uvus]').val($(this).data('uvus'));
		
		$('#activar').on('click',function(e){

			e.preventDefault();

			$data = 'id='+ $id+ '&' +'username=' + $('input:text[name=uvus]').val()+ '&' +$('form#activeUser').serialize();
			showGifEspera();
			$.ajax({
					type:"POST",
					url:"ajaxActiveUser",
					data: $data,
					success: function(respuesta){
						$('#msgsuccess').append('<p>Usuario <b>'+$('input:text[name=uvus]').val()+'</b> activado con éxito</p>').slideToggle('slow');
						$item.remove();			
						hideGifEspera();
					},
					error: function(xhr, ajaxOptions, thrownError){

							$('#msgerror').append('<p>Error al activar usuario con UVUS <b>'+$('input:text[name=uvus]').val()+'</b></p>').slideToggle('slow');
							console.log(xhr.status);
           					console.log(xhr.responseText);
           					console.log(thrownError);
           					hideGifEspera();
					}
			});
			$("#modalUser").modal('hide');
			
		});
		
		
	});

	var $defaultDate = new Date();
	var $currentYear = $defaultDate.getFullYear();
	var $defaultYear = $currentYear + 5;
	$defaultDate.setFullYear($defaultYear); 
	$("#datepickerCaducidad").datepicker({
			defaultDate: $defaultDate,
			showOtherMonths: true,
	      	selectOtherMonths: true,
	      	showAnim: 'slideDown',
	  		dateFormat: 'd-m-yy',
	  		showButtonPanel: true,
	  		firstDay: 1,
			monthNames: ['Enero', 'Febrero', 'Marzo','Abril', 'Mayo', 'Junio','Julio', 'Agosto','Septiembre', 'Octubre','Noviembre', 'Diciembre'],
			dayNamesMin: ['Do','Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
	  	});
	//console.log($defaultYear);
	$("#datepickerCaducidad").val($defaultDate.getDate() + '-' + $defaultDate.getMonth() + '-' + $defaultDate.getFullYear());

	function showGifEspera(){
		
		$('#espera').css('z-index','1000');
	}

	function hideGifEspera(){
		$('#espera').css('z-index','-1000');
	}

});