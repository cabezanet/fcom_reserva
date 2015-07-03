<?php

	//Responsabilidad: determinar si para un determinado usuario tiene permiso para realizar una acción en el sistema
	class sgrValidaPermiso {

		

		public static function reservaMultiple($user,$grupo){
			
			if (!$grupo->tieneElementos) return false;

			$accion = sgrOption::getAccionReservaMultiple();
			
			if (json_decode($user->rol->permisos)->$accion  === true) return true;
			return false;
			
		}
	
	}

?>