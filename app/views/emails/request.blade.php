<style>

* {
	font-family:verdana;
	font-size: 12px; 
}

div{
	border-top:none;
	border-bottom: 1px solid #333;
	border-top: 1px solid #333;
	margin-top:20px;
}

#title {
	font-size: 14px;
}

.subtitle{
	font-style: italic;
}

span {
	color:blue;
}

p.label{text-align:right;font-size:12px}

table {
	margin-top:10px;
	padding:20px;
	width: 100%;

}
 td {
 	border:1px solid #aaa;
 }
#first{
	background-color: #aaa;
}
#estado {
	boder:1px solid green;
}
</style>
<h2>Notificación automática: Sistema de	reservas fcom</h2>
<h3>{{$action}} en {{$nombreRecurso}}</h3>
<h4><strong>Datos de la reserva</strong></h4>
<div style = "border-top:1px solid #666"> 
<ul style ="list-style:none;padding:5px">
	<li id = 'title'><strong>Título:</strong> <span>{{htmlentities($titulo)}}</span></li>
	<li class = 'subtitle'><strong>Código:</strong> <span>{{$evento_id}}</span></li>
	<li class = 'subtitle'><strong>Registrada por:</strong> <span>{{$ownEvent}}</span></li>
	<li class = 'subtitle'><strong>Fecha de registro:</strong> <span>{{$created_at}}</span></li>
	<li class = 'first'><strong>Estado de la reserva:</strong> {{$estado}}</li>		
	
@if($repeticion == 0)
	<li class = 'first'><strong>Tipo de Evento:</strong> Puntual</li>
	<li class = 'first'><strong>Fecha del evento:</strong> {{$strDayWeek;}}, {{date('d-m-Y',strtotime($fechaEvento))}}</li>
	<li class = 'first'><strong>Horario:</strong> {{'Desde las ' .date('G:i',strtotime($horaInicio)). ' hasta las '. date('G:i',strtotime($horaFin))}}</li>
	<li class = 'first'><strong>Actividad:</strong> {{$actividad}}</li>
@else
	<li class="label"><strong>Tipo de Evento:</strong> Periódico</li>
	<li class="label"><strong>Fecha de inicio:</strong> {{$strDayWeekInicio}}, {{date('d-m-Y',strtotime($fechaInicio))}}</li>
	<li class="label"><strong>Fecha de finalización:</strong> {{$strDayWeekFin}}, {{date('d-m-Y',strtotime($fechaFin))}}</li>
	<li class="label"><strong>Horario:</strong> {{'Desde las ' .date('G:i',strtotime($horaInicio)). ' hasta las '. date('G:i',strtotime($horaFin)) }}</li>
	<li class="label"><strong>Todos los:</strong> {{$diasRepeticion}}</li>		
@endif
</ul>	

</div>