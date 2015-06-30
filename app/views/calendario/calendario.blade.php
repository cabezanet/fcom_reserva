@extends('calendario.layout')


@section('contenido')
<p>Vista hija principal</p>
	<p>Subvistas:</p>

	<div>{{$msg}}</div>
	
	<div id="loadCalendar">  
        <table class="pull-left" style = "table-layout: fixed;width: 100%;" id="tableCalendar" >
          <caption id="tableCaption">{{$titulo}}</caption>
          <thead id="tableHead">{{$cabecera}}</thead>
          <tbody id="tableBody">{{$cuerpo}}</tbody>
        </table>
      </div>
@endsection