<?php

class sgrMail{

	

    /**
     *
     * @param $to (string)
     * @param $subject (string)
     * @param $view (string) -vista para construir el cuerpo del mensaje
     * @param $data (array) -datos para la vista-
     * Si se envia el correo correctamente se devuelve true
     * false en caso contrario
     * @return void
    */
    public static function send($to,$subject,$view,$data){

		
		Mail::queue(array('html' => $view), array(), function($message) use ($to,$subject)
			{
				$message->to($to)->subject($subject);
			});
	
		return true;
	}

}


?>