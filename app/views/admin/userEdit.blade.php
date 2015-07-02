@extends('admin.layout')
 
@section('title')
    Admin:: edición de usuario 
@stop
 
@section('content')
<div class="row">
  <div class="col-lg-12">
      <h3 class="page-header"><i class="fa fa-user fa-fw"></i> Gestión de Usuarios</h3>
  </div>
</div> <!-- /.row -->

<div class="row">
    <div class="panel panel-info">
      
      <div class="panel-heading">
      <i class="fa fa-pencil fa-fw"></i> Edición
      </div>
      
      <div class="panel-body">
      @if ($errors->any())
        <div class='alert alert-danger' rol='alert'>
          <strong>Formulario con errores:</strong>
        </div>
    @endif

    @if (Session::has('message'))
    
        <div class='alert alert-success' rol='alert'>{{ Session::get('message') }}</div>
    
    @endif
    

    <div class="row">



      <div class="col-lg-12">
        {{Form::model($user, array('method' => 'POST','route' => array('updateUser.html', $user->id)))}}
        <h4>Datos personales</h4>
        <hr />
          
        <div class="form-group hidden">
          {{Form::text('id',Input::old('id'),array('class' => 'form-control'))}}
        </div>
          

        <div class="form-group">
          {{Form::label('tratamiento', 'Tratamiento')}}
          {{Form::text('tratamiento',Input::old('tratamiento'),array('class' => 'form-control'))}}
        </div>
          
        <div class="form-group"> 
          {{ $errors->first('nombre', '<span class="text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>:message</span>') }}
          {{Form::label('nombre', 'Nombre')}}
          {{Form::text('nombre',Input::old('nombre'),array('class' => 'form-control'))}}
        </div>
          
        <div class="form-group">  
          {{ $errors->first('apellidos', '<span class="text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>:message</span>') }}
          {{Form::label('apellidos', 'Apellidos')}}
          {{Form::text('apellidos',Input::old('apellidos'),array('class' => 'form-control'))}}
        </div>

        <div class="form-group">  
          {{ $errors->first('dni', '<span class="text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>:message</span>') }}
          {{Form::label('dni', 'DNI')}}
          {{Form::text('dni',Input::old('dni'),array('class' => 'form-control','palceholder' => '(DNI con letra y sin guión)'))}}
        </div>

        <div class="form-group">
          {{ $errors->first('colectivo', '<span class="text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>:message</span>') }}  
          {{Form::label('colectivo', 'Colectivo')}}
          {{Form::select('colectivo', array('Alumno' => 'Alumno','PAS' => 'PAS','PDI' => 'PDI'),null,array('class' => 'form-control'))}}
        </div>

        <div class="form-group">  
          {{ $errors->first('email', '<span class="text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>:message</span>') }}
          {{Form::label('email', 'eMail')}}
          {{Form::text('email',Input::old('email'),array('class' => 'form-control'))}}
        </div>

        <div class="form-group"> 
          {{ $errors->first('telefono', '<span class="text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>:message</span>') }} 
          {{Form::label('telefono', 'Teléfono')}}
          {{Form::text('telefono',Input::old('telefono'),array('class' => 'form-control'))}}
        </div>
          
        <h4>Cuenta de usuario</h4>
        <hr />

        <div class="form-group">
          {{ $errors->first('estado', '<span class="text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>:message</span>') }}  
          {{Form::label('estado', 'Estado')}}
          {{Form::select('estado', array('1' => 'Activa','0' => 'Desactiva'),null,array('class' => 'form-control'))}}
        </div>
        <!-- 
        <div class="form-group"> 
          {{ $errors->first('password', '<span class="text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>:message</span>') }}
          {{Form::label('contraseña', 'Password')}}
          {{Form::password('password',array('class' => 'form-control','placeholder' => '(sin modificar)'))}}
        </div>
      
        <div class="form-group">   
          {{Form::label('confirmaContraseña', 'Confirmar password')}} {{Form::password('password_confirmation',array('class' => 'form-control','placeholder' => '(sin modificar)'))}}
        </div>
        -->

        <div class="form-group">     
          {{ $errors->first('capacidad', '<span class="text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>:message</span>') }}
          {{Form::label('capacidad', 'Rol')}}
          {{Form::select('capacidad', array('1' => 'Usuario','2' => 'Usuario Avanzado','3' => 'Técnico','4' => 'Administrador','5' => 'Validador'),null,array('class' => 'form-control'));}}<br />
        </div>

        <div class="form-group">   
          {{ $errors->first('caducidad', '<span class="text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>:message</span>') }}
          {{Form::label('caducidad', 'valido hasta')}}
          {{Form::text('caducidad',date('d-m-Y',strtotime('+4 year')),array('class' => 'form-control'))}}
        </div>
            
        <button type="submit" class="btn btn-primary">Salvar</button>

      {{Form::close()}}
    </div>
  </div>
      
  </div>
  <!-- /.panel-body -->
 </div>
 <!-- /.panel-default -->
  
</div>
<!-- /.row -->
@stop