@if ($events->count() > 0)
    @foreach ($events as $event)
        <div class="list-group" >
            <a href="#" class="list-group-item" data-event='{{json_encode($event->toArray())}}'>
                <i class="fa fa-info fa-fw"></i>
                    {{$event->recursoOwn->nombre}} - ({{strftime('%d/%m/%Y',Date::getTimeStampEN($event->fechaEvento))}}) - {{$event->horaInicio}} // {{$event->horaFin}} //{{$event->titulo}}
                    {{$events}}
            </a>
            <a href="" class="btn btn-primary">Atender</a>
       </div>
     @endforeach
@else
	<div class="alert alert-warning" role="warning">No tenemos eventos para este usuario</div>
@endif

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
     
      <div class="modal-content">
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 class="modal-title" id="myModalLabel">Nueva reserva: Reservar todos</h3>
        </div>
        

        <div class="modal-body">
          <form class="form-horizontal" role="form" id="addEvent">
            <h4 style="border-bottom:1px solid #bbb;color:#999;margin:0px;margin-bottom:10px;">Información básica</h4>
            
            <!-- Errores --> 
            <div id="errorsModalAdd" class="col-md-12 alert alert-danger is_slide" style="display: none;">  
              <p id="titulo_Error" class="col-md-12" style="display: none;"></p>
              <p id="fInicio_Error" class="col-md-12" style="display: none;"></p>
              <p id="hFin_Error" class="col-md-12" style="display: none;"></p>
              <p id="fEvento_Error" class="col-md-12" style=""></p>
              <p id="fFin_Error" class="col-md-12" style="display: none;"></p>
              <p id="dias_Error" class="col-md-12" style="display: none;"></p>
            </div>


            <!-- título -->

            <div class="form-group" id="titulo">
              <label for="titulo" class="control-label col-sm-2">Título: </label>   
              <div class="col-sm-10">  
                <input name="titulo" vaLue=''{{$events[id]}} class="form-control" placeholder="Introducir título de la reserva" id="newReservaTitle" type="text">
                 
              </div>             
            </div>
            
           
            <!-- Actividad -->
            <div class="form-group">
              <label class="control-label col-sm-2">Actividad:</label>
              <div class="col-sm-8">
                <select class="form-control" name="actividad" id="tipoActividad">
                  <option value="Docencia Reglada PAP">Docencia Reglada PAP</option>                  
                  <option value="Títulos propios">Títulos propios</option>                  
                  <option value="Otra actividad docente/investigadora">Otra actividad docente/investigadora</option>                                    <option value="Otra actividad">Otra actividad</option>                </select>
              </div>
            </div>

           
            <!-- Fecha  evento -->
            <div class="form-group" id="fInicio">
                  <label for="fInicio" class="control-label col-md-2">Fecha: </label> 
                  <div class="col-md-4">  
                    <input name="fInicio" class="form-control hasDatepicker" id="datepickerFinicio" type="text">
                  </div>
            </div>
            
            <!-- horario -->
            <div class="form-group" id="hFin">
              <label class="control-label col-sm-2">Horario desde:</label>
              <div class="col-sm-4">
                  <select class="form-control" name="hInicio" id="newReservaHinicio">
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
                  <select class="form-control" name="hFin" id="newReservaHfin">
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
            
           
          <div>
            <h4 style="border-bottom:1px solid #bbb;color:#999;margin:0px;margin-bottom:10px;">Periocidad</h4>

            <!-- repetición?? -->
            <div class="form-group">
              <label class="control-label col-md-2">Repetir.... </label> 
              <div class="col-md-10">  
                  <select class="form-control" name="repetir" id="newReservaRepetir">
                    <option value="SR">Sin repetición</option>
                    <option value="CS">Cada Semana</option>
                  </select>
              </div>
            </div>

            <!-- fecha inicio, fecha finalización y días -->            
            <div style="display: none;" id="inputRepeticion">
              <!-- fecha inicio -->
              <div class="form-group" id="fEvento">
                  <label for="fEvento" class="control-label col-md-2">Empieza el: </label> 
                  <div class="col-md-4">  
                    <input disabled="" name="fEvento" readonly="" class="form-control hasDatepicker" id="datepickerFevento" type="text">
                  </div>
              </div>    
              <!-- fecha finalización -->
              <div class="form-group" id="fIni">
                  <label for="fFin" class="control-label col-md-2">Finaliza el: </label> 
                    <div class="col-md-4">  
                      <input name="fFin" class="form-control hasDatepicker" id="datepickerFfin" type="text">
                    </div>
              </div>
              <!-- días -->
              <div class="form-group" id="dias">
                <label class="control-label col-md-2">Los días: </label>
                <div class="col-md-10">
                  <div class="checkbox-inline" style="display:none">
                    <label><input value="0" name="dias[]" type="checkbox"> D</label>
                  </div>
                  <div class="checkbox-inline">
                    <label><input value="1" name="dias[]" type="checkbox"> L</label>
                  </div>
                  <div class="checkbox-inline">
                    <label><input value="2" name="dias[]" type="checkbox"> M</label>
                  </div>  
                  <div class="checkbox-inline">
                    <label><input value="3" name="dias[]" type="checkbox"> X</label>  
                  </div>
                  <div class="checkbox-inline">
                    <label><input value="4" name="dias[]" type="checkbox"> J</label>  
                  </div>
                  <div class="checkbox-inline">
                    <label><input value="5" name="dias[]" type="checkbox"> V</label>  
                  </div>
                  <div class="checkbox-inline" style="display:none">
                    <label><input value="6" name="dias[]" type="checkbox"> S</label>
                  </div>
                </div> 
              </div>        
              
            </div>
           
          </div>  

          <h4 style="border-bottom:1px solid #bbb;color:#999;margin:0px;margin-bottom:10px;">Resumen</h4>
          
            <div class="alert alert-info" role="alert" id="resumen"><p> miércoles, 22 de julio de 2015 de 8:30 a 9:30</p></div>
          
          

         
            <!-- fin elementos de edición -->
            
            <input name="id_recurso" id="idRecurso" value="0" type="hidden">
            <input name="action" id="actionType" value="" type="hidden">
            
        </form>
        
         
       </div>
        

        <div class="modal-footer">
        <!-- elemntos para edición -->
            <!--   -->
        
          <div class="col-md-12 " style="display:none" id="editOptions">
            
           <!--           
            <button type="button" class="btn btn-primary  optionedit" id="editOption1" data-id-serie="" data-id-evento="">Modificar evento</button>
            <button type="button" class="btn btn-primary optionedit" id="editOption2" data-id-serie="" data-id-evento="" >Modificar este y los siguientes eventos de la serie</button>
            <button type="button" class="btn btn-primary optionedit" id="editOption3" data-id-serie="" data-id-evento="">Modificar todos los eventos de la serie</button>
             -->
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
