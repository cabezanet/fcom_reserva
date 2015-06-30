<?php

class cMail {

	
	private $actions =	array('Nueva reserva','Modificación de evento ','Eliminación de evento','Aprobar','Denegar','Nueva solicitud');

	/*
	Params:
		In -> 	
				$id_recurso -recurse for test if mailing-
				$currentAction -Action to test for mail-  //ver  app(conf/options.php)  - 'required_mail' => array('add','edit','del','allow','deny') -
				
		Out ->	$result -array asociativo- key = validador->email, value = true (si exito) / false (error)
	*/
	public static function sendMail($currentAction=0,$id_recurso='',$idSerie = ''){
		
		$result = array();
		$self = new self();
		$info = array('action' 		=> $self->actions[$currentAction],
					  'id_recurso'	=> $id_recurso,
					  'idSerie'		=> $idSerie,);

		//Si la "acción" requiere Mailing y existen validadores para ese recurso
		if ($self->requiredMail($currentAction) && $self->numValidadores($id_recurso) > 0) {
			
			//Se obtienen los valdadores con envio de mail activo
			$validadores = Recurso::find($id_recurso)->validadores()->where('mail', '=', true)->get();
			//Para cada validador
			foreach ($validadores as $validador) {
				//Exclude self user if validator (excluyendose a si mismo, si se da el caso)
				//if (Auth::user()->id != $validador->id){
					//se envía mail
					$result[$validador->email] = $self->send($validador,$info);					
				//}
			} //end foreach
			
		}
		
		return $result;
	}


	private function send($validador,$info){
		$result = true;

		
		$event = Evento::where('evento_id','=',$info['idSerie'])->first();
		
		setlocale(LC_ALL,'es_ES@euro','es_ES','esp');
		$strDayWeek = Date::getStrDayWeek($event->fechaEvento);
		$strDayWeekInicio = Date::getStrDayWeek($event->fechaInicio);
		$strDayWeekFin = Date::getStrDayWeek($event->fechaFin);
		$created_at = ucfirst(strftime('%A %d de %B  a las %H:%M:%S',strtotime($event->created_at)));
		$dateAction = ucfirst(strftime('%A %d de %B  a las %H:%M:%S',time()));
		//$recursos = Evento::where('evento_id','=',$info['idSerie'])->groupby('recurso_id')->get();
		$nombreRecurso = Recurso::find($info['id_recurso'])->nombre;
		//$nombreRecurso = 'Salón de actos';
		$user = Auth::user()->nombre . ' '. Auth::user()->apellidos;
		$ownEvent = $event->userOwn->nombre .' '. $event->userOwn->apellidos;
		$diasRepeticion = Date::DaysWeekToStr(json_decode($event->diasRepeticion));
		$data = array(	'action' 			=>	$info['action'],
						'titulo'			=>	$event->titulo,
						'evento_id'			=>	$event->evento_id,
						'ownEvent'			=> 	$ownEvent,
						'estado'			=>	$event->estado,
						'repeticion'		=>	$event->repeticion,
						'fechaEvento'		=>	$event->fechaEvento,
						'fechaInicio'		=>	$event->fechaInicio,
						'fechaFin'			=>	$event->fechaFin,
						'horaInicio'		=>	$event->horaInicio,
						'horaFin'			=>	$event->horaFin,
						'actividad'			=>	$event->actividad,
						'strDayWeek'		=>	$strDayWeek,
						'strDayWeekInicio'	=>	$strDayWeekInicio,
						'strDayWeekFin'		=>	$strDayWeekFin,
						'created_at'		=>	$created_at,
						'diasRepeticion'	=>	$diasRepeticion,
						'nombreRecurso'		=>	$nombreRecurso,
						'user'				=>	$user,
						'dateAction'		=> 	$dateAction,
						'event'				=>	$event,
						);

		
		Mail::queue(array('html' => 'emails.request'), $data, function($message) use ($validador)
						{
						$message->to($validador->email)->subject('Notificación automática: Sistema de reservas fcom');
						});
			 
				

		return $result;
	}

	

	private function requiredMail($currentAction = ''){
		$result = false;
		if (in_array($currentAction, Config::get('options.required_mail'))) $result = true; 
		return $result;
	}


	private function numValidadores($id_recurso = ''){
		$numberOfValidadores = 0;	
		//get number of validadores with mail active for this id_recurso
		
 		$validadores = Recurso::find($id_recurso)->validadores;
 	
 		if (count($validadores) > 0) { //si hay validadores;
			$numberOfvalidadores = Recurso::find($id_recurso)->validadores()->where('mail', '=', true)->count();
			
		}
		
		return $numberOfvalidadores;
	}

}

?>