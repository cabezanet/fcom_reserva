@extends('calendarioslayout')
 
@section('title')
    Calendarios
@stop

@section('sidebar')


<div class="col-sm-6 col-md-3 sidebar"  style="margin-top:20px !important;">
  <p>{{$nh}}</p>
  <form class="form" role="form" id="selectRecurse" >
    <div class="form-group">
    <label for="groupName">Seleccione recurso</label> 
      <select class="form-control" id="selectGroupRecurse" name="groupID" >
          <option value="0" disabled selected>Espacio o equipo:</option>
          @foreach ($grupos as $grupo)
            <option value="{{$grupo->grupo_id}}" placeholder="Seleccione recurso...">{{$grupo->grupo}}</option>
          @endforeach
        </select>
    
        <div  id="selectRecurseInGroup" style="display:none;margin-top:5px;">
          <select class="form-control" id="recurse" name="recurseName">          
          </select>
        </div>
        
      </div>
  </form>

  <div><label>Fecha:</label></div>
  <div id="datepicker" value="{{date('d-m-Y',ACL::fristMonday())}}" style="width:190px" ></div>
</div>

@stop
@section('content')
<!--<div id = "espera"></div>-->

<div id="page-wrapper"> 


  <div class="row">
  <div id = "espera"></div>

    <div id="calendario">
      <h2 >Calendario: <span id ="recurseName"></span> </h2>
      <hr />

      <div class="form-inline pull-left" role="form">
        
        <div class="form-group">
          <button class="btn btn-danger" data-toggle="modal" data-target=".myModal-sm" id="btnNuevaReserva" data-fristday="{{date('d-m-Y',ACL::fristMonday())}}">
           Nueva reserva
          </button>
        </div>  
      </div>  

      
      <div class="form-inline pull-right btn-group">
        <div class="btn-group" style = "margin-right:10px" id="btnNav">
          <button class="btn btn-primary" data-calendar-nav="prev" id="navprev"><< </button>
          <button class="btn btn-default active" data-calendar-nav="today" id="navhoy">Hoy</button>
          <button class="btn btn-primary" data-calendar-nav="next" id="navnext"> >></button>
        </div>
        <div class="btn-group" id = "btnView">
          <button class="btn btn-warning" data-calendar-view="year">Year</button>
          <button class="btn btn-warning active" data-calendar-view="month">Month</button>
          <button class="btn btn-warning" data-calendar-view="week">Week</button>
          <button class="btn btn-warning" data-calendar-view="day">Day</button>
          <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" data-container='body' title="Agenda" data-calendar-view="agenda">
          <span class="glyphicon glyphicon-list-alt"></span> Agenda
          </button>
        </div>
      </div>  

      

      <!-- en vista calendario.blade.msg -->
      @if(isset($msg) && !empty($msg))
        <div class="alert alert-danger pull-left col-sm-12" role="alert" id="alert_msg" data-nh="{{$nh}}"><strong>{{$msg}}</strong></div> 
      @else
        <div class="alert alert-danger pull-left col-sm-12" role="alert" id="alert"><strong> Por favor, seleccione espacio o medio a reservar</strong></div> 
        <div class="alert alert-info pull-left col-sm-12" role="alert" id="msg"></div> 
      @endif
      
      <div style = "display:none" id = "message" class = "alert alert-success col-md-12" role="alert">
     <!-- en vista calendario.blade.msg -->
      </div>


      <!-- en vista calendario.calendario -->
      <div id="loadCalendar">  
        <table class="pull-left" style = "table-layout: fixed;width: 100%;" id="tableCalendar" >
          <caption id="tableCaption">{{$tCaption}}</caption>
          <thead id="tableHead">{{$tHead}}</thead>
          <tbody id="tableBody">{{$tBody}}</tbody>
        </table>
      </div>
      <!-- fin en vista calendario.calendario -->
    </div>   


 </div>
 <!-- /#row -->
</div>

  <!-- /#page-wrapper -->

 <!-- Modal deleteEvent
  **********************
  **********************
   -->

  <div class="modal fade deleteOptionsModal-lg " id="deleteOptionsModal" tabindex="-2" role="dialog" aria-labelledby="optionsDelete" aria-hidden="true">
    
    <div class="modal-dialog modal-lg">
      
      <div class="modal-content">
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title" id="deleteModalTitle">Eliminar evento</h3>
        </div>
        

        <div class="modal-body" style = "min-height:100px">
         <!-- <form class="form-horizontal" role="form" id = "delEvent">
              
              <div class="col-lg-10 col-lg-offset-1 alert alert-info" role="alert">
                  ¿Deseas eliminar únicamente este evento, todos los eventos de esta serie o bien este y todos los eventos futuros de esta serie?
              </div> 
             

                <div class="form-group">
                  <button type="button" class="btn btn-primary  col-lg-5  col-lg-offset-1 optiondel" id="option1" data-id-serie="" data-id-evento="">Solo este  evento</button>
                  <div class="col-lg-6">Se conservarán el resto de eventos de la serie</div> 
                </div>
                
                <div class ="form-group">
                  <button type="button" class="btn btn-primary col-lg-5 col-lg-offset-1 optiondel" id="option2" data-id-serie="" data-id-evento="" >Este y todos los siguientes</button>
                  <div class="col-lg-6">Se elimina este elemento y todos los de la serie</div> 
                </div>
          -->
                
                  <div  class="col-md-12 alert alert-danger" rol="alert" >¿Seguro que desea eliminar el evento?</div>
                  
                   
                
         <!-- </form> -->
          

        </div>
    
        <div class="modal-footer">
         
          <div class="col-md-12">
            <button type="button" class="btn btn-primary optiondel" id="option1" data-id-serie="" data-id-evento="">Eliminar evento/s</button><br />
          </div>  
          <div class="col-lg-12" style="margin-top:10px">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      
      </div>
    </div>
  </div>

  <!-- / Modal addEvent // editEvent  -->
 
  <div class="modal fade myModal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="formNewEvent" aria-hidden="true">
    
    <div class="modal-dialog modal-lg">
     
      <div class="modal-content">
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title" id="myModalLabel"></h3>
        </div>
        

        <div class="modal-body">
          <form class="form-horizontal" role="form" id = "addEvent">
            <h4 style = "border-bottom:1px solid #bbb;color:#999;margin:0px;margin-bottom:10px;">Información básica</h4>
            
            <!-- Errores --> 
            <div id = 'errorsModalAdd' class = "col-md-12 alert alert-danger is_slide" style = "display:none">  
              <p id="titulo_Error" class="col-md-12" style=""></p>
              <p id="fInicio_Error" class="col-md-12" style=""></p>
              <p id="hFin_Error" class="col-md-12" style=""></p>
              <p id="fEvento_Error" class="col-md-12" style=""></p>
              <p id="fFin_Error" class="col-md-12" style=""></p>
              <p id="dias_Error" class="col-md-12" style=""></p>
            </div>


            <!-- título -->

            <div class="form-group" id="titulo">
              <label for="titulo"  class="control-label col-sm-2" >Título: </label>   
              <div class = "col-sm-10">  
                <input type="text" name = "titulo" class="form-control" placeholder="Introducir título de la reserva" id="newReservaTitle" />
              </div>             
            </div>
            
           
            <!-- Actividad -->
            <div class="form-group">
              <label class="control-label col-sm-2">Actividad:</label>
              <div class="col-sm-8">
                <select class="form-control"  name="actividad" id="tipoActividad">
                  @if (Auth::user()->capacidad > 1)<option value="Docencia Reglada PAP">Docencia Reglada PAP</option>@endif
                  @if (Auth::user()->capacidad > 1)<option value="Títulos propios">Títulos propios</option>@endif
                  @if (Auth::user()->capacidad > 1)<option value="Otra actividad docente/investigadora">Otra actividad docente/investigadora</option>@endif
                  @if (Auth::user()->capacidad == 1)<option value="Autoaprendizaje">Autoaprendizaje</option>@endif
                  @if (Auth::user()->capacidad > 1)<option value="Otra actividad">Otra actividad</option>@endif
                </select>
              </div>
            </div>

           
            <!-- Fecha  evento -->
            <div class="form-group" id="fInicio">
                  <label for="fInicio"  class="control-label col-md-2" >Fecha: </label> 
                  <div class="col-md-4" >  
                    <input type="text"  name="fInicio" class="form-control" id="datepickerFinicio" />
                  </div>
            </div>
            
            <!-- horario -->
            <div class="form-group" id="hFin">
              <label class="control-label col-sm-2">Horario desde:</label>
              <div class="col-sm-4">
                  <select class="form-control"  name="hInicio" id="newReservaHinicio">
                    <option value="8:30">8:30</option>
                    <option value="9:30">9:30</option>
                    <option value="10:30">10:30</option>
                    <option value="11:30">11:30</option>
                    <option value="12:30">12:30</option>
                    <option value="13:30">13:30</option>
                    <option value="14:30">14:30</option>
                    <option value="15:30">15:30</option>
                    <option value="16:30">16:30</option>
                    <option value="17:30">17:30</option>
                    <option value="18:30">18:30</option>
                    <option value="19:30">19:30</option>
                    <option value="20:30">20:30</option>
                  </select>
              </div>
              <label class="control-label col-sm-2">Hasta:</label>
              <div class="col-sm-4">
                  <select class="form-control"  name="hFin" id="newReservaHfin">
                    <option value="9:30">9:30</option>
                    <option value="10:30">10:30</option>
                    <option value="11:30">11:30</option>
                    <option value="12:30">12:30</option>
                    <option value="13:30">13:30</option>
                    <option value="14:30">14:30</option>
                    <option value="15:30">15:30</option>
                    <option value="16:30">16:30</option>
                    <option value="17:30">17:30</option>
                    <option value="18:30">18:30</option>
                    <option value="19:30">19:30</option>
                    <option value="20:30">20:30</option>
                    <option value="21:30">21:30</option>
                  </select>
              </div>
            </div>
            
           
          <div @if (ACL::withOutRepetition()) {{'style="display:none"'}} @endif>
            <h4 style = "border-bottom:1px solid #bbb;color:#999;margin:0px;margin-bottom:10px;">Periocidad</h4>

            <!-- repetición?? -->
            <div class="form-group">
              <label  class="control-label col-md-2">Repetir.... </label> 
              <div class="col-md-10">  
                  <select class="form-control" name="repetir" id="newReservaRepetir" >
                    <option value="SR">Sin repetición</option>
                    <option value="CS">Cada Semana</option>
                  </select>
              </div>
            </div>

            <!-- fecha inicio, fecha finalización y días -->            
            <div id="inputRepeticion">
              <!-- fecha inicio -->
              <div class="form-group" id="fEvento">
                  <label for="fEvento"  class="control-label col-md-2" >Empieza el: </label> 
                  <div class="col-md-4">  
                    <input type="text" name="fEvento" readonly class="form-control"   id="datepickerFevento"  />
                  </div>
              </div>    
              <!-- fecha finalización -->
              <div class="form-group" id="fIni">
                  <label for="fFin"  class="control-label col-md-2">Finaliza el: </label> 
                    <div class="col-md-4">  
                      <input type="text" name="fFin" class="form-control" id="datepickerFfin" />
                    </div>
              </div>
              <!-- días -->
              <div class="form-group" id="dias">
                <label  class="control-label col-md-2">Los días: </label>
                <div class="col-md-10">
                  <div class="checkbox-inline" style="display:none">
                    <label><input type="checkbox" value = "0" name="dias[]"> D</label>
                  </div>
                  <div class="checkbox-inline">
                    <label><input type="checkbox" value = "1" name="dias[]"> L</label>
                  </div>
                  <div class="checkbox-inline">
                    <label><input type="checkbox" value = "2" name="dias[]"> M</label>
                  </div>  
                  <div class="checkbox-inline">
                    <label><input type="checkbox" value = "3" name="dias[]"> X</label>  
                  </div>
                  <div class="checkbox-inline">
                    <label><input type="checkbox" value = "4" name="dias[]"> J</label>  
                  </div>
                  <div class="checkbox-inline">
                    <label><input type="checkbox" value = "5" name="dias[]"> V</label>  
                  </div>
                  <div class="checkbox-inline" style="display:none">
                    <label><input type="checkbox" value = "6" name="dias[]"> S</label>
                  </div>
                </div> 
              </div>        
              
            </div>
           
          </div>  

          <h4 style = "border-bottom:1px solid #bbb;color:#999;margin:0px;margin-bottom:10px;">Resumen</h4>
          
            <div class="alert alert-info" role="alert" id="resumen"><p></p></div>
          
          

         
            <!-- fin elementos de edición -->
            
            <input type="hidden" name="id_recurso" id="idRecurso" value="" />
            <input type="hidden" name="action"  id="actionType" value="" />
            
        </form>
        
         
       </div>
        

        <div class="modal-footer">
        <!-- elemntos para edición -->
            <!--   -->
        
          <div class="col-md-12 " style = "display:none" id = "editOptions">
            
           <!-- @if (Auth::user()->capacidad > 1)          
            <button type="button" class="btn btn-primary  optionedit" id="editOption1" data-id-serie="" data-id-evento="">Modificar evento</button>
            <button type="button" class="btn btn-primary optionedit" id="editOption2" data-id-serie="" data-id-evento="" >Modificar este y los siguientes eventos de la serie</button>
            <button type="button" class="btn btn-primary optionedit" id="editOption3" data-id-serie="" data-id-evento="">Modificar todos los eventos de la serie</button>
            @else -->
            
            <!-- @endif -->
            <button type="button" class="btn btn-primary  optionedit" id="editOption1" data-id-serie="" data-id-evento="">Modificar evento</button>
           
         </div>
         <div class="col-lg-12" style="margin-top:10px">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="save">Salvar</button>
          </div>
          
       
         
        </div>
        
       
      </div>
    </div>
 
  </div>

 


 @stop

