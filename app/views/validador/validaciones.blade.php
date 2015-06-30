@extends('validador.layout')

@section('title')
    Acceso para validadores: Inicio
@stop

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="modalValidacion" tabindex="-1" role="dialog" aria-labelledby="mValida" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="mValida">Solicitud de reserva</h4>
          </div>
          <div class="modal-body">
            <div class="panel panel-default">
                <div class="panel-heading">Registro</div>
                <div class="panel-body">
                    <dl class="dl-horizontal" >
                        <dt>Fecha de la Petición: </dt>
                        <dd id ="fPeticion"></dd>
                        <dt>Estado: </dt>
                        <dd id ="estado"></dd>
                    </dl>
                </div>
            </div> 
            <div class="panel panel-default">
                <div class="panel-heading">Solicitud</div>
                <div class="panel-body">
                    <dl class="dl-horizontal">

                        <dt>Espacio: </dt>
                        <dd id ="espacio"></dd>
                        <dt>Actividad: </dt>
                        <dd id ="actividad"></dd>
                        <dt>Usuario: </dt>
                        <dd id ="usuario"></dd>
                        <dt>Título: </dt>
                        <dd id ="titulo"></dd>
                        <dt>Fecha de inicio: </dt>
                        <dd id ="fInicio"></dd>
                        <dt>Fecha de Finalización: </dt>
                        <dd id ="fFin"></dd>
                        <dt>Horario: </dt>
                        <dd id ="horario"></dd>
                        <dt>Día/s de la semana: </dt>
                        <dd id ="dSemana"></dd>
                    </dl>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-success" href="" role="button" id="aprobar"><i class="fa fa-check fa-fw"></i> Aprobar</a>
            <a class="btn btn-danger" href="" role="button" id="denegar"><i class="fa fa-check fa-fw"></i> Denegar</a>
            
          </div>
        </div>
      </div>
    </div>
@stop

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Validar</h3>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    
    
           
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-check fa-fw"></i> Validaciones pendientes    
            </div>
            <!-- /.panel-heading -->
            @if (!empty($resultValidacion))
	         	@if($resultValidacion)
	           	<div class="alert alert-success" rol="alert">Validación correcta</div>
	           	@else
	           	<div class="alert alert-danger" rol="alert">No se pudo validar la solicitud</div>
	           	@endif
	        @endif
            <div class="panel-body">
            	
			       	<form id='formfilter'>
			       		<div class = "row">
				       		<div class="form-group form-group-md col-md-2 col-md-offset-7 ">
								  
						    	
								    <select class="form-control " name = "id_recurso" id="selectRecurso">

										<option value="0" @if($idrecurso == 0) selected="selected" @endif >Todos los espacios</option>
										@foreach($eventsByrecurso as $event)
											<option value="{{$event->recurso_id}}" 

											@if ($idrecurso == $event->recurso_id)
												selected="selected" 
											@endif 

											>{{$event->recursoOwn->nombre}}</option>
										@endforeach
									</select>
						    	
						    </div>
						
						  	<div class="form-group form-group-md col-md-2">  		
						    	
								    <select class="form-control" id="selectUser" name="id_user">
										<option value="0" @if($iduser == 0) selected="selected" @endif>Todos los usuarios</option>
										@foreach($eventsByUser as $event)
											<option value="{{$event->userOwn->id}}" 
											
											@if($iduser == $event->userOwn->id)
												selected="selected" 	
											@endif
											>
											
											{{$event->userOwn->apellidos}}, {{$event->userOwn->nombre}}</option>
										@endforeach
									</select>
						   		
							</div>
							<div class="form-group form-group-md col-md-1"> 
							 	<a class="btn btn-primary" href="" role="button" id="filter"><i class="fa fa-filter fa-fw"></i> filtrar</a>
							 </div>
						</div>
					</form>
			          

				@if (!$events->count()) 
                    	<div class="alert alert-danger" role="alert">No hay solicitudes pendientes de validación</div>
		        @else    
                
                
                <div class="table-responsive">    
					<!-- Table -->
	  				<table class="table table-hover table-striped">
	  				<thead>
	  					<th>#</th>
	  					<th  style="width: 20%;">
	  					Espacios

	  					</th>
	  					<th style="width: 30%;">
	  					
		  				Usuarios

		  					</th>
							<th style="width: 20%;">
						  	@if ($sortby == 'actividad' && $order == 'asc') {{
			                	link_to_action(
			                    	'ValidacionController@index',
			                    	'Actividad',
			                        array(
			                        	'sortby' => 'actividad',
			                            'order' => 'desc',
			                            'id_recurso' => $idrecurso,
			                            'id_user'	=>	$iduser
			                            )
			                        )
			                   }}
		                    @else {{
			              	    link_to_action(
			                       'ValidacionController@index',
			                            'Actividad',
			                            array(
			                                'sortby' => 'actividad',
			                                'order' => 'asc',
			                                'id_recurso' => $idrecurso,
			                                'id_user'	=>	$iduser
			                            )
			                        )
			                    }}
			                @endif
			                <i class="fa fa-sort fa-fw text-info"></i>
		  					</th>
						  	<th>

						  	@if ($sortby == 'created_at' && $order == 'asc') {{
			                	link_to_action(
			                    	'ValidacionController@index',
			                    	'Fecha de registro',
			                        array(
			                        	'sortby' => 'created_at',
			                            'order' => 'desc',
			                            'id_recurso' => $idrecurso,
			                            'id_user'	=>	$iduser
			                            )
			                        )
			                   }}
		                    @else {{
			              	    link_to_action(
			                       'ValidacionController@index',
			                            'Fecha de registro',
			                            array(
			                                'sortby' => 'created_at',
			                                'order' => 'asc',
			                                'id_recurso' => $idrecurso,
			                            	'id_user'	=>	$iduser
			                            )
			                        )
			                    }}
			                @endif
			                <i class="fa fa-sort fa-fw text-info"></i>
		  					</th>
	  				</thead>
	    			<tbody>
	    		
		    			@foreach($events as $event)
		    				@if (Calendar::hasSolapamientos($event->evento_id,$event->recurso_id))
		    					  
		    					<tr class="danger text-danger event" data-toggle="tooltip" title="Solicitud con solapamiento" data-idEvent = "{{$event->id}}">
		    						<td>
		    							<span  class="glyphicon glyphicon-exclamation-sign " aria-hidden="true"></span>
		    						</td>
		    				@else
		    					
		                        <tr class="event" data-toggle="tooltip" title="Solicitud pendiente de validación" data-idEvent = "{{$event->id}}">
		                        	<td>
			                        	<span  class=" glyphicon glyphicon-question-sign text-info" aria-hidden="true"></span>
			                        </td>
		                    @endif
		    					
			                        <td>
				                        <i class="fa fa-calendar fa-fw "></i>
				                        <span>{{$event->recursoOwn->nombre}}</span>
			                        </td>
			                        
			                        <td>
			                        	<i class="fa fa-user fa-fw "></i>
			                           	<span>{{$event->userOwn->apellidos}}, {{$event->userOwn->nombre}}</span>
			                        </td>

			                        <td>
			                        	<i class="fa fa-book fa-fw "></i>
			                           	<span>{{$event->actividad}}</span>
			                        </td>
			                        
			                        <td>  
			                        	<i class="fa fa-clock-o fa-fw "></i>            
			                         	<span class="pull-center  small"><em> {{date('d \d\e M \d\e Y \a \l\a\s H:i',strtotime($event->created_at))}}</em></span>
			                        </td>
			                    </tr>
			                
		                    @endforeach
		                
	    			</tbody>

	  				</table>

		            @endif
				</div>

				<!-- /.table-responsive -->
				
				{{$events->appends(Input::except('page','result'))->links();}}
            </div>          
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
 
    
</div>
<!-- /.row -->
@stop