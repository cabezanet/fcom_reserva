<?php

class recursosController extends BaseController {

	public function listRecursos(){
      
      $sortby = Input::get('sortby','nombre');
      $order = Input::get('order','asc');
      $offset = Input::get('offset','10');
      $keySearch = Input::get('id_recurso','0');

      $recursos = User::find(Auth::user()->id)->supervisa()->orderby($sortby,$order)->paginate($offset);
      $grupos = User::find(Auth::user()->id)->supervisa()->groupby('grupo')->paginate($offset);

      //$recursos = Recurso::orderby($sortby,$order)->paginate($offset);

      return View::make('tecnico.espacios')->with(compact('grupos','recursos','sortby','order'));
  }

	

}