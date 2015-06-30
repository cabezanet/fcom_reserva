<?php

	//Responsabilidad:: --> tratamientos y funciones de fecha
	class sgrFechas {

	public static function getDiaMes($tsfecha){

		//date: formato 'd' devuelve el día del mes (un dígito)
		return date('j',$tsfecha);
	}
		
	public static function getDiaSemana($tsFecha){
		//'N'->devuelve el numero del dia de la semana; 1->lunes,2->martes,...7->domingo
		return date('N',$tsFecha);
	}

	public static function getUltimoDiaMes($mes,$anno){
		//'t'->devuelve 28/29(año bisiesto)/30,31
		return date('t',mktime(0,0,0,$mes,1,$anno));	
	}

	public static function getSemanaMes($tsfecha){
		return date('W',$tsfecha);;
	}

	public static function getNumeroSemanasMes($tsPrimerDiaMes,$tsUltimoDiaMes){
		//'W' devulve la semama del año
		$primeraSemana=date('W',$tsPrimerDiaMes);
		$ultimaSemana=date('W',$tsUltimoDiaMes);
		$semanas = $ultimaSemana - $primeraSemana;
		return $semanas;
	}
	/**
	*
	* @param $tsFecha (timestamp)
	* 
	* @return $tsLunes (timestamp)
	*/	
	//Devuelve le timestamp del Lunes anterior a $tsFecha 
	public  static function getLunes($tsFecha){

		//si $tsFecha es lunes return $tsFecha
		if ( 1 == date('N',$tsFecha) ) return $tsFecha; 

		return  strtotime('previous monday',$tsFecha);
		
	}//fin getLunes
	
	/**
	*
	* @param $tsFecha (timestamp)
	* 
	* @return $tsViernes (timestamp)
	*/	
	//Devuelve le timestamp del domingo siguiente a $tsFecha 
	public  static function getDomingo($tsFecha){

		//si $tsFecha es domingo return $tsFecha
		if ( 7 == date('N',$tsFecha ) ) return $tsFecha; 
		
		return  strtotime('next sunday',$tsFecha);
		
	}//fin getDomingo
	/**
	* @param $h1,$h2 (string)
	*
	* @return $horas (integer) //número de horas
	*
	*/
	//Devuelve la diferencia en horas entre dos horas en formato HH:mm:ss
	public static function horas($h1,$h2){ 
		$diff = 0;
	    
	    $tsh1 = strtotime($h1); 
	    $tsh2 = strtotime($h2); 

	    $diff = ($tsh2 - $tsh1) / (60 * 60) ; //diferencia en horas
		
		return $diff;

	}//fin horas 

	

	/**
	* @param tsFecha (integer) timeStamp de una fecha
	* @param $strFormato (string) formato como strftime
	*
	* @return $strFechaLocal (string) fecha en formato local
	**/
	public static function getLocale($tsFecha,$strFormato){
		
		setlocale(LC_ALL,'es_ES@euro','es_ES','esp');

		return ucfirst(strftime($strFormato,$tsFecha));	

	}
	
	}//fin de la clase

?>