<?php

return array (

	//Último día de la semana en curso para poder reservar para la semana siguiente (en este caso es el jueves día 4 de la semana)
	'ant_ultimodia' => '4', 

	//Dias de antelación minima (7 - ant_minDias)
	'ant_minDias' => '3',

	//Número de semanas de antelación minima (en este caso Una semana)
	'ant_minSemanas' => '1',

	//Máximo de horas a la semana para usuarios del perfil alumno
	'max_horas'	=> '12',
 
	//acciones que puede realizar un usuario en el sistema
	'actions' => array(	'ADDRESERVA',
						'EDITRESERVA',
						'DELRESERVA',
						'SOLICITARRESERVA',
						'APROBARRESERVA',
						'DENEGARRESERVA',
						'RESERVAMULTIPLE', //Reservar multiples puestos o equipos en una sola petición
					),

	'puesto' => 'PUESTO',
	'espacio' => 'ESPACIO',
	'equipo'=> 	'EQUIPO',
	
	'reservaMultiple' => 'RESERVAMULTIPLE',	
	
	'roles' => array(	'alumnos' 		=>	'Alumno',
						'pdi'			=>	'PDI',
						'pas'			=>	'PAS',
						'validador'		=>	'VALIDADOR',
						'administrador'	=> 'ADMINISTRADOR',
						),
	'defaultVistaCalendario' => 'month',

	);
?>