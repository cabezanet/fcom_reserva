<?php

	//responsablidad: obtener los valores de configuración

	class sgrOption {


		public static function defaultVistaCalendario(){

			return Config::get('options.defaultVistaCalendario');

		}

		public static function getAccionReservaMultiple(){
			
			return Config::get('options.reservaMultiple'); 
		
		}
		
	
		public static function getNumeroMaximoHorasSemana(){

			return Config::get('options.max_horas');

		}

		public static function getdiaSemanaLimiteAntelacion(){
			
			return Config::get('options.ant_ultimodia');
		
		}

		public static function getNumeroDeSemanasAntelacion(){

			return Config::get('options.ant_minSemanas'); 

		}

		public static function rolAlumnoNombre(){

			$roles = Config::get('options.roles');
			return $roles['alumnos'];

		}
	}

?>