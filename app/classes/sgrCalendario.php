<?php
	//responsablidad: generar calendarios 
	class sgrCalendario {


		/**
		* 
		*/
		public $mes;
		public $anno;

		public $tsprimerDia;//timeStamp primer día del mes
		public $ultimoDia; //posibles valores: 28/29(febrero bisiesto)/30,31
		public $diaSemanaPrimerDia;//númerico 1->lunes,2->martes,....7->domingo
		public $diaSemanaUltimoDia;
		public $numeroSemanas;
		//public $numeroDiasMesAnterior;
		//public $numeroDiasMesPosterior;
		
		
		public $recurso; //objeto de la clase Recurso

		public $dia = array(); //array dos dimensiones: tantas filas como semana tenga el mes, y cada fila con 7 posiciones, una por día. Cada posición del array contine el un objeto de tipo sgrDia 
		

		/**
		*
		*/	
		
		public function __construct ($mes,$anno){
			
			$this->mes = $mes;
			$this->anno = $anno;

			$this->tsprimerDia = strtotime($this->anno.'-'.$this->mes.'-1');
			$this->diaSemanaPrimerDia = sgrFechas::getDiaSemana($this->tsprimerDia);
			$this->ultimoDia = sgrFechas::getUltimoDiaMes($mes,$anno);
			$this->diaSemanaUltimoDia = sgrFechas::getDiaSemana(strtotime($anno .'-'.$mes.'-'.$this->ultimoDia));	
			$this->numeroSemanas = sgrFechas::getNumeroSemanasMes(strtotime($anno .'-'.$mes.'-'.'1'),strtotime($anno .'-'.$mes.'-'.$this->ultimoDia));
			
			return $this;
		}
		


		public function addDia($tsfecha,$sgrDia = array()){

				// $semana número de la semanas de $this->mes (posibles valores [0|1|2|3|4|5]) es igual al número de semana anual de $tsfecha MENOS el número de semana anual del primer día del mes.  
				$semana = sgrFechas::getSemanaMes($tsfecha) - sgrFechas::getSemanaMes($this->tsprimerDia);
				$dia = sgrFechas::getDiaSemana($tsfecha);	

				$this->dia[$semana][$dia] = $sgrDia;
				
				return true;
		}

		
		

	}//fin de la clase
?>