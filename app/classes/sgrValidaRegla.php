<?php

	//Responsabilidad: chequea que se cumplan las reglas de negocio
	class sgrValidaRegla {

		

		public static function superaMaximoHoras($user){
			
			//sólo los usuarios del rol alumno tienen restringido el numero de horas de uso de recursos a la semana
			if ( $user->rol->nombre != sgrOption::rolAlumnoNombre() ) return false;	

			$maximoHorasSemana = sgrOption::getNumeroMaximoHorasSemana();
			
			$tsLunes = sgrFechas::getLunes(time());
			$tsDomingo = sgrFechas::getDomingo(time());
			//$self = new sgrValidaRegla();
			if ($user->getHorasReservadas($tsLunes,$tsDomingo) >= $maximoHorasSemana) return true;
			
			
		}


		/*public function getHorasReservadas($user,$tsFechaInicio,$tsFechaFin){
			
			$events = array();
			$horas = 0;


			$events = $user->userEvents()->where('fechaEvento','>=',date('Y-m-d',$tsFechaInicio))->where('fechaEvento','<=',date('Y-m-d',$tsFechaFin))->get();
			
			foreach ($events as $key => $event) {
				$horas = $horas + sgrFechas::horas($event->horaInicio,$event->horaFin);
			}

			return $horas;
		}*/
	
	}//fin de la clase

?>