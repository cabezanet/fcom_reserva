@extends('admin.layout')

@section('title')
    Acceso para administradores: Gestión de Usuarios
@stop



@section('content')

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><i class="fa fa-users fa-fw"></i> Gestión de Usuarios</h3>
    </div>
</div>


<div class="row">
    
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h4><i class="fa fa-list fa-fw"></i> Listar</h4>
            </div>

            <div class="panel-body">
                        
                        <div class="row">
                        <form>
                        
                            
                            <div class="col-sm-2 form-group">
                                
                                        <label>Registros por página</label>
                                        <select class="form-control">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> 
                                
                                
                            </div>

                          
                            <div class="col-sm-6 col-sm-offset-4 form-group"> 
                                
                                <div class="col-sm-3 col-sm-offset-6 form-group">   
                                <input type="text" class="form-control" id="search" placeholder="Buscar por dni...." name="search" >
                                </div>
                                
                                <div class="col-sm-3 form-group">   
                                <button type="submit" class="btn btn-primary "><i class="fa fa-search fa-fw"></i> Buscar</button> 
                                </div>

                            </div>                            
                        </form>

                            </div>

                        
                      
                
                <table class="table table-hover table-striped">
                    <thead>
                        
                        <th  style="width: 30%;">
                        @if ($sortby == 'username' && $order == 'asc') {{
                                link_to_action(
                                    'UsersController@listUsers',
                                    'Username',
                                    array(
                                        'sortby' => 'username',
                                        'order' => 'desc'
                                        )
                                    )
                               }}
                            @else {{
                                link_to_action(
                                   'UsersController@listUsers',
                                        'Username',
                                        array(
                                            'sortby' => 'username',
                                            'order' => 'asc',
                                            
                                        )
                                    )
                                }}
                            @endif
                            <i class="fa fa-sort fa-fw text-info"></i>

                        </th>
                        <th style="width: 40%;">
                         @if ($sortby == 'apellidos' && $order == 'asc') {{
                                link_to_action(
                                    'UsersController@listUsers',
                                    'Apellidos, nombre',
                                    array(
                                        'sortby' => 'apellidos',
                                        'order' => 'desc'
                                        )
                                    )
                               }}
                            @else {{
                                link_to_action(
                                   'UsersController@listUsers',
                                        'Apellidos, nombre',
                                        array(
                                            'sortby' => 'apellidos',
                                            'order' => 'asc',
                                            
                                        )
                                    )
                                }}
                            @endif
                            <i class="fa fa-sort fa-fw text-info"></i>
                     

                        </th>
                        
                        <th style="width: 30%;">
                            @if ($sortby == 'colectivo' && $order == 'asc') {{
                                link_to_action(
                                    'UsersController@listUsers',
                                    'Colectivo',
                                    array(
                                        'sortby' => 'colectivo',
                                        'order' => 'desc'
                                        )
                                    )
                               }}
                            @else {{
                                link_to_action(
                                   'UsersController@listUsers',
                                        'Colectivo',
                                        array(
                                            'sortby' => 'colectivo',
                                            'order' => 'asc',
                                            
                                        )
                                    )
                                }}
                            @endif
                            <i class="fa fa-sort fa-fw text-info"></i>
                            </th>
                            
                    </thead>
                    <tbody>
                         @foreach($usuarios as $user)
                                <tr>

                                    <td>
                                        {{HTML::link('admin/useredit.html?id='.$user->id , $user->username)}}
                                    </td>
                                    <td>
                                        {{$user->nombre.' '.$user->apellidos}}
                                    </td>
                                    
                                    <td>
                                        {{$user->colectivo}}
                                    </td>
                                </tr>
                                 @endforeach
                    </tbody>
                    </table>

                {{$usuarios->appends(Input::except('page','result'))->links();}}
                
            </div><!-- /.panel-body -->

        </div>
        <!-- /.panel-default -->
    
</div>
<!-- /.row -->    
    
                     
@stop