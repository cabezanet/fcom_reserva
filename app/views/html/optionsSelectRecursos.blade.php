
@if ($all)
	<option  value="0" >Reservar todos</option>
@endif

@foreach($recursos as $recurso)

	<option value="{{$recurso->id}}">{{$recurso->nombre}}</option>
@endforeach