<?php

class Recurso extends Eloquent {

 	protected $table = 'recursos';

 	protected $fillable = array('acl', 'admin_id','descripcion','nombre', 'tipo');

	public function validadores()
    {
        return $this->belongsToMany('User');
    }

    public function supervisores()
    {
        return $this->belongsToMany('User','supervisores')->withPivot('requireMail');
    }

    

    public function events(){

        //recurso_id -> foreign_key
        //id -> local_key
        return $this->hasMany('Evento','recurso_id','id');
    
    }

 
    public function scopetipoDesc($query)
    {
        return $query->orderBy('tipo','DESC');
    }

	public function scopegrupoDesc($query)
    {
        return $query->orderBy('grupo','DESC');
    }   
 


}