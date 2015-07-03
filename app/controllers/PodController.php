<?php

class PodController extends BaseController {

	
	public function testCsv(){

		
		$events = array();
		$noexistelugar = array();
		$numFila = 2;

		$csv = new csv();
		
		$file = Input::file('csvfile'); //controlar que no sea vacio !!!!!
		if (empty($file)){
			$msgEmpty = "No se ha seleccionado ningún archivo *.csv"; 
			return View::make('admin.pod')->with(compact('msgEmpty'));	
		}


		$f = fopen($file,"r");
		
		while (($fila = fgetcsv($f,0,';','"')) !== false){
			//$content es un array donde cada posición almacena los valores de las columnas del csv
			$columnIdLugar = $csv->getNumColumnIdLugar();
			$id_lugar = $fila[$columnIdLugar];
			
			$datosfila = $csv->filterFila($fila); //nos quedamos con las columnas que hay que guardar en la Base de Datos.

			if( $this->existeLugar($id_lugar) ){

				//salvamos evento, si existo devolvemos confirmación a usuario
				if ($result = $this->save($datosfila)){
					$events[$numFila] = $datosfila;	
					
				} 
			
			}
			else 
				$noexistelugar[$numFila] = $datosfila;
			
			$numFila++;
			
		}
		
		fclose($f);
		//$errores = $csv->getErroresLugar();
		return View::make('admin.pod')->with(compact('events','noexistelugar','periodos'));
	}

	private function save($data){
		
		$result = false;
		$fechaDesde = Date::dateCSVtoSpanish($data['F_DESDE']);
		$fechaHasta = Date::dateCSVtoSpanish($data['F_HASTA']);
		
		$nRepeticiones = Date::numRepeticiones($fechaDesde,$fechaHasta,$data['COD_DIA_SEMANA']);

		
		//identificador único de la serie de eventos
		do {
			$evento_id = md5(microtime());
		} while (Evento::where('evento_id','=',$evento_id)->count() > 0);
		

		for($j=0;$j < $nRepeticiones; $j++ ){ //foreach 
				$evento = new Evento();
	
				//evento periodico o puntual??			
				if ($nRepeticiones == 1) $evento->repeticion = 0;
				else $evento->repeticion = 1;

				
				$evento->evento_id = $evento_id;

				//obtner identificador de recurso (espacio o medio)
				$evento->recurso_id = $this->getRecursoByIdLugar($data['ID_LUGAR']);
				
				//estado del evento = 'aprobada'
				$evento->estado = 'aprobada';

					
				//fechas de inicio y fin
				$evento->fechaFin = Date::toDB(Date::dateCSVtoSpanish($data['F_HASTA']),'-');
				$evento->fechaInicio = Date::toDB(Date::dateCSVtoSpanish($data['F_DESDE']),'-');
				
				//fecha Evento
				$startDate = Date::timeStamp_fristDayNextToDate(Date::dateCSVtoSpanish($data['F_DESDE']),$data['COD_DIA_SEMANA']);
				$currentfecha = Date::currentFecha($startDate,$j);
				$evento->fechaEvento = Date::toDB($currentfecha,'-');

				//horario
				$evento->horaInicio = $data['INI'];
				$evento->horaFin = $data['FIN'];
	
				//código día de la semana
				$evento->diasRepeticion = json_encode($data['COD_DIA_SEMANA']);
				$evento->dia = $data['COD_DIA_SEMANA'];
			
						
				
				$evento->titulo = $data['ASIGNATURA'] . ' - ' . $data['NOMCOM'];
				$evento->asignatura = $data['ASIGNATURA'];
				$evento->profesor = $data['NOMCOM'];
				$evento->actividad = 'Docencia Reglada P.O.D';
				
				
				
				$evento->dia = $data['COD_DIA_SEMANA'];
				
				$evento->user_id = Auth::user()->id;
				
				if ($evento->save()) $result = true;
			
		}//fin foreach
		

		return $result;


	}

	private function existeLugar($idLugar){
		$result = false;

			$recurso = Recurso::where('id_lugar','=',$idLugar)->get();

			if($recurso->count() > 0) $result = true;

		return $result;
	}

	private function getRecursoByIdLugar($idLugar){
		
		$result = false;

			$recurso = Recurso::where('id_lugar','=',$idLugar)->get();

			
			$result = $recurso[0]->id;
		

		return $result;
	}

}
