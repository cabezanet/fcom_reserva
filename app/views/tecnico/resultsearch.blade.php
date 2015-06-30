@if ($events->count() > 0)
    @foreach ($events as $event)
        <div class="list-group">
            <a href="#" class="list-group-item">
                <i class="fa fa-info fa-fw"></i>
                    {{$event->recursoOwn->nombre}} - ({{strftime('%d/%m/%Y',Date::getTimeStampEN($event->fechaEvento))}}) - {{$event->horaInicio}} // {{$event->horaFin}} //{{$event->titulo}}
            </a>
            <a href="" class="btn btn-primary">Atender</a>
       </div>
     @endforeach
@else
	<div class="alert alert-warning" role="warning">No tenemos eventos para este usuario</div>
@endif
