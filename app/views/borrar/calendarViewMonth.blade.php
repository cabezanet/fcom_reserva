@extends('layout')
 
@section('calendar-css')
    

@stop

@section('title')
    Calendar test
@stop

@section('content')
 
<div class="panel panel-default" style = "margin-top:10px">
  <!-- Default panel contents -->

  <div class="panel-heading"><p>Calendar test</p></div>
 
  <div class="panel-body"> 
    <div class="form-inline pull-left">
      <button class="btn btn-primary" data-toggle="modal" data-target=".myModal-lg">Nueva reserva</button>
      <label for="datepicker"  class="control-label" >Fecha: </label>     
      <input type="text" class="form-control" placeholder="cambiar fecha" id="datepicker" style = "width:100px" value='{{$numMonth}} / {{$year}}' />
    </div>

    <div class="form-inline pull-right btn-group" id = "btnView">
      <button class="btn btn-warning" data-calendar-view="year">Year</button>
      <button class="btn btn-warning active" data-calendar-view="month">Month</button>
      <button class="btn btn-warning" data-calendar-view="week">Week</button>
      <button class="btn btn-warning" data-calendar-view="day">Day</button>
    </div>
    <div id="msgBox"></div>
    <table style = "table-layout: fixed;width: 100%;" >
      <caption><span id="alternate">{{$month}} / {{$year}}</span></caption>
      <thead id="tableHead">{{$tHead}}</thead>
      <tbody id="tableBody">{{$tBody}}</tbody>
    </table>
  </div>
</div>

 <!-- Modal -->
<div class="modal fade myModal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title" id="myModalLabel">Nueva reserva en "Espacio selecionado"</h3>
      </div>
      

      <div class="modal-body">
      

        <form class="form-horizontal" role="form" id = "addEvent">
          
          <div class="form-group">
            <label for="titulo"  class="control-label col-sm-2" >Título: </label>   
            <div class = "col-sm-10">  
             <input type="text" name = "titulo" class="form-control" placeholder="Introducir título de la reserva" id="newReservaTitle" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-sm-2">Actividad:</label>
            <div class="col-sm-4">
              <select class="form-control"  name = "actividad" id="tipoActividad">
              <option>tipo 1 </option>
              <option>tipo 2</option>
            </select>
            </div>
          </div>
<!--
          <div class="form-group">
            <label class="control-label col-sm-2">Espacio / equipo: </label> 
              <div class="col-sm-10">    
                <input type="text" name="recurso" class="form-control" id="newReservaRecurso"  value="Recurso prev. seleccionado (cambiar?)" />
              </div>
          </div>
          
-->
          <div class="form-group">
            <label for="fInicio"  class="control-label col-sm-2" >Desde: </label> 
            <div class="col-sm-4">  
              <input type="text" name="fInicio" class="form-control" id="datepickerFinicio" />
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Inicio:</label>
              <div class="col-sm-4">
                <select class="form-control"  name="hInicio" id="newReservaHinicio">
                <option>8:30 </option>
                <option>9:30</option>
                <option>10:30</option>
              </select>
              </div>
              <label class="control-label col-sm-2">Fin:</label>
              <div class="col-sm-4">
                <select class="form-control"  name="hFin" id="newReservaHfin">
                <option>9:30</option>
                <option>10:30</option>
                <option>11:30</option>
                </select>
              </div>
          </div>

          <div class="form-group">
            <label  class="control-label col-sm-2">Repetir: </label> 
            <div class="col-sm-4">  
              <select class="form-control" name="repetir" id="newReservaRepetir">
                <option>No repetir</option>
                <option>Cada Semana</option>
              </select>
            </div>
          </div>
          
          <div class="form-group">
           <label  class="control-label col-sm-2">Los días: </label>
            <div class="col-sm-10">
              <div class="checkbox-inline" name="diasRepeticion[L]">
                <label><input type="checkbox"> L</label>
              </div>
              <div class="checkbox-inline">
                <label><input type="checkbox" name="diasRepeticion[M]"> M</label>
              </div>  
              <div class="checkbox-inline">
               <label><input type="checkbox" name="diasRepeticion[X]"> X</label>  
              </div>
              <div class="checkbox-inline">
               <label><input type="checkbox" name="diasRepeticion[J]"> J</label>  
              </div>
              <div class="checkbox-inline">
                <label><input type="checkbox" name="diasRepeticion[V]"> V</label>  
              </div>
            </div>          
          </div>

          <div class="form-group">
            <label for="fechaFin"  name="fFin" class="control-label col-sm-2">Hasta: </label> 
            <div class="col-sm-4">  
              <input type="text" class="form-control" id="datepickerFfin" />
            </div>
          </div>
       </form>
      </div>
      

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="test">Salvar</button>
      </div>
      
     
    </div>
  </div>
</div>


 

@stop

@section('calendar-js')
{{HTML::script('assets/js/calendar.js')}}
@stop 