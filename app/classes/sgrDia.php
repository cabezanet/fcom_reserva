<?php

	class sgrDia{

		private $tsfecha; //timestamp de la fecha
		public 	$eventos; //array de objetos de tipo Eventos
		private $esDomingo;
		private $esSabado;


		
		public function __construct($tsfecha,$eventos){

			$this->eventos = $eventos;
			$this->tsfecha = $tsfecha;
			if (date('N',$tsfecha) == '7') $this->esDomingo = true;
			if (date('N',$tsfecha) == '6') $this->esSabado = true; 

			return $this;
		}



	}//fin de la clase

?>