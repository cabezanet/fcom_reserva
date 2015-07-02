@extends('admin.layout')

@section('title')
    Acceso para administradores: Inicio
@stop


@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Escritorio</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>


<div class="row">
    
    <div class="col-lg-8">
        <div class="alert alert-success alert-dismissible" role="alert" id="msgsuccess" style="display:none" ><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>   
        <div class="alert alert-danger alert-dismissible" role="alert" id="msgerror" style="display:none" ><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>   
        <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-comment fa-fw"></i> Peticiones de alta </h4>   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" id='listTask'>
                        @if($notificaciones->count()>0)
                            @foreach($notificaciones as $notificacion)
                                <div class="list-group" data-uvus = "{{$notificacion->source}}" data-sourceId = "{{$notificacion->id}}">
                                    <a href="#"   class="list-group-item" title="Activar" data-toggle="modal" data-target="#modalUser">
                                        {{$notificacion->msg }}
                                       <!-- <span class="pull-right text-muted small"><em>hace 4 minutos</em>
                                        </span>-->
                                    </a>
                                    
                                </div>
                                <!-- /.list-group -->
                            @endforeach
                           <!-- <a href="#" class="btn btn-default btn-block">Ver todas las peticiones</a> -->
                        
                        @else
                            <div class="alert alert-info" role="alert">No hay peticiones pendientes</a>
                        @endif
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
    </div>
    
</div>

<div id = "espera"></div>


<div class="modal fade" id="modalUser">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Petición de alta</h4>
      </div>
      <div class="modal-body">

        <form class="form-horizontal" role="form" id = "activeUser">
        
            <div class="form-group" id="uvus">
                    <label for="uvus"  class="control-label col-md-2" >Uvus: </label>   
                    <div class = "col-md-10">  
                        <input type="text" name = "uvus" class="form-control" id="uvus"  disabled/>
                    </div>             
            </div>

            <div class="form-group" id="colectivo">
                <label for="colectivo"  class="control-label col-md-2" >Colectivo: </label>
                <div class = "col-md-10">  
                    <select class="form-control" name='colectivo'>
                        <option value="Alumno" selected="selected">Alumno</option>
                        <option value="PDI">PDI</option>
                        <option value="PAS">PAS</option>
                    </select> 
                </div>
                
            </div>

            <div class="form-group" id="rol">
                <label for="rol"  class="control-label col-md-2" >Rol: </label>
                <div class = "col-md-10">  
                    <select class="form-control"  name="rol">
                        <option value="1" selected="selected" >Usuario (Alumnos)</option>
                        <option value="2" >Usuario Avanzado (PDI)</option>
                        <option value="3">Técnico (PAS)</option>
                        <option value="4">Administrador (root)</option>
                        <option value="5">Validador</option>
                    </select> 
                </div>
            </div>

            <div class="form-group">
                <label for="fInicio"  class="control-label col-md-3" >Caduca el: </label> 
                <div class="col-md-9">  
                    <input type="text" name="caducidad" class="form-control" id="datepickerCaducidad" value=""/>
                </div>
          </div>
                
        </form>    
      </div><!-- ./modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id='activar'>Activar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop