@extends('admin.layout')
 
@section('title')
    Admin user:: Add user
@stop
 
@section('content')
<div class="col-lg-12">
    <h3 class="page-header">Gestión de Usuarios</h3>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      
      <div class="panel-heading">
       <h4><i class="fa fa-plus fa-fw"></i> Nuevo</h4>
      </div>
      
      <div class="panel-body">
        
        <div class="row">

          @if ($errors->any())
              <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                Por favor corrige los siguentes errores:
                <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
                </ul>
              </div>
          @endif
          @if (Session::has('message'))
              <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ Session::get('message') }}
              </div>
          @endif


          <div class="col-lg-12">
          {{Form::open(array('method' => 'POST','route' => 'post_addUser','role' => 'form'))}}
          <h4>Datos personales</h4>
          <hr />
          <div class="form-group">
            {{Form::label('tratamiento', 'Tratamiento')}}
            {{Form::text('tratamiento',Input::old('tratamiento'),array('class' => 'form-control'))}}
          </div>
          <div class="form-group">  
            {{Form::label('nombre', 'Nombre')}}
            {{Form::text('nombre',Input::old('nombre'),array('class' => 'form-control'))}}
          </div>
          <div class="form-group">  
            {{Form::label('apellidos', 'Apellidos')}}
            {{Form::text('apellidos',Input::old('apellidos'),array('class' => 'form-control'))}}
          </div>
          <div class="form-group">  
            {{Form::label('colectivo', 'Colectivo')}}
            {{Form::select('colectivo', array('Invitado' => 'Invitado', 'Alumno' => 'alumno','PAS' => 'PAS','PDI' => 'PDI'),'Invitado',array('class' => 'form-control'))}}
          </div>
          <div class="form-group">  
            {{Form::label('email', 'eMail')}}
            {{Form::text('email',Input::old('email'),array('class' => 'form-control'))}}
          </div>
          <div class="form-group">  
            {{Form::label('telefono', 'Teléfono')}}
            {{Form::text('telefono',Input::old('telefono'),array('class' => 'form-control'))}}
          </div>
          
          <h4>Cuenta de usuario</h4>
          <hr />
          <div class="form-group">  
            {{Form::label('username', 'UVUS')}}
            {{Form::text('username',Input::old('username'),array('class' => 'form-control'))}}
          </div>
          <!-- 
          <div class="form-group"> 
            {{Form::label('contraseña', 'Password')}}
            {{Form::password('password',array('class' => 'form-control'))}}
          </div>
          <div class="form-group">   
            {{Form::label('confirmaContraseña', 'Confirmar password')}} {{Form::password('password_confirmation',array('class' => 'form-control'))}}
          </div>
          -->
          <div class="form-group">     
            {{Form::label('capacidad', 'Rol')}}
            {{Form::select('capacidad', array('1' => 'Usuario', '2' => 'Usuario Avanzado','3' => 'tecnico','4' => 'Administrador', '5' => 'Validador'),'Invitado',array('class' => 'form-control'));}}
          </div>
          <div class="form-group">   
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
  <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
@stop