@extends('layout')

@section('head')
<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
<style>
  
    #font-lato {
        text-align: center;
        vertical-align: middle;
        font-weight: 100;
        font-family: 'Lato';
        font-size:56px;
        font-style: italic;
        color: #B0BEC5;
    }

</style>
@stop

@section('title')
    <title>Identificación</title>
@stop



@section('content')

     <div class="col-md-12 col-sx-12" style="padding-top:10%;margin-top:40px;height:50%">
        
       
      
      
        <p id = "font-lato">Aplicación de reservas<br /> Facultad de Comunicación</p>
        <div class="col-md-12 col-sx-12 text-center" style = "">
            <a href="{{route('loginsso')}}" class="btn btn-primary" style="margin-top:10px;width:30%;">Login</a>
        </div>
        
     

      </div>
    

@stop 