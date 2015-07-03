@extends('tecnico.layout')

@section('title')
    Acceso para administradores: Inicio
@stop


@section('content')

<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header"><i class="fa fa-dashboard fa-fw"></i> Escritorio</h2>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    
    <div class="col-md-12">
           
        <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-search fa-fw"></i> Buscador de reservas     
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <div id="contienApplet"> 
                            <applet id="lector"
  name="SCReader"  
    code="fcom.maviuno.LectorCarnetUniversitario/InfoUI.class" 
    codebase="https://150.214.135.226/reservas/assets/applets" 
    archive="LectorCarnetUniversitario.jar, json-simple-1.1.1.jar" 
    width=500 
    height=400>
</applet>
</div>
                            {{Form::open(array('action' => 'CalendarController@search'))}}  
                                <div class="form-group">
                                    <label for="dni">DNI:</label>
                                    <input type="text" class="form-control" id="dni" placeholder="Introduzca DNI" name="dni">
                                </div>
                                <button id = "botonbuscar" type="submit" class="btn btn-primary"><i class="fa fa-search fa-fw"></i> Buscar</button>            
                            {{Form::close()}}
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
    </div>
    
</div>

<div class="row">
    
    <div class="col-md-12">
           
        <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-list fa-fw"></i> Resultados de la busqueda
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" >

                        @if (!empty($events))
                            @foreach ($events as $event)
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-info fa-fw"></i>
                                    {{$event->recursoOwn->nombre}} - ({{strftime('%d/%m/%Y',Date::getTimeStampEN($event->fechaEvento))}}) - {{$event->horaInicio}} // {{$event->horaFin}} //{{$event->titulo}}
                                </a>
                            </div>
                            @endforeach
                        @else
                            
                              @if (!empty($dni))      
                              <div class="alert alert-warning" rol="alert">
                                  <p>No hay eventos para el usuario con dni {{$dni}}</p>
                              </div>  
                              @endif  
                           
                        @endif    

                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
    </div>
    
</div>

@stop
@section('calendar-js')
<script src="../assets/js/prueba.js"></script>
@stop