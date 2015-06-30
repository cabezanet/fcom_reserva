<?php

class AuthController extends BaseController {
 
    /**
     * Attempt user login
     */
    public function doLogin()
     {
        // Obtenemos el email, borramos los espacios
        // y convertimos todo a minúscula
        $username = mb_strtolower(trim(Input::get('username')));
        // Obtenemos la contraseña enviada
        $password = Input::get('password');
        

        // Realizamos la autenticación
        if (Auth::attempt(array('username' => $username, 'password' => $password),$remember = false)){
            
            $home = ACL::getHome();

            //echo $home;
            return Redirect::to($home);
        }
         
        // La autenticación ha fallado re-direccionamos
        // a la página anterior con los datos enviados
        // y con un mensaje de error
        Session::flash('msg', "Datos incorrectos, vuelva a intentarlo.....");
        return Redirect::back();
        }
 
    public function doLogout()
        {
        //Desconctamos al usuario
        Auth::logout();
        $url = route('inicio');
        //Redireccionamos a la página de login
        return Redirect::to($url);//->with('msg', 'Has cerrado sesión....');
        }

}

