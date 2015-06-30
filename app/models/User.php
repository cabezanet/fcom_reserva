<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface{

	protected $table = 'users';
	public $timestamps = true;
	protected $softDelete = false;
	//protected $hidden = array('password');

	//devuelve los recurso que valida
	public function supervisa()
    {
        return $this->belongsToMany('Recurso');
    }

    //devuelve los eventos del usuario
	public function userEvents(){

		return $this->hasMany('Evento','user_id');
	
	}

	public function rol(){
		return $this->belongsTo('Role','capacidad');
	}
	

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		//return $this->password;
		return null;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function getRememberToken()
	{
	    //return $this->remember_token;
	    return null;
	}

	public function setRememberToken($value)
	{
	   // $this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
	    //return 'remember_token';
	    return null;
	}

	/*
  		* Overrides the method to ignore the remember token.
  	*/
 	public function setAttribute($key, $value)
 	{
	   $isRememberTokenAttribute = $key == $this->getRememberTokenName();
	   if (!$isRememberTokenAttribute)
	   {
	     parent::setAttribute($key, $value);
	   }
	}


	public function getHorasReservadas($tsFechaInicio,$tsFechaFin){
			
			$events = array();
			$horas = 0;


			$events = $this->userEvents()->where('fechaEvento','>=',date('Y-m-d',$tsFechaInicio))->where('fechaEvento','<=',date('Y-m-d',$tsFechaFin))->get();
			
			foreach ($events as $key => $event) {
				$horas = $horas + sgrFechas::horas($event->horaInicio,$event->horaFin);
			}

			return $horas;
	}



	public function getNamePerfil(){
		
		
		switch ($this->capacidad) {
			case '3':
				return 'Administrador';
			case '2':
				return 'Técnico';
			case '1':
				return 'Usuario';
			default:
				return 'No definido..';
			}
	}

	
	public function getHome(){
		
		switch ($this->capacidad) {
			case '5': //validador
				return route('validadorHome.html');
			case '4': //root
				return route('adminHome.html');
			case '3': //pas - técnico
				return route('tecnicoHome.html');
			case '2': //pdi
				return route('calendarios.html');
			case '1': //alumno
				return route('calendarios.html');
			default:
				return 'No definido..';
			}

	}

}