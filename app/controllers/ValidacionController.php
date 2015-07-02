<?php

class ValidacionController extends BaseController {

	
	public function index(){
		
		$sortby = Input::get('sortby','created_at');
	    $order = Input::get('order','asc');
	    $id_recurso = Input::get('id_recurso','0');
	    $id_user = Input::get('id_user','0');
		

		$resultValidacion = Input::get('result','');


		//mostramos la lista de eventos pendientes
		if ($id_recurso == 0 && $id_user == 0){
			$events = Evento::where('estado','=','pendiente')->groupby('evento_id')->orderby($sortby,$order)->paginate(10);
		}
		else if ($id_recurso ==0 && $id_user != 0){
			$events = Evento::where('estado','=','pendiente')->where('user_id','=',$id_user)->groupby('evento_id')->orderby($sortby,$order)->paginate(10);
			
		}	
		else if ($id_recurso != 0 && $id_user == 0){
			$events = Evento::where('estado','=','pendiente')->where('recurso_id','=',$id_recurso)->groupby('evento_id')->orderby($sortby,$order)->paginate(10);
		}
		else if ($id_recurso != 0 && $id_user != 0){
			$events = Evento::where('estado','=','pendiente')->where('recurso_id','=',$id_recurso)->where('user_id','=',$id_user)->groupby('evento_id')->orderby($sortby,$order)->paginate(10);
		}
		
	
		//De todos los recursos, sólo aquellos que tienen eventos pendientes
		$eventsByrecurso = Evento::where('estado','=','pendiente')->groupby('recurso_id')->get();

		//Usuarios con solicitudes pendientes
		$eventsByUser = Evento::where('estado','=','pendiente')->groupby('user_id')->get();
		

		return View::make('validador.validaciones')->with('events',$events)->with('sortby',$sortby)->with('order',$order)->with('eventsByrecurso',$eventsByrecurso)->with('eventsByUser',$eventsByUser)->with('idrecurso',$id_recurso)->with('iduser',$id_user)->with('resultValidacion',$resultValidacion);

	}

	public function valida(){
		
		$sortby = Input::get('sortby','created_at');
	    $order = Input::get('order','asc');
	    $id_recurso = Input::get('id_recurso','0');
	    $id_user = Input::get('id_user','0');
		$evento_id = Input::get('evento_id','');
		$action = Input::get('action','');
		
		//validamos (aprobar o denegar) evento

		//vemos si hay solapamientos con solicitudes ya aprobadas
		$solapamientos = false;
		$events = Evento::where('evento_id','=',$evento_id)->get();
		foreach ($events as $event) {

			$where  =	"fechaEvento = '".$event->fechaEvento."' and ";
			$where .= 	" (( horaInicio <= '".$event->horaInicio."' and horaFin >= '".$event->horaFin."' ) "; 
			$where .= 	" or ( horaFin > '".$event->horaFin."' and horaInicio < '".$event->horaFin."')";
			$where .=	" or ( horaInicio > '".$event->horaInicio."' and horaInicio < '".$event->horaFin."')";
			$where .=	" or horaFin < '".$event->horaFin."' and horaFin > '".$event->horaInicio."')";
			$where .= 	" and evento_id != '".$evento_id."'";
			$where .= 	" and estado = 'aprobada'";
			
			$numSolapamientos = Recurso::find($id_recurso)->events()->whereRaw($where)->count();
				
			if($numSolapamientos > 0) $solapamientos = true;
		
		}
		
		if(!$solapamientos){
			$filasAfectadas = Evento::where('evento_id','=',$evento_id)->update(array('estado'=>'aprobada'));
			$result = true;
		}
		else
		{
			$result = false;
		}




		return Redirect::to(route('validaciones.html',array('result'	=> $result,
															'sortby' 	=> $sortby,
															'order'		=> $order,
															'id_recurso'=> $id_recurso,
															'id_user'	=> $id_user,
															)));

	}

}