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
                        codebase="https://localhost/reserva/public/assets/applet" 
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

@stop