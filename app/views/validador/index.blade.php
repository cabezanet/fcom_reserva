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
            <button type="button" class="btn btn-primary">Aprobar</button>
            <button type="button" class="btn btn-primary">Denegar</button>
          </div>
        </div>
      </div>
    </div>
@stop


@section('content')

<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Escritorio</h2>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    
    <div class="col-md-12">
           
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-check fa-fw"></i> Validaciones pendientes    
            </div>
            <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                    @foreach($events as $event)
                        <a href="#" class="list-group-item event" data-idEvent = "{{$event->id}}">       
                        @if (Calendar::hasSolapamientos($event->evento_id,$event->recurso_id))
                            <span data-toggle="tooltip" title="Solicitud con solapamiento" class="glyphicon glyphicon-exclamation-sign text-danger" aria-hidden="true"></span>
                                      
                            <i class="fa fa-calendar fa-fw text-danger"></i>

                            <span class="text-danger">{{$event->recursoOwn->nombre}}, {{$event->userOwn->nombre}} {{$event->userOwn->apellidos}}</span>
                                          
                            <span class="pull-right text-muted small text-danger"><em> {{date('d \d\e M \d\e Y \a \l\a\s H:i',strtotime($event->created_at))}}</em></span>
                        @else
                            <span data-toggle="tooltip" title="Solicitud pendiente de validación" class=" glyphicon glyphicon-question-sign text-info" aria-hidden="true"></span>

                            <i class="fa fa-calendar fa-fw text-info"></i>

                            <span class="text-info">{{$event->recursoOwn->nombre}}, {{$event->userOwn->nombre}} {{$event->userOwn->apellidos}} </span>
                                          
                            <span class="pull-right text-muted small text-info"><em> {{date('d \d\e M \d\e Y \a \l\a\s H:i',strtotime($event->created_at))}}</em></span>               
                        @endif
                        </a>
                                   
                    @endforeach
                    </div>
                    <!-- /.list-group -->
                    <a href="{{route('validaciones.html');}}" class="btn btn-default btn-block">Ver todas las notificaciones</a>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
    </div>
    
</div>
<div class="row">
    
    <div class="col-lg-8">
           
        <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-user fa-fw"></i> Panel de notificaciones    
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item" >
                                    <i class="fa fa-comment fa-fw"></i> Notificación 1
                                    <span class="pull-right text-muted small"><em>hace 4 minutos</em>
                                    </span>
                                </a>
                                
                            </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-default btn-block">Ver todas las notificaciones</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
    </div>
    
</div>
@stop