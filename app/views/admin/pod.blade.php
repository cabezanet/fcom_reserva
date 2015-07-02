@extends('admin.layout')
 
@section('title')
    Admin:: carga P.O.D 
@stop
 
@section('content')
<div class="row">
  <div class="col-lg-12">
      <h3 class="page-header"><i class="fa fa-cogs fa-fw"></i> Gestión P.O.D</h3>
  </div>
</div> <!-- /.row -->

<div class="row">
    <div class="panel panel-info">
      
      <div class="panel-heading">
      <i class="fa fa-upload fa-fw"></i> Cargar P.O.D
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
        {{Form::open( array( 'url' => route('pod'), 'files' => true ) )}}
          
        
          

        <div class="form-group">
          {{Form::label('csvfile', 'Archivo csv:')}}
          {{Form::file('csvfile', $attributes = array());}}
        </div>
          
            
        <button type="submit" class="btn btn-primary">Cargar P.O.D</button>

      {{Form::close()}}
     
      @if (!empty($file))
        <hr />
        {{ $file }}
        <br />
        {{ $djson }}
      @endif
    </div>
  </div>
      
  </div>
  <!-- /.panel-body -->
 </div>
 <!-- /.panel-default -->
  
</div>
<!-- /.row -->
@stop