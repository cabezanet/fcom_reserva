@extends('adminlayout')

@section('title')
    Acceso para administradores: Gestión de Usuarios
@stop



@section('content')

  
<div class="col-lg-12">
    <h1 class="page-header">Logs</h1>
</div>
<!-- /.col-lg-12 -->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <i class="fa fa-files-o fa-fw"></i> Logs
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        
                        <div class="row">
                            
                            <div class="col-sm-6">
                                <div id="dataTables-example_length" class="dataTables_length">
                                    <label>
                                        <select class="form-control input-sm" aria-controls="dataTables-example" name="dataTables-example_length">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> Registros por página
                                    </label>
                                </div>                                
                            </div>

                            <div class="col-sm-6">
                                <div class="dataTables_filter" id="dataTables-example_filter">
                                    <label class="pull-right">Search:
                                        <input aria-controls="dataTables-example" class="form-control input-sm" type="search">
                                    </label>
                                </div>                            
                            </div>

                        
                        </div>
                        
                        <table aria-describedby="dataTables-example_info" class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example">
                            <thead>
                                <tr role="row">
                                    <th aria-label="Rendering engine: activate to sort column ascending" aria-sort="ascending" style="width: 215px;" colspan="1" rowspan="1" aria-controls="dataTables-example" tabindex="0" class="sorting_asc">Fecha
                                    </th>
                                    <th aria-label="Browser: activate to sort column ascending" style="width: 295px;" colspan="1" rowspan="1" aria-controls="dataTables-example" tabindex="0" class="sorting">Susceso
                                    </th>
                                    <th aria-label="Platform(s): activate to sort column ascending" style="width: 276px;" colspan="1" rowspan="1" aria-controls="dataTables-example" tabindex="0" class="sorting">usuario
                                    </th>
                                    <th aria-label="Engine version: activate to sort column ascending" style="width: 184px;" colspan="1" rowspan="1" aria-controls="dataTables-example" tabindex="0" class="sorting">lorem ipsum....</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <td>
                                    lorem ipsum....
                                    </td>
                                    <td>
                                        lorem ipsum....
                                    </td>
                                    <td>
                                        lorem ipsum....
                                    </td>
                                    <td>
                                        lorem ipsum....
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>                    
                    
                    </div>
                </div>
            </div>

        </div>
        <!-- /.panel-default -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->    
    
                     
@stop