<?php
	class GrupoRecurso extends Eloquent{

 		protected $table = 'grupoRecursos';

 		public function recursos()
    	{
        	return $this->hasMany('Recurso','grupo_id','id');
    	}

 }
?>