<?php

class CalendarController extends BaseController {
	
	//ajax function 
	/*public function superaMaximoHoras(){
		
		$supera = false;

		$supera = sgrValidaRegla::superaMaximoHoras(Auth::user());

		return $supera;

	}*/

	//Se carga la vista por defecto: Mensual
	public function showCalendarViewMonth(){
		
		$input = Input::all();
		$msg = '';	

		//Los usuarios del rol "alumnos" sólo pueden reservar 12 horas a la semana como máximo
		if ( sgrValidaRegla::superaMaximoHoras(Auth::user()) ){
			$msg = sgrMsgError::getErrorSuperahoras();
		}
		
		//
		//horas reservadas por el usuario
		$tsLunes = sgrFechas::getLunes(time());
		$tsDomingo = sgrFechas::getDomingo(time());
		$nh = Auth::user()->getHorasReservadas($tsLunes,$tsDomingo);

				
		if(empty($input)){
			//ACL::fristMonday() -> devuelve el timestamp del primer lunes disponible para reserva
			
			$datefirstmonday = getdate(ACL::fristMonday());
			$numMonth = $datefirstmonday['mon'];//Representación númerica del mes del 1 al 12
			$year = $datefirstmonday['year']; //Representación numérica del año cuatro dígitos
			$nameMonth = Date::getNameMonth($numMonth,$year); //representación textual del mes (enero,febrero.... etc)
			$day = $datefirstmonday['mday']; //Representación númerica del dia del mes: 1 - 31	
		} 
		//else -> los métodos getCaption, getHead y getBodytableMonth optiene los valores de fecha directamente desde el array de entrada post.
		
		$viewActive = 'month'; //vista por defecto
		$tCaption = Calendar::getCaption($day,$numMonth,$year);
		$tHead = Calendar::gettHead($viewActive,$day,$numMonth,$year);
		$tBody = Calendar::getBodytableMonth($numMonth,$year);
		
		//Se obtinen todos los grupos de recursos
		$grupos = DB::table('recursos')->select('id', 'acl', 'grupo','grupo_id')->groupby('grupo')->get();
		
		//se filtran para obtener sólo aquellos con acceso para el usuario logeado
		$groupWithAccess = array();
		foreach ($grupos as $grupo) {
			if (ACL::canReservation($grupo->id,$grupo->acl))
				$groupWithAccess[] = $grupo;
		}
				
		//se devuelve la vista calendario.
		return View::make('Calendarios')->with('grupos',$groupWithAccess)->with('day',$day)->with('numMonth',$numMonth)->with('year',$year)->with('tCaption',$tCaption)->with('tHead',$tHead)->with('tBody',$tBody)->with('msg',$msg)->with('nh',$nh);
	}
	
	/**
	*	
	*	@param $mes (integer)
	*	@param $anno (integer)
	*
	* 	@return $calendario Objeto SgrCalendario
	*/
	private function generaCalendario($mes='1',$anno='1970'){

		$calendario = new sgrCalendario($mes,$anno);
				
		$diaSemanaPrimerDiaMes 	= $calendario->diaSemanaPrimerDia;
		$ultimoDiaMes 			= $calendario->ultimoDia;
		$diaSemanaUltimoDiaMes 	= $calendario->diaSemanaUltimoDia;
		$numeroSemanasMes 		= $calendario->numeroSemanas;	
		$semana=0;
		$diasemana=1;
		$diames=1;
	
		//primeros días de la semana que no son del mes/anno
		while($diasemana < $diaSemanaPrimerDiaMes) {
			$diasemana++;
		}
	
		//siguientes días de la primera semana que son del mes/ann y semanas completas
		while($semana<$numeroSemanasMes){
				
			//nueva semana
			if($diasemana > 7){
				$diasemana = 1;				
				$semana++;	
			}

			//añade día al calendario
			$tsfecha = strtotime($anno.'-'.$mes.'-'.$diames);
			$cadenaFecha = date('Y-m-d',$tsfecha);
			$eventos = Evento::where('fechaEvento','=',$cadenaFecha)->get();
			$calendario->addDia($tsfecha, new sgrDia($tsfecha,$eventos));
				
			$diasemana++;
			$diames++;
		}
	
		//ultima semana
		if($semana == $numeroSemanasMes){
			while($diasemana <= 7){
				if($diames <= $ultimoDiaMes ){
					//añade día al calendario	
					$tsfecha = strtotime($anno.'-'.$mes.'-'.$diames);
					$cadenaFecha = date('Y-m-d',$tsfecha);
					$eventos = Evento::where('fechaEvento','=',$cadenaFecha)->get();
					$calendario->addDia($tsfecha,new sgrDia($tsfecha,$eventos));
					$diames++;
				} 
						
			$diasemana++;
			}
		}
	
		return $calendario;
	}//fin generaCalendario

	/**
	*	//candidata a sustituir a showCalendarViewMonth
	*
	*/
	public function calendario(){
		
		//valores por defecto
		$msg = '';
		$user = User::find('29');//Auth::user();
		$fecha = sgrFechas::getLocale(time(),'%A, %d de %B de %Y');
		$vista = sgrOption::defaultVistaCalendario();//$input['viewActive'](mes,semana,dia....)
		//fin valores por defecto


		//vista padre
		$view = View::make('calendario.calendario');

		//Los usuarios del rol "alumnos" sólo pueden reservar 12 horas a la semana como máximo
		if ( sgrValidaRegla::superaMaximoHoras($user) ){
			$msg = sgrMsgError::getErrorSuperahoras();
			$view->nest('msg','calendario.msgDanger',array('msg'=>$msg));//añadir msg de error a la vista	
		}
		
		

		$view->nest('titulo','calendario.titulo',array('fecha'=>$fecha));

		switch ($vista) {
			
			case 'month':
				$view->nest('cabecera','calendario.cabeceraMes');
				$calendario = $this->generaCalendario('6','2015');
				$view->nest('cuerpo','calendario.cuerpoMes',array('calendario' => $calendario));
				break;
			case 'week':
				//$view->nest('cabecera','calendario.cabeceraSemana');
				//$view->nest('cuerpo','calendario.cuerpoSemana');
				break;
			
			case 'agenda':
				//$view->nest('cabecera','calendario.cabeceraAgenda');
				//$view->nest('cuerpo','calendario.cuerpoAgenda');
				break;
			
			case 'day':
				//$table['tBody'] = '<p>Aún en desarrollo.....</p>';	
				break;
			case 'year':
				//$table['tBody'] = '<p>Aún en desarrollo....</p>';
				break;
			default:
				//$table['tBody'] = 'Error al generar vista...';
				break;
		}
		
												
		return $view;
	}


	public function getTablebyajax(){
	
		$input = Input::all();
		
		$table = array( 'tHead' => '',
						'tBody' => '');
		
       	//$input['month'],$input['year'],$input['viewActive']
		switch ($input['viewActive']) {
			case 'year':
				$table['tBody'] = '<p>Aún en desarrollo....</p>';
				break;
			case 'month':
				$table['tCaption'] = Calendar::getCaption($input['day'],$input['month'],$input['year']);
				$table['tHead'] = Calendar::gettHead('month',$input['day'],$input['month'],$input['year']);
				$table['tBody'] = Calendar::getBodytableMonth($input['month'],$input['year'],$input['id_recurso']);	
				break;
			case 'week':
				$table['tCaption'] = Calendar::getCaption($input['day'],$input['month'],$input['year']);
			  	$table['tHead'] = Calendar::gettHead('week',$input['day'],$input['month'],$input['year']);
				$table['tBody']= Calendar::getBodytableWeek($input['day'],$input['month'],$input['year'],$input['id_recurso']);
				break;
			case 'day':
				$table['tBody'] = '<p>Aún en desarrollo.....</p>';	
				break;
			case 'agenda':
				$table['tCaption'] = Calendar::getCaption($input['day'],$input['month'],$input['year']);
				//$table['tHead'] = Calendar::gettHead('agenda',$input['day'],$input['month'],$input['year']);
				$table['tBody'] = Calendar::getBodytableAgenda($input['day'],$input['month'],$input['year']);
				break;
			default:
				$table['tBody'] = 'Error al generar vista...';
				break;
		}
	    return $table;
	}


	//Ajax function (refactorizada)
	public function getRecursosByAjax(){
		
		$recursos = array();
		$all = false;

		//Colección de rescursos a mostrar
		$grupo = GrupoRecurso::find(Input::get('groupID'));
		$recursos = $grupo->recursos;
		
		//El usuario autenticado puede reservar todos los equipos o puestos??
		
		$all = sgrValidaPermiso::reservaMultiple(Auth::user(),$grupo);


		return View::make('html.optionsSelectRecursos')->with(compact('recursos','all'));
	}
	
	//Buscar eventos por dni
	public function search(){

		$dni = Input::get('dni','');
		//Input::flash();
		
		$user = User::where('dni','=',$dni)->first();
		
	
		$today = date('Y-m-d');

		
		
		//return View::make('tecnico.index',compact('events'));
		if (empty($user)) $events = array();
		else {
		
			$events = Evento::where('user_id','=',$user->id)->where('fechaFin','>=',$today)->groupby('evento_id')->orderby('recurso_id','asc')->orderby('fechaEvento','asc')->get();
		}
		//return View::make('tecnico.index',compact('events','dni'));
		return View::make('tecnico.resultsearch',compact('events','dni'));
		
		
	}

	//Datos de un evento para un validador
	public function ajaxDataEvent(){

		$respuesta = array();
		$diasSemana = array('1'=>'lunes','2'=>'martes','3'=>'miércoles','4'=>'jueves','5'=>'viernes','6'=>'sabado','7'=>'domingo');

		$evento = Evento::where('id','=',Input::get('id'))->groupby('evento_id')->get();
		
		$respuesta['fPeticion'] = date('d \d\e M \d\e Y \a \l\a\s H:i',strtotime($evento[0]->created_at));
		$respuesta['solapamientos'] = false;
		$respuesta['estado'] = 'Pendiente de validar sin solapamientos';
		if (Calendar::hasSolapamientos($evento[0]->evento_id,$evento[0]->recurso_id)){
			$respuesta['solapamientos'] = true;
			$respuesta['estado'] = 'Pendiente de validar con solapamientos';
		}	
		$respuesta['titulo'] = $evento[0]->titulo;
		$respuesta['actividad'] = $evento[0]->actividad;
		$respuesta['usuario'] = $evento[0]->userOwn->nombre .', ' . $evento[0]->userOwn->apellidos;
		$respuesta['espacio'] = $evento[0]->recursoOwn->nombre;
		setlocale(LC_ALL,'es_ES@euro','es_ES','esp');
		$respuesta['fInicio'] = ucfirst(strftime('%A, %d de %B de %Y',strtotime($evento[0]->fechaInicio)));
		$respuesta['fFin'] = ucfirst(strftime('%A, %d de %B de %Y',strtotime($evento[0]->fechaFin)));
		$respuesta['horario'] = date('g:i',strtotime($evento[0]->horaInicio)) .'-' .date('g:i',strtotime($evento[0]->horaFin));
		
		$dias = explode(',',str_replace(array('[',']','"'), '' , $evento[0]->diasRepeticion));
		$str = '';
		$cont = 0;
		for($j = 0;$j < count($dias) - 1;$j++){
			if (count($dias) == 2)
			$str .= $diasSemana[$dias[$j]] . ' y ';
			else
			$str .= $diasSemana[$dias[$j]] . ', ';
			$cont++;
		}
		$str .= $diasSemana[$dias[$cont]];
		$respuesta['dSemana'] = $str; 
		$respuesta['evento_id'] = $evento[0]->evento_id;
		$respuesta['id_recurso'] = $evento[0]->recurso_id;
		$respuesta['user_id']	= $evento[0]->user_id;

		return $respuesta;
	}	


	//Ajax functions
	

	public function geteventbyajax(){

		//$evento_id = Input::get('evento_id');
		$eventos = Evento::where('evento_id','=',Input::get('evento_id'))->get();
		return $eventos;
	}

	public function getajaxeventbyId(){
		//$evento_id = Input::get('evento_id');
		$event = Evento::where('id','=',Input::get('id'))->get();
		return $event;
	}
	
	//funcitons para eliminar eventos de la BD
	//del
	public function delEventbyajax(){

		$result = '';

		//Eliminación de eventos
		$result = $this->delEvents();

		//Envio de avisos por correo 
		/*
		$eventToDel = Evento::find(Input::get('idEvento'))->first();
		$actions = Config::get('options.required_mail');
		cMail::sendMail($actions['del'],$eventToDel->recursoOwn->id,$eventToDel->evento_id);
		$this->mailing('DELRESERVA',)
		*/

		return $result;
	} 
	
	private function delEvents(){
		$result = '';
		
		$event = Evento::find(Input::get('idEvento'));
		if (Input::get('id_recurso') == 0){
			//Todos los puestos
			Evento::where('evento_id','=',Input::get('idSerie'))->delete();
		}
		else {
			//Un puesto, espacio (no divisible) o medio
			Evento::where('evento_id','=',Input::get('idSerie'))->where('recurso_id','=',Input::get('id_recurso'))->delete();
		}
		
		
		return $result;
		
	}

	//functions para salvar añadir eventos a la DB
	//Save
	public function eventsavebyajax(){

		$result = array('error' => false,
						'ids' => array(),
						'idsSolapamientos' => array(),
						'msgErrors' => array(),
						'msgSuccess' => '',
						);
		
		//checkeo de errores en el formulario
		$testDataForm = new Evento();
		if(!$testDataForm->validate(Input::all())){
			$result['error'] = true;
			$result['msgErrors'] = $testDataForm->errors();
			return $result;
		}
		
		//Si no hay errores
		//Salvar eventos
		$result['idEvents'] = $this->saveEvents(Input::all());
			
		//Enviar avisos vía mail
		$this->mailing('ADDRESERVA',Input::get('id_recurso'),Input::get('grupo_id'));
			
		//generar mensaje para el usuario
		$result['msgSuccess'] = $this->msg($result['idEvents']);
			
		return $result;
	}

	/**
	* generar la serie de eventos (si el caso) y asociar un identificador único
	*/
	private function saveEvents($data){
		
		$dias = $data['dias']; //1->lunes...., 5->viernes
		$respuesta = array();
		$evento_id = $this->getIdUnique();
	
		foreach ($dias as $dWeek) {
			if ($data['repetir'] == 'SR') $nRepeticiones = 1;
			else $nRepeticiones = Date::numRepeticiones($data['fInicio'],$data['fFin'],$dWeek);
			for($j=0;$j<$nRepeticiones;$j++){
				$startDate = Date::timeStamp_fristDayNextToDate($data['fInicio'],$dWeek);
				$currentfecha = Date::currentFecha($startDate,$j);
				$respuesta[] = $this->saveEvent($data,$currentfecha,$evento_id);
			}
		}
		return $evento_id;
		
	}

	//Añade a la BD cada uno de los eventos de una serie 
	private function saveEvent($data,$currentfecha,$evento_id){

		//Si se reserva todos los puestos o equipos
		$result = false;
		if ($data['id_recurso'] == 0){
			$recursos = Recurso::where('grupo_id','=',$data['grupo_id'])->get();
			foreach($recursos as $recurso){
				$id_recurso = $recurso->id;
				$result =  $this->saveDB($data,$currentfecha,$evento_id,$id_recurso);
			}
			return $result;
		}
		
		return $this->saveDB($data,$currentfecha,$evento_id,$data['id_recurso']);	
		
		
	}

	private function saveDB($data,$currentfecha,$evento_id,$id_recurso){
		
		$result = 0;
		$evento = new Evento();
			
		//obtener estado (pendiente|aprobada)
		$hInicio = date('H:i:s',strtotime($data['hInicio']));
		$hFin = date('H:i:s',strtotime($data['hFin']));
		$evento->estado = $this->setEstado($id_recurso,$currentfecha,$hInicio,$hFin);
			
		$repeticion = 1;
		$evento->fechaFin = Date::toDB($data['fFin'],'-');
		$evento->fechaInicio = Date::toDB($data['fInicio'],'-');
		$evento->diasRepeticion = json_encode($data['dias']);
			
		if ($data['repetir'] == 'SR') {
			$repeticion = 0;
			$evento->fechaFin = Date::toDB($currentfecha,'-');
			$evento->fechaInicio = Date::toDB($currentfecha,'-');
			$evento->diasRepeticion = json_encode(array(date('N',Date::getTimeStamp($currentfecha))));
			}
			
		$evento->evento_id = $evento_id;
		$evento->titulo = $data['titulo'];
		$evento->actividad = $data['actividad'];
		$evento->recurso_id = $id_recurso;
		$evento->fechaEvento = Date::toDB($currentfecha,'-');
		$evento->repeticion = $repeticion;
		$evento->dia = date('N',Date::getTimeStamp($currentfecha));
		$evento->user_id = Auth::user()->id;
		$evento->horaInicio = $data['hInicio'];
		$evento->horaFin = $data['hFin'];
	
		if ($evento->save()) $result = $evento->id;
		
		return $result;
	}

	//Edit
	public function editEventbyajax(){

		$result = array('error' => false,
						'msgSuccess' => '',
						'idsDeleted' => array(),
						'msgErrors' => array());
		//Controlar errores en el formulario
		$testDataForm = new Evento();
		if(!$testDataForm->validate(Input::all())){
				$result['error'] = true;
				$result['msgErrors'] = $testDataForm->errors();
			}
		//Si no hay errores
		else{
			
			//si el usuario es alumno: comprobamos req2 (MAX HORAS = 12 a la semana en cualquier espacio o medio )	
			if (ACL::isUser() && $this->superaHoras()){
				$result['error'] = true;
				$error = array('hFin' =>'Se supera el máximo de horas a la semana.. (12h)');	
				$result['msgErrors'] = $error;	
			}
			else {
				
				$idSerie = Input::get('idSerie');

				
				$fechaInicio = Input::get('fInicio');
				$fechaFin = Input::get('fFin');
				//$result['idsDeleted'] = $this->delEvents();
				//Del todos los eventos a modificar
				$event = Evento::find(Input::get('idEvento'));
				if (Input::get('id_recurso') == 0){
					Evento::where('evento_id','=',Input::get('idSerie'))->delete();
				}
				else {
					Evento::where('evento_id','=',Input::get('idSerie'))->where('recurso_id','=',Input::get('id_recurso'))->delete();
				}
				//Añadir los nuevos
				$result['idEvents'] = $this->editEvents($fechaInicio,$fechaFin,$idSerie);

				//Msg confirmación al usuario
				$result['msgSuccess'] = $this->msg($idSerie);
				
				//Envio de aviso por mail
				$this->mailing('EDITRESERVA',Input::get('id_recurso'),Input::get('grupo_id'));
				

			} //fin else	
		}
		
		return $result;			
	} 
		
	private function editEvents($fechaInicio,$fechaFin,$idSerie){
		
		$result = '';
		
		$repetir = Input::get('repetir');	
		$dias = Input::get('dias'); //1->lunes...., 5->viernes
		if ($repetir == 'SR') { //SR == sin repetición (no periódico)
			$dias = array(Date::getDayWeek($fechaInicio));
			$fechaFin = $fechaInicio;
		}
							
		foreach ($dias as $dWeek) {
							
			if (Input::get('repetir') == 'SR') $nRepeticiones = 1;
			else { $nRepeticiones = Date::numRepeticiones($fechaInicio,$fechaFin,$dWeek);}
							
			for($j=0;$j<$nRepeticiones;$j++){
				$startDate = Date::timeStamp_fristDayNextToDate($fechaInicio,$dWeek);
				$currentfecha = Date::currentFecha($startDate,$j);
				$result = $this->saveEvent(Input::all(),$currentfecha,$idSerie);
			}
						
		}				

		
		return $result;
	}

	//Auxiliares

	private function msg($idEvento){
		
		$event = Evento::Where('evento_id','=',$idEvento)->first();
		$estado = $event->estado;
		switch ($estado) {
				case 'aprobada':
					$msg = '<strong class="alert alert-info" > Reserva registrada con éxito. Puede <a target="_blank" href="'. route('justificante',array('idEventos' => $idEvento)) .'">imprimir comprobante</a> de la misma si lo desea.</strong>';
					break;
				case 'pendiente':
					$msg = '<strong class="alert alert-danger" >Reserva pendiente de validación. Puede <a target="_blank" href="' . route('justificante',array('idEventos' => $idEvento)) . '">imprimir comprobante</a> de la misma si lo desea.</strong>';
					break;
				default:
					$msg = '<strong class="alert alert-danger" >Algo ha ido mal :( ....</strong>';
					break;
			}	
		return $msg;
	}

	private function mailing($action,$idRecurso,$idGrupo){

		//Si reservamos todos los puestos o equipos => $idRecurso == 0
		if ($idRecurso != 0) $recurso = Recurso::find($idRecurso);
		else {
			$recurso = Recurso::where('grupo_id','=',$idGrupo)->first();
			
		}
		foreach ($recurso->supervisores as $supervisor) {
				
			$actionsWithMailRequired = json_decode($supervisor->pivot->requireMail,true);
				
			if (in_array($action,$actionsWithMailRequired))
				sgrMail::send($supervisor->email,'Nueva reserva en ....','emails.addreserva');
				
			} //fin foreach
		
		return true;
	}

	private function superaHoras(){
		
		$supera = false;

		//Número de horas ya reservadas en global
		$nh = ACL::numHorasReservadas();
		
		//número de horas del evento a modificar (hay que restarlas de $nh)
		$event = Evento::find(Input::get('idEvento'));
		$nhcurrentEvent = Date::diffHours($event->horaInicio,$event->horaFin);
		
		//Actualiza el valor de horas ya reservadas quitando las del evento que se modifica
		$nh = $nh - $nhcurrentEvent;

		//Estas son las horas que se quieren reservar 
		$nhnewEvent = Date::diffHours(Input::get('hInicio'),Input::get('hFin'));
		
		//máximo de horas a la semana	
		$maximo = Config::get('options.max_horas');

		//credito = máximo (12) menos horas ya reservadas (nh)
		$credito = $maximo - $nh; //número de horas que aún puede el alumno reservar
		if ($credito < $nhnewEvent) $supera = true;
		//$supera = 'nh='.$nh.',$nhnewEvent='.$nhnewEvent.',nhcurrentEvent='.$nhcurrentEvent;
		return $supera;
	}

	private function uniqueId(){
		
		$idSerie = $this->getIdUnique();
		return $idSerie;
	}

	private function getIdUnique(){
		do {
			$evento_id = md5(microtime());
		} while (Evento::where('evento_id','=',$evento_id)->count() > 0);
		
		return $evento_id;
	}


	private function updateDias($oldIdSerie = '',$newIdSerie = ''){
		
		//$oldIdSerie = Input::get('idSerie');
		if (!empty($oldIdSerie)){//isset(Input::get('idSerie'))){
		 	
			$events = Evento::select('dia')->where('evento_id','=',$oldIdSerie)->groupby('dia')->get();
			if(count($events) > 0){
				foreach ($events as $event)	$aDias[] = $event->dia;
				Evento::where('evento_id','=',$oldIdSerie)->update(array('diasRepeticion' => json_encode($aDias)));
			}
		}

		if (!empty($newIdSerie)){
			$events = Evento::select('dia')->where('evento_id','=',$newIdSerie)->groupby('dia')->get();
			foreach ($events as $event)	$aDias2[] = $event->dia;
			Evento::where('evento_id','=',$newIdSerie)->update(array('diasRepeticion' => json_encode($aDias2)));
		}
	}

	private function updatePeriocidad($newIdSerie = '',$oldIdSerie = ''){
		
		
		if (!empty($oldIdSerie)){
			$oldIdSerie = Input::get('idSerie');
			$numEvents = Evento::where('evento_id','=',$oldIdSerie)->count();
			if ($numEvents == 1) Evento::where('evento_id','=',$oldIdSerie)->update(array('repeticion' => 0));
		}
		
		if(!empty($newIdSerie)){
			$numEvents = Evento::where('evento_id','=',$newIdSerie)->count();
			if ($numEvents == 1) Evento::where('evento_id','=',$newIdSerie)->update(array('repeticion' => 0));
		}
	}

	private function updateFInicio($newIdSerie = '',$oldIdSerie = ''){
		
		if (!empty($oldIdSerie)){
			$fechaPrimerEvento = Evento::where('evento_id','=',$oldIdSerie)->min('fechaEvento');
			if (!empty($fechaPrimerEvento)){
				Evento::where('evento_id','=',$oldIdSerie)->update(array('fechaInicio' => $fechaPrimerEvento));
			}
		}
			
		if (!empty($newIdSerie)){
			$fechaPrimerEvento = Evento::where('evento_id','=',$newIdSerie)->min('fechaEvento');
			if (!empty($fechaPrimerEvento)){
				Evento::where('evento_id','=',$newIdSerie)->update(array('fechaInicio' => $fechaPrimerEvento));
			}
		}
	}

	private function updateFfin($newIdSerie = '',$oldIdSerie = ''){
		
		if (!empty($oldIdSerie)){
			$fechaUltimoEvento = Evento::where('evento_id','=',$oldIdSerie)->max('fechaEvento');
			if (!empty($fechaUltimoEvento)){
				Evento::where('evento_id','=',$oldIdSerie)->update(array('fechaFin' => $fechaUltimoEvento));
			}
		}
		
		if (!empty($newIdSerie)){
			$fechaUltimoEvento = Evento::where('evento_id','=',$newIdSerie)->max('fechaEvento');
			if (!empty($fechaUltimoEvento)){
				Evento::where('evento_id','=',$newIdSerie)->update(array('fechaFin' => $fechaUltimoEvento));
			}
		}

	}
	private function setEstado($idRecurso,$currentfecha,$hi,$hf){
		$estado = 'denegada';

		
		//si modo automatico	
		if(ACL::automaticAuthorization($idRecurso)){
			//Ocupado??; -> Solo busco solapamientos con solicitudes ya aprobadas
			$condicionEstado = 'aprobada';
			//$currentFecha tiene formato d-m-Y
			$numEvents = Calendar::getNumSolapamientos($idRecurso,$currentfecha,$hi,$hf,$condicionEstado);
	
			//si ocupado
			if($numEvents > 0){
				//si ocupado
				$estado = 'denegada';
				//$msg = 'su reserva no se puede realizar, existen solapamientos con otras reservas ya aprobadas (ver detalles)';
			}
			//si libre
			else{
				$estado = 'aprobada';
				//$msg = 'Su reserva se realizado con éxito. (imprimir justificacante)'
			}

		}
		//si modo no automático (necesita validación)
		else{
			//ocupado??; estado = aprobado | pendiente | solapada (cualquiera de los posibles)
			$condicionEstado = '';
			$numEvents = Calendar::getNumSolapamientos($idRecurso,$currentfecha,$hi,$hf,$condicionEstado);
			if($numEvents > 0){
				//si ocupado
				$estado = 'pendiente';
				//$msg = 'su reserva está pendiente de validación. Existen solapamientos con otras peticiones (ver detalles)';
			}
			else{
				//si libre
				// Validadores realizan reservas no solicitudes
				if (!ACL::isValidador())
					$estado = 'pendiente';
				else
					$estado = 'aprobada';
				
			}
		}

		return $estado;

	}
	
}//fin del controlador