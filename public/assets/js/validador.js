$(function(e){
	

	$('.event').hover(function(){
		
		$(this).css( 'cursor', 'pointer' );
	});

	$('.event').click(function(e){

		var $this = $(this);
		var $idEvent = $this.data('idevent');
		
		$.ajax({
    	   	type: "GET",
			url: "ajaxDataEvent",
			data: {'id':$idEvent},
        	success: function($respuesta){
				
				var $solapamientos = false;
				if($respuesta['solapamientos']) $solapamientos = true;
				console.log($respuesta);
        		$.each($respuesta,function(key,value){
        			

        			if($solapamientos)	{
        				$('#'+key).removeClass('text-info');
        				$('#'+key).addClass('text-danger');
        			}
        			else {
        				$('#'+key).removeClass('text-danger');
        				$('#'+key).addClass('text-info');
        			}

        			$('#'+key).html(value);

        		});

        		

        		$.urlParam = function(name){
    				var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    				if (results==null){
      					 return null;
   					 }
   					 else{
       					return results[1] || 0;
    				}
				}
        		
        		$('a#aprobar').attr('href', 'valida.html' + '?'+'page='+$.urlParam('page')+'&id_recurso='+$respuesta['id_recurso']+'&id_user='+$respuesta['user_id']+'&evento_id=' + $respuesta['evento_id']+'&action=' + 'aprobar');
        		
        		$('a#denegar').attr('href', $(location).attr('pathname') + '?'+'page='+$.urlParam('page')+'&id_recurso='+$respuesta['id_recurso']+'&id_user='+$respuesta['user_id']+'&evento_id=' + $respuesta['evento_id']+'&action=' + 'denegar');
        	},
        	error: function(xhr, ajaxOptions, thrownError){
				alert(xhr.status);
				alert(thrownError);
				}
        	});
			$('#modalValidacion').modal('show');
	});


	$('#filter').click(function(e){
		e.preventDefault();
		$('#formfilter').submit();
	});

});