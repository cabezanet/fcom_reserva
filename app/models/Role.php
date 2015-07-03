<?php
	class Role extends Eloquent{

 		protected $table = 'roles';

 		public function usuarios()
    	{
        	return $this->hasMany('User');
    	}

 }
?>