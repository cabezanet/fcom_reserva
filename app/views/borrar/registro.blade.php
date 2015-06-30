@extends('layout')

@section('title')
    <title>Solicitud de registro sistema de reserva de espacios Fcom.</title>
@stop



@section('content')


 
  <div class="panel panel-info col-md-6 col-md-offset-3 well well-md" style="padding:0px;margin-top:10px">
      
    <div class="panel-heading">
      <h4><i class="fa fa-check-square-o fa-fw"></i> Solicitud de acceso sistema de reserva de espacios Fcom.</h4>
    </div>
      
    <div class="panel-body">
        
     
        
          {{Form::open(array('method' => 'POST','route' => 'saveRegistro.html','role' => 'form'))}}

           @if ($errors->has('username')) 
              <div class="form-group has-error">
            @else
             <div class="form-group">
            @endif
          
            
            {{Form::label('username', 'UVUS')}}  {{ $errors->first('username', '<span class="text-danger"><i class="fa fa-exclamation-circle fa-fw" aria-hidden="true"></i>:message</span>') }} 
            
              {{Form::text('username',Input::old('username'),array('class' => 'form-control','placeholder' => 'Usuario Virtual de la Universidad de Sevilla'))}}
          
             
          
            
          </div>

          @if ($errors->has('nombre')) 
              <div class="form-group has-error">
            @else
             <div class="form-group">
            @endif
            
            {{Form::label('nombre', 'Nombre')}} {{ $errors->first('nombre', '<span class="text-danger"><i class="fa fa-exclamation-circle fa-fw" aria-hidden="true"></i>:message</span>') }} 
            {{Form::text('nombre',Input::old('nombre'),array('class' => 'form-control'))}}
          </div>

          @if ($errors->has('apellidos')) 
              <div class="form-group has-error">
            @else
             <div class="form-group">
            @endif 
            
            {{Form::label('apellidos', 'Apellidos')}}  {{ $errors->first('apellidos', '<span class="text-danger"><i class="fa fa-exclamation-circle fa-fw" aria-hidden="true"></i>:message</span>') }} 
            {{Form::text('apellidos',Input::old('apellidos'),array('class' => 'form-control'))}}
          </div>
          
          @if ($errors->has('colectivo')) 
              <div class="form-group has-error">
            @else
             <div class="form-group">
            @endif
            {{Form::label('colectivo', 'Colectivo')}} {{ $errors->first('colectivo', '<span class="text-danger text-right"><i class="fa fa-exclamation-circle fa-fw" aria-hidden="true"></i>:message</span>') }}

            {{Form::select('colectivo', array('Alumno' => 'Alumno','PAS' => 'PAS','PDI' => 'PDI'),'Alumno',array('class' => 'form-control'))}}
          </div>

          <button type="submit" class="btn btn-primary pull-right" style="margin-top:20px">Registrar</button>
          {{Form::close()}}
      
      </div><!-- /.panel-body -->
      
      </div> <!-- /.panel-default -->

      
     



@stop