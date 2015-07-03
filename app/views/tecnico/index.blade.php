@extends('tecnico.layout')

@section('title')
    Acceso para administradores: Inicio
@stop


@section('content')

<div class="row">
    <div class="col-lg-12">
        <h2 style="display:none"class="page-header"><i class="fa fa-dashboard fa-fw"></i> Escritorio</h2>
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
            <div class="panel-body" class="middle">
                <div id="LeerDNI">
                    <applet id="lector"  
                        code="fcom.maviuno.LectorCarnetUniversitario/InfoUI.class" 
                        codebase="https://150.214.225.41/reserva/public/assets/applet" 
                        archive="LectorCarnetUniversitario.jar, json-simple-1.1.1.jar" 
                        width=448 
                        height=308>
                    </applet>
                </div>
                <a id="botonBuscar" type="submit" class="btn btn-primary">Reservas</a>   
                <div class="form-group">
                    <label hidden for="dni">DNI:</label>
                    <input type="hidden" class="form-control" id="dni" placeholder="Introduzca DNI"; name="dni">
                </div>
                  <!--  <button type="submit" class="btn btn-primary"><i class="fa fa-search fa-fw"></i> Buscar</button> -->  
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>

<div class="row">
    
    <div class="col-md-12">
           
        <div class="panel panel-default" id="panelResult" >
            <div class="panel-heading">
                <i class="fa fa-list fa-fw"></i> Resultados de la busqueda
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body"  id="resultsearch">
                <!--En este espacio se carga la reserva de un usuario o mensajes de advertencia-->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

@stop