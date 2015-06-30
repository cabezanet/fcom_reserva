<?php

	class sgrRecurso(){

		
		/**
		* @var $recurso \Models\Recurso (objeto de tipo recurso)
		**/
		private $recurso;

		function __construct (Recurso $recurso){
				
			$this->recurso = $recurso;
			
		}
		

		/**
		*	@return $aRecursos array (devuelve un array con todos los recursos del mismo tipo)
		**/
		function getRecursosGrupo(){
			
			$aRecursos = array();

			$aRecursos = Recurso::where('grupo_id','=',$this->recurso->grupo_id)->get();

			return $aRecursos;

		}

		function canAll(){
			$can = false;
				//si el usuario autenticado no es "alumno" y el espacio no es del tipo espacio (ie, es un puesto o un equipo)
				if (!ACL::isUser() &&  $this->tipo != $this->tipoEspacio) $can = true;

			return $can;

		}
	}

?>