<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/
/*		El filtro req2 permite bloquear el acceso al calendario para reservar a los alumnos con el número de horas máximo a la semana (12h) agotado
*/


Route::filter('auth', function()
{
	$user = User::find(29);

	Auth::login($user);	
	if (Auth::guest()) return Redirect::to(route('loginsso'));
});

//Comprobar si el usuario autentivcado tiene privilegios para realizar la acción requerida
Route::filter('capacidad',function($ruta,$peticion,$capacidad,$redirect) {
	
	$roles  = explode("-",$capacidad);
	if (!in_array(Auth::user()->capacidad, $roles))
		return Redirect::to($redirect);
});

//Comprueba si la petición se realizó por ajax
Route::filter('ajax_check',function(){
	
	if(!Request::ajax()) return Redirect::to(route('inicio'));
	//if(Request::ajax()) return true;

});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to(ACL::getHome());
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});



