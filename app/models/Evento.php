<?php

class Evento extends Eloquent{

 	protected $table = 'eventos';

 	protected $fillable = array('titulo', 'recurso_id','fechaEvento','fechaInicio','repeticion', 'dia','diasRepeticion','fechaFin','user_id','created_at');

	public function userOwn(){
		
 		return $this->belongsTo('User','user_id','id');
 	}	

 	public function recursoOwn(){
 		return $this->belongsTo('Recurso','recurso_id','id');
 	} 


 	//private $errorReq1 =  'La debe estar entre ';

 	private $rules = array (
			'titulo' 	=>	'required',
			'titulo.ocupado' => 'su reserva no se puede realizar, existen solapamientos con otras reservas ya aprobadas.',
			'actividad' =>	'required',
			'fInicio' 	=>  'required|date|date_format:d-m-Y',
			'hInicio'	=>	'required|date_format:H:i',
			'hFin'		=>	'required|date_format:H:i',
			'dias'		=> 	'required_with:fInicio,fEvento',
			);

	private	$messages = array (
			'required'			=>	'El campo <strong>:attribute</strong> es obligatorio. ',
			'titulo.required'	=>	'El campo <strong>"Título"</strong> es obligatorio. ',
			'fInicio.required' 	=>	'El campo <strong>"Fecha"</strong> es obligatorio. <br />',
			'dias.required_with'=>	'El campo <strong>"Días"</strong> es obligatorio. ',
			'date'				=>	'<strong>Fecha no válida</strong>. <br />',
			'date_format'  		=>	'<strong>Formato de fecha no válido</strong>. Formato admitido: d-m-Y. <br />',
			'fInicio.after' 	=>	'La <strong>Fecha de Inicio</strong> debe ser posterior al día actual. <br />',
			'fFin.after'		=>	'La <strong>"fecha de finalización"</strong> debe ser posterior a la <strong>"fecha de inicio"</strong>. <br />',
			'hFin.after'		=>	'La <strong>"hora de inicio"</strong> tiene que ser anterior a la <strong>"hora de finalización"</strong>. ',
			'fInicio.req1' 		=>	'',
			'fInicio.req5' 		=>	'',
			'hFin.req2' 		=>	'Se supera el máximo de horas a la semana.. (12h). ',
			'titulo.req3' 		=>	'Espacio ocupado, la solicitud de reserva no se puede registrar. ',
			'dias.req4'			=>	'',
			);	
	
    private $errors = array();

		//Resumen requisitos implementados
			//req1: alumno solo pueden reservar entre firstMonday y lastFriday  (por implementar)
    		//req2: alumno supera el máximo de horas a la semana (12)
    		//req3: espacio ocupado (no solapamientos)
    		//req4: no se puede reservar en sábados y domingos
    		//req5: alumnos y pdi: solo pueden reservar a partir de firstmonday 
    
    public function validate($data)
    	{

        
    	//mensages
    	if (ACL::isUser()){
    		setlocale(LC_ALL,'es_ES@euro','es_ES','esp');
    		$this->messages['fInicio.req1'] = 'Puedes reservar entre el <strong>' . strftime('%A, %d de %B de %Y',ACL::fristMonday()) . '</strong> y el <strong>' .strftime('%A, %d de %B de %Y',ACL::lastFriday()) .'</strong><br />';
    	}
    	if (ACL::isAvanceUser()){
    		setlocale(LC_ALL,'es_ES@euro','es_ES','esp');
    		$this->messages['fInicio.req5'] = 'Puedes reservar a partir del <strong>' . strftime('%A, %d de %B de %Y',ACL::fristMonday()) . '</strong><br />';
    	}
    	if (isset($data['dias']) && in_array('6', $data['dias']) )
    		$this->messages['dias.req4'] = $this->messages['dias.req4'] . " No se puede reservar en <strong>sábado</strong><br />";
    	if (isset($data['dias']) && in_array('0', $data['dias']) )
    		$this->messages['dias.req4'] = $this->messages['dias.req4'] . " No se puede reservar en <strong>domingo</strong><br />";
    	//fin mensages
       
    	
        // make a new validator object
        $v = Validator::make($data, $this->rules, $this->messages);
   

	   //req1: alumno solo pueden reservar entre firstMonday y lastFriday  (por implementar)
	    if (!empty($data['fInicio']) && strtotime($data['fInicio']) != false)
			$v->sometimes('fInicio','req1',function($data){
				if (ACL::isUser()) {
					if ( ACL::fristMonday() > Date::getTimeStamp($data['fInicio'])  || ACL::lastFriday()  < Date::getTimeStamp($data['fInicio'])) return true;
				}
			});


		//req2: alumno supera el máximo de horas a la semana (12)
		// empty($data['action'] -> solo se comprueba en la reserva nueva (add)
		if (!empty($data['hFin']) && !empty($data['hInicio']) && empty($data['action'])){
			
			$v->sometimes('hFin','req2',function($data){
				if (ACL::isUser()){
					$nh = ACL::numHorasReservadas();//Número de horas ya reservadas
					$nh2 = Date::diffHours($data['hInicio'],$data['hFin']);//números de horas que se quiere reservar
					$maximo = Config::get('options.max_horas');
					$credito = $maximo - $nh; //número de horas que aún puede el alumno reservar
			    		if ($credito < $nh2) return true;
			    	}
			    });
		}
		
		//req3: espacio ocupado (no solapamientos)
       	if (isset($data['fInicio']) && strtotime($data['fInicio']) != false && isset($data['dias']) ){
			
			$v->sometimes('titulo','req3',function($data){
				
				if ($data['id_recurso'] == 0){
					$recursos = Recurso::where('grupo_id','=',$data['grupo_id'])->get();
					foreach($recursos as $recurso){
						//si modo automatico
						//$ocupado = false;
						$id_recurso = $recurso->id;	
						if(ACL::automaticAuthorization($id_recurso)){
							//Ocupado??; -> Solo busco solapamientos con solicitudes ya aprobadas
							$estado = 'aprobada';
							//$currentFecha tiene formato d-m-Y
							$dias = $data['dias']; //0->domingo, 1->lunes...., 5->viernes, 6->sádabo
							
							foreach ($dias as $dWeek) {
								if ($data['repetir'] == 'SR') $nRepeticiones = 1;
								else $nRepeticiones = Date::numRepeticiones($data['fInicio'],$data['fFin'],$dWeek);

								for($j=0;$j<$nRepeticiones;$j++){
									$startDate = Date::timeStamp_fristDayNextToDate($data['fInicio'],$dWeek);
									$currentfecha = Date::currentFecha($startDate,$j);
									$numEvents = Calendar::getNumSolapamientos($id_recurso,$currentfecha,$data['hInicio'],$data['hFin'],$estado);
									//si ocupado
									if($numEvents > 0){
										//$ocupado = true;
										return true;
									}
								}
							}
						}
					}
				}
				else{
					//si modo automatico
					//$ocupado = false;	
					if(ACL::automaticAuthorization($data['id_recurso'])){
						//Ocupado??; -> Solo busco solapamientos con solicitudes ya aprobadas
						$estado = 'aprobada';
						//$currentFecha tiene formato d-m-Y
						$dias = $data['dias']; //0->domingo, 1->lunes...., 5->viernes, 6->sádabo
						
						foreach ($dias as $dWeek) {
							if ($data['repetir'] == 'SR') $nRepeticiones = 1;
							else $nRepeticiones = Date::numRepeticiones($data['fInicio'],$data['fFin'],$dWeek);

							for($j=0;$j<$nRepeticiones;$j++){
								$startDate = Date::timeStamp_fristDayNextToDate($data['fInicio'],$dWeek);
								$currentfecha = Date::currentFecha($startDate,$j);
								$numEvents = Calendar::getNumSolapamientos($data['id_recurso'],$currentfecha,$data['hInicio'],$data['hFin'],$estado);
								//si ocupado
								if($numEvents > 0){
									//$ocupado = true;
									return true;
								}
							}
						}
					}
				}	
				
			});
		}
               
        //req4: Sábados y domingos no se puede reservar
		if (isset($data['dias'])){
			$v->sometimes('dias','req4',function($data){
				$dias = $data['dias'];
				// 0 = domingo, 6 = sábado
				if (in_array('0', $dias) || in_array('6', $dias)) return true;
		});
		
		//Req5: alumnos (no es necesario por req1) y pdi: solo pueden reservar a partir de firstmonday 
	    if (!empty($data['fInicio']) && strtotime($data['fInicio']) != false)
			$v->sometimes('fInicio','req5',function($data){
				if (ACL::isAvanceUser()) {
					if ( ACL::fristMonday() > Date::getTimeStamp($data['fInicio']) ) return true;
				}
			}); 	

		//after: fInicio & fFin > today	
 		if (!empty($data['fInicio']) && strtotime($data['fInicio']) != false ){
        	
	        $intFinicio = Date::getTimeStamp($data['fInicio'],'-');
	        $intNow = Date::getTimeStamp(date('d-m-Y'),'-');
        	$intDiaAnterior = strtotime('-1 day',$intFinicio);
		    //fecha posterior al día actual
		    $v->sometimes('fInicio','after:'. date('d-m-Y',$intNow),function($data){
		    	return true;
			    });
		    //fecha fin mayor o igual que fecha inicio => mayor que el día anterior a fecha inicio
		    if ($data['repetir'] == 'CS'){ 
        		$v->sometimes('fFin','required|date|date_format:d-m-Y|after:'. date('d-m-Y',$intDiaAnterior),function($data){
		    	    	return true;
		    	});
        	}
        }
        //after:hinicio < hfin
		if (!empty($data['hInicio'])){
			$aHini = explode(':',$data['hInicio']);
			$timehorainicio = mktime($aHini[0],$aHini[1]);
			$v->sometimes('hFin','required|date_format:H:i|after:'.date('H:i',$timehorainicio),function($data){
		    	return true;
			    });
        }


		}
        // check for failure
        if ($v->fails())
        {
           	$this->errors = $v->errors()->toArray();
            return false;
        }

        // validation pass
        return true;
    }

    public function errors()
    	{
        return $this->errors;
    }
 
}