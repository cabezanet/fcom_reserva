<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
//Para procesar e identificar al usuario
//Route::get('/login', ['uses' => 'AuthController@doLogin', 'before' => 'auth']);


Route::get('msg',array('as' => 'msg',function(){
	$msg = "Acceso denegado";
	return View::make('msg')->with(compact('msg'));
}));

Route::get('wellcome',array('as'=>'wellcome',function(){
	if (!Cas::isAuthenticated()) return View::make('wellcome');
	else
	{
		Cas::logout();
	}
}));


Route::get('/', array('as' => 'inicio', function (){
		Redirect::to(route('loginsso'));
	},'before'=>'auth'));


Route::get('login',array('as' => 'loginsso',function(){ 
		

		if (Cas::authenticate()){
			// login en sso ok 
			$attributes = Cas::attr();
			$statusUvus = stripos($attributes['schacuserstatus'],'uvus:OK');

			if ($statusUvus == false){
				$msg = 'Has iniciado sesión correctamente pero, <b>su UVUS no es válido</b><br />';
					
					return View::make('loginError')->with(compact('msg'));
			}


			//Falta usesrelación
			//$isPAS = stripos($attributes['usesrelacion'],'PAS'); 
			//$isPDI = stripos($attributes['usesrelacion'],'PDI');
			//$isAlumn = stripos($attributes['usesrelacion'],'ALUMNO');
			//if ($isPAS == false){

			//}

			$uid = $attributes['uid'];
			$user=User::where('username','=',$uid)->first();
			
			//	No registrado??
			if (!empty($user)){


				// Registrado pero -> No activo
				if (!$user->estado) {
					$msg = '<b>Usuario sin activar</b><br />
					Si en 24/48 horas persiste esta situación, puede ponerse en contacto con la Unidad TIC de la F. de Comunicación para solucionarlo.';
					
					return View::make('loginError')->with(compact('msg'));
				}

				//Registrado pero -> Caducada
				if (strtotime($user->caducidad) < strtotime(date('Y-m-d'))) return View::make('loginError')->with('msg','Su acceso a <i>reservas fcom</i></b> ha caducado.<br />Puede ponerse en contacto con la Unidad TIC de la F. de Comunicación para solucionarlo.');

				//-> login en laravel
				Auth::loginUsingId($user->id); 
				//-> ir a página de inicio de su perfil
				return Redirect::to(ACL::getHome());
			}
			else {
				//No registrado

				$user = new User;

        
		
        	    $user->colectivo = Input::get('colectivo');
        		$user->username = $uid; 
        		$user->caducidad = date('Y-m-d',strtotime('+5 years')); //Caducidad 5 años
        		$user->estado = false;//No activa
        		$user->save();

        		Mail::queue('Nueva petición de alta', array() , function($message)
            		{
            		$message->to('uniticfcom@gmail.com')->subject('Nuevo usuario reservas fcom');
            			});
       

        		$notificacion = new Notificacion();
       			$notificacion->msg = 'petición de alta';
        		$notificacion->target = '1';//identificador del usuario admin
        		$notificacion->source = $user->username;
        		$notificacion->estado = 'abierta';
        		$notificacion->save();

				$msg = 'Usuario registrado en <i>reservas fcom</i>.<br />
				En 24/48 horas activaremos su cuenta<br />';
				
				return View::make('loginError')->with(compact('msg'));
			}

			
		}
		else{
			//login sso no valido -> ??
			echo "error en la autenticación";
		}
	}));

Route::get('logout',array('as'=>'logout',function(){

		if (!Cas::isAuthenticated()) return View::make('wellcome');
		else
		{
			Cas::logout();
		}

}));

Route::get('test',array('as'=>'test',function(){
	$user = User::where('dni','=','49130584')->first();
	//$user->id = ;	
 	$events = Evento::where('user_id','=',$user->id)->get();
 	print_r($events);
 	echo $events->count();
 	if (!empty($events)) echo "no vacio";

	}));







//Route::get('registro',array('as' => 'registro.html',function(){return View::make('registro');}));

//Route::post('saveregistro',array('as' => 'saveRegistro.html','uses' => 'UsersController@requestAccess'));


Route::get('data',array('as'=>'ToValidate',function(){
	
	
	$limit = Input::get('limit','10');
	$offset = Input::get('offset','0');
	$sort = Input::get('sort','asc');	
	$order = Input::get('order','asc');
	$search = Input::get('search','');
	
	if($search == "") {
		$events = Evento::Where('estado','=','pendiente')->get()->toArray();
	} else {
		$events = Evento::Where('estado','=','pendiente')->Where('titulo','like','%'.$search.'%')->get()->toArray();
	}
	
	$count = count($events);

	if($order != "asc") {
		$events = array_reverse($events);
	}
		
	$events = array_slice($events, $offset, $limit);
	
	$jsonString =  "{";
	$jsonString .= '"total": ' . $count . ',';
	$jsonString .= '"rows": ';
	$jsonString .=	json_encode($events);
	$jsonString .= "}"; 
	
	return $jsonString;

}));



Route::get('justificante', array('as' => 'justificante', function()
	{
	
	$events = Evento::where('evento_id','=',Input::get('idEventos'))->first();
	$recursos = Evento::where('evento_id','=',Input::get('idEventos'))->groupby('recurso_id')->get();
	setlocale(LC_ALL,'es_ES@euro','es_ES','esp');
   	$strDayWeek = Date::getStrDayWeek($events->fechaEvento);
	$strDayWeekInicio = Date::getStrDayWeek($events->fechaInicio);
	$strDayWeekFin = Date::getStrDayWeek($events->fechaFin);
	$created_at = ucfirst(strftime('%A %d de %B  a las %H:%M:%S',strtotime($events->created_at)));
   
    $html = View::make('pdf.justificante')->with(compact('events','strDayWeek','strDayWeekInicio','strDayWeekFin','recursos','created_at'));
   	$result = myPDF::getPDF($html);

   	return Response::make($result)->header('Content-Type', 'application/pdf');
	}));

//Validador (rol = 5)
Route::get('validador/home.html',array('as' => 'validadorHome.html',function(){
			$events = Evento::Where('estado','=','pendiente')->groupby('evento_id')->take(5)->get();
			return View::make('validador.index')->with('events',$events);
			},
			'before' => array('auth','capacidad:5,msg')
			));

Route::get('validador/validaciones.html',array('as' => 'validaciones.html','uses' => 'ValidacionController@index','before' => array('auth','capacidad:5,msg')));

Route::get('validador/valida.html',array('as' => 'valida.html','uses' => 'ValidacionController@valida','before' => array('auth','capacidad:5,msg')));





//Admin (rol = 4)
Route::get('admin/home.html',array('as' => 'adminHome.html',function(){
			$notificaciones = Notificacion::where('estado','=','abierta')->get();
			return View::make('admin.index')->with(compact('notificaciones'));
			},
			'before' => array('auth','capacidad:4,msg')
			));

Route::get('admin/users.html',array('as' => 'adminUsers.html','uses' => 'UsersController@listUsers',
			'before' => array('auth','capacidad:4,msg')
		));

Route::get('admin/adduser.html',array('as' => 'adminAdduser.html',function(){
			return View::make('admin.userNew')->with("user",Auth::user());
			},'before' => array('auth','capacidad:4,msg')
		));





Route::get('admin/config.html',array('as' => 'config.html',function(){
			return View::make('admin.config')->with('user',User::find(Input::get('id')));
			},
			'before' => array('auth','capacidad:4,msg')
		));

Route::get('admin/logs.html',array('as' => 'logs.html',function(){
			return View::make('adminLogs');
			},
			'before' => array('auth','capacidad:4,msg')
		));

//rutas POST admin (rol = 4)
Route::post('admin/user/new',array('as' => 'post_addUser','uses' => 'UsersController@create',
			'before' => array('auth','capacidad:4,msg')));

//search user by admin	
Route::get('admin/searchuser.html',array(	'as' => 'searchUser.html',
											'uses' => 'UsersController@search',
											'before' => array('auth','capacidad:4,msg'),
		));

Route::post('admin/searchuser.html',array('as' => 'postusersearch',
			'uses' => 'UsersController@search',
			'before' => array('auth','capacidad:4,msg')));


//edit user by admin
Route::get('admin/useredit.html',array('as' => 'useredit.html','uses' => 'UsersController@formEditUser','before' => array('auth','capacidad:4,msg')));

Route::post('admin/useredit.html',array('as' => 'updateUser.html','uses' => 'UsersController@updateUser','before' => array('auth','capacidad:4,msg')));











//Técnico (rol = 3)
Route::get('tecnico/home.html',array('as' => 'tecnicoHome.html',function(){
			return View::make('tecnico.index');
			},
			'before' => array('auth','capacidad:3,msg')
			));

//Route::get('tecnico/home.html', array( 'uses' => 'CalendarController@showCalendarViewMonth',
//			));

Route::get('tecnico/espacios.html',array(	'as'		=> 'tecnicoEspacios.html',
											'uses'		=> 'recursosController@listRecursos',
											'before'	=> array('auth','capacidad:3,msg')
			));


Route::get('tecnico/informes.html',array('as' => 'informes.html',function(){
			return View::make('tecnico.informes');
			},
			'before' => array('auth','capacidad:3,msg')
			));

Route::post('tecnico/home.html',array(	'uses' => 'CalendarController@search',
										'before' => array('auth','capacidad:3,msg')
									 ));


Route::post('tecnico/search',array(	'uses' => 'CalendarController@search',
										'before' => array('auth','capacidad:3,msg')
									 ));

//Todos los perfiles
Route::get('calendarios.html',array('as' => 'calendarios.html','uses' => 'CalendarController@showCalendarViewMonth',
			'before' => array('auth','capacidad:1-2-3-4-5,msg')));
		/*
		El filtro req2 permite bloquear el acceso al calendario para reservar a los alumnos con el número de horas máximo a la semana (12h) agotado
		*/

//Ajax function
Route::get('ajaxGetRecursoByGroup',array('as' => 'getRecursoByAjax','uses' => 'CalendarController@getRecursosByAjax','before' => 'ajax_check'));

Route::get('validador/ajaxDataEvent',array('uses' => 'CalendarController@ajaxDataEvent','before' => array('auth','ajax_check')));

Route::post('saveajaxevent',array('uses' => 'CalendarController@eventsavebyajax','before' => array('auth','ajax_check')));
		
Route::get('getajaxevent',array('uses' => 'CalendarController@getajaxeventbyId','before' => array('auth','ajax_check')));

Route::get('ajaxCalendar',array('uses' => 'CalendarController@getTablebyajax','before' => array('auth','ajax_check')));

Route::post('delajaxevent',array('uses' => 'CalendarController@delEventbyajax','before' => array('auth','ajax_check')));
		
Route::post('getajaxeventbyId',array('uses' => 'CalendarController@getajaxeventbyId','before' => array('auth','ajax_check')));


Route::post('editajaxevent',array('uses' => 'CalendarController@editEventbyajax','before' => array('auth','ajax_check')));


Route::post('admin/ajaxActiveUser',array('uses' => 'UsersController@activeUserbyajax','before' => array('auth','ajax_check')));





App::missing(function($exception)
{
    return View::make('404');
});