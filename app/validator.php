<?php

//req1: alumno solo pueden reservar entre firstMonday y lastFriday  (por implementar)
Validator::extend('req1', function($attribute, $value, $parameters){
	    return false;
	});   
//req2: alumno supera el máximo de horas a la semana (12)
Validator::extend('req2', function($attribute, $value, $parameters){
		return false;
	});

//req3: espacio ocupado (no solapamientos)
Validator::extend('req3', function($attribute, $value, $parameters){
	return false;
	});
//req4: no se puede reservar en sábados y domingos
Validator::extend('req4', function($attribute, $value, $parameters){
	return false;
	});
//req5: alumnos y pdi: solo pueden reservar a partir de firstmonday 
Validator::extend('req5', function($attribute, $value, $parameters){
	return false;
	});

?>