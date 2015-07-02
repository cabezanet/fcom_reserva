<?php

class UsersController extends BaseController {
 
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    //
  }
 

 /* public function requestAccess(){

    Input::flash();

    
    $rules = array(
        'nombre'                => 'required',
        'apellidos'             => 'required',
        'username'              => 'required|unique:users',
        'colectivo'             => 'required',
        );

    $messages = array(
          'required'      => 'El campo <strong>:attribute</strong> es obligatorio.',
          'unique'        => 'Usuario ya registrado'
          );
    $validator = Validator::make(Input::all(), $rules, $messages);
      
    if ($validator->fails())
      {
        return View::make('registro')->withErrors($validator->errors());
      }
    else{ 

      // salvamos los datos.....
        $user = new User;

        
        $user->nombre = Input::get('nombre'); 
        $user->apellidos = Input::get('apellidos');
        $user->colectivo = Input::get('colectivo');
        $user->username = Input::get('username'); 
        $user->caducidad = date('Y-m-d',strtotime('+5 years')); 
        $user->estado = false;
        $user->save();

        Mail::queue('Nueva petición de alta', array() , function($message)
            {
            $message->to('uniticfcom@gmail.com')->subject('Notificación automática: Alta de usuario');
            });
       

        $notificacion = new Notificacion();
        $notificacion->msg = 'petición de alta';
        $notificacion->target = '1';//identificador del usuario admin
        $notificacion->source = $user->username;
        $notificacion->estado = 'abierta';
        $notificacion->save();


        return View::make('successRegister');
    }


    
  }*/

  public function activeUserbyajax(){

    $result = array('success' => false);
    
    $username = Input::get('username','');
    $colectivo = Input::get('colectivo','');
    $caducidad = Input::get('caducidad','');
    $rol = Input::get('rol','1');
    $id = Input::get('id','');

    $user = User::where('username','=',$username)->first();

    if (!empty($user)) {
      
      $user->estado = true;
      $user->colectivo = $colectivo;
      $user->capacidad = $rol;
      $user->estado = true; //Activo
      if (empty($caducidad)) $caduca = date('Y-m-d');
      else $caduca = Date::toDB($caducidad);
      $user->caducidad = $caduca;
      $user->save();

      
        $notificacion = Notificacion::find($id);
        
          $notificacion->estado = 'cerrada';
          $notificacion->save();
        
      
      $result['success'] = true;

    }

    return $result;
  
  }

  /**
     * Search user
     *
     * @return Response
  */
  
  public function search()
    {
    
      $uvus = Input::get('uvus','');
      $users = User::where('username','like',"%$uvus%")->paginate(3);        
      
      Input::flash();
      return View::make('admin.userSearch')->with(compact('users'));
    }


  public function listUsers(){
      
      $sortby = Input::get('sortby','username');
      $order = Input::get('order','asc');
      $offset = Input::get('offset','3');
      $keySearch = Input::get('id_recurso','0');


      $usuarios = User::orderby($sortby,$order)->paginate($offset);

      return View::make('admin.userList')->with(compact('usuarios','sortby','order'));
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
    {
    //Creamos un nuevo usuario
    $rules = array(
        'nombre'                => 'required',
        'apellidos'             => 'required',
        'colectivo'             => 'required',
        'username'              => 'required|unique:users',
        'caducidad'             => 'required|date|date_format:d-m-Y|after:'. date('d-m-Y'),
        'capacidad'             => 'required|in:1,2,3,4,5',
        'email'                 => 'required|Email',
        //'password'              => 'required|min:4|alpha_num|Confirmed'
 
      );

     $messages = array(
          'required'      => 'El campo <strong>:attribute</strong> es obligatorio.',
          //'min'           => 'El campo <strong>:attribute</strong> no puede tener menos de :min carácteres.',
          //'alpha_num'     => 'El campo <strong>:attribute</strong> debe ser alfanumérico (caracteres a-z y numeros 0-9)',
          //'confirmed'     => 'Las contraseñas no coinciden',
          'date'          => 'El campo <strong>:attribute</strong> debe ser una fecha válida',
          'date_format'   => 'El campo <strong>:attribute</strong> debe tener el formato d-m-Y',
          'after'         => 'El campo <strong>:attribute</strong> debe ser una fecha posterior al día actual',
          'in'            => 'El campo <strong>:attribute</strong> debe ser administrador, gestor, usuario o invitado',
          'email'         => 'El campo <strong>:attribute</strong> debe ser una dirección de email válida',
          'unique'        => 'El username ya existe.'
        );

    $validator = Validator::make(Input::all(), $rules, $messages);
    $url = URL::route('adminAdduser.html');    
    if ($validator->fails())
      {
        return Redirect::to($url)->withErrors($validator->errors())->withInput(Input::all());;
      }
    else{  

        // salvamos los datos.....
        $user = new User;

        $user->tratamiento = Input::get('tratamiento');
        $user->nombre = Input::get('nombre'); 
        $user->apellidos = Input::get('apellidos');
        $user->colectivo = Input::get('colectivo');
        $user->email = Input::get('email');
        $user->telefono = Input::get('telefono');

        $user->username = Input::get('username'); 
       // $user->password = Hash::make(Input::get('password'));
        $user->capacidad = Input::get('capacidad');
            // La fecha se debe guardar en formato USA Y-m-d  
            $fechaCaducidad = Input::get('caducidad'); 
            $aFechaCaducidad = explode("-",$fechaCaducidad);
            $fechaUSA = $aFechaCaducidad[2] . "-" . $aFechaCaducidad[1] . "-" . $aFechaCaducidad[0];
        $user->caducidad = $fechaUSA;
        $user->estado = 1; //Activamos al crear
        $user->save();
        Session::flash('message', 'Usuario creado con éxito');
        return Redirect::to($url);

    }

  }
 

 /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */


public function formEditUser(){

    $id = Input::get('id','');

    if (empty($id)) $user = new User();
    else $user = User::find($id);

    return View::make('admin.userEdit')->with(compact('user'));
}  
  
public function updateUser(){

    
    $rules = array(
        'nombre'                => 'required',
        'apellidos'             => 'required',
        'dni'                   => '',
        'colectivo'             => 'required',
        'caducidad'             => 'required|date|date_format:d-m-Y|after:'. date('d-m-Y'),
        'capacidad'             => 'required|in:0,1,2,3',
        'email'                 => 'Email',
        //'password'              => 'sometimes|confirmed|min:4|alpha_num',
        
      );

    

    $messages = array(
            'nombre.required' => 'El campo <strong>:attribute</strong> es obligatorio.',
            'apellidos.required'=> 'El campo <strong>:attribute</strong> es obligatorio.',
            //'min'           => 'El campo <strong>:attribute</strong> no puede tener menos de :min carácteres.',
            //'alpha_num'     => 'El campo <strong>:attribute</strong> debe ser alfanumérico (caracteres a-z y numeros 0-9)',
            //'confirmed'     => 'Las contraseñas no coinciden',
            'date'          => 'El campo <strong>:attribute</strong> debe ser una fecha válida',
            'date_format'   => 'El campo <strong>:attribute</strong> debe tener el formato d-m-Y',
            'after'         => 'El campo <strong>:attribute</strong> debe ser una fecha posterior al día actual',
            'in'            => 'El campo <strong>:attribute</strong> debe ser administrador, gestor, usuario o invitado',
            'email'         => 'El campo <strong>:attribute</strong> debe ser una dirección de email válida',
            //'sometimes'     => 'El campo <strong>:attribute</strong> es obligatorio.'
        );
  
 
    $validator = Validator::make(Input::all(), $rules, $messages);

   
    if ($validator->fails())
    {
       //$url = 'admin/useredit.html?id='.$id;
        return Redirect::back()->withErrors($validator->errors());
    }
    else{  
        $id = Input::get('id','');
        
        // salvamos los datos.....
        $user = User::find($id);
        $user->apellidos = Input::get('apellidos');

        // La fecha se debe guardar en formato USA Y-m-d  
        $fechaCaducidad = Input::get('caducidad'); 
        $aFechaCaducidad = explode("-",$fechaCaducidad);
        $fechaUSA = $aFechaCaducidad[2] . "-" . $aFechaCaducidad[1] . "-" . $aFechaCaducidad[0];
        $user->caducidad = $fechaUSA;
        $user->dni = Input::get('dni'); 
        $user->capacidad = Input::get('capacidad');
        $user->colectivo = Input::get('colectivo');
        $user->email = Input::get('email');
        $user->nombre = Input::get('nombre');
        //$user->password = Hash::make(Input::get('password'));
        $user->telefono = Input::get('telefono');
        $user->tratamiento = Input::get('tratamiento');
        $user->estado = Input::get('estado','0');

        $user->save();
        Session::flash('message', 'Usuario <strong>'. $user->username .' </strong>actualizado con éxito');
        //$url = 'admin/useredit.html?id='.$id;
        return Redirect::back()->with(compact('message'));
        //return Redirect::to(route(array('post_userupdate.html', $id)));

    }
  
  }
  
 
  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    //
  }
 
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    //
  }
 
  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    //
  }
 
 
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    //
  }
 
}
