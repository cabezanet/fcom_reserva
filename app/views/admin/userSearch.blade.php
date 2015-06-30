@extends('admin.layout')
 
@section('title')
    Admin:: Buscar usuario 
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
      <i class="fa fa-search fa-fw"></i> Buscar
    </div>
      
    <div class="panel-body">
      {{Form::open(array('action' => 'UsersController@search'))}}
      
        <div class="form-group">
          <label for="uvus">UVUS:</label>
          <input type="text" class="form-control" id="uvus" placeholder="Introduzca UVUS" name="uvus" value="{{Input::old('uvus')}}">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fa fa-search fa-fw"></i> Buscar</button>            
      {{Form::close()}}
    </div> <!-- /.panel-body -->
  </div><!-- /.panel -->     
     
</div> <!-- /.row -->



<!-- list result search -->
<div class="row">
   
           
    <div class="panel panel-info">
      <div class="panel-heading">
          <i class="fa fa-list fa-fw"></i> Resultados de la busqueda
      </div><!-- /.panel-heading -->
      <div class="panel-body">
         @if ( Input::has('uvus') )
        
          @if ($users->count() > 0)
            @foreach($users as $user)
              <div class="list-group">
             
                
                <a href="{{route('useredit.html',array('id' => $user->id))}}" class="list-group-item"><i class="fa fa-edit fa-fw"></i>  {{$user->nombre.' '.$user->apellidos}}</a>
                
             
              </div>
            @endforeach
            {{$users->appends(Input::except('page','users'))->links();}}

          @else
            <div class="alert alert-warning" rol="alert">No se encontraron usuarios!</div>
          @endif

        @endif
    
    </div> <!-- /. panel-doby -->
  </div> <!-- ./ panel -->
</div> <!-- row -->    
@stop