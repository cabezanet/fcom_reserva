<!doctype html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Aplicación de reserva y gestión de espacios de la Facultad de Comunicación, Universidad de Sevilla">
    <meta name="author" content="Juan Antonio Fernández, E.E UNITIC Fcom">
    <link rel="icon" href="">


    
    <title>@yield('title')</title>
   
  
    {{HTML::style('assets/css/bootstrap.css')}}
    {{HTML::style('assets/css/bootstrap-table.css')}}

    
        
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('calendar-css')
    @yield('head')

</head>
<body>
<div class = "col-md-8">

<table data-toggle="table"
       data-url="{{route('dataTest');}}"
       data-pagination="true"
       data-side-pagination="server"
       data-page-list="[10, 20, 50, 100, 200]"
       data-search="true"
       data-height="520">
    <thead>
    <tr>
        <th data-field="state" data-checkbox="true"></th>
        
        <th data-field="id" data-align="right" data-sortable="true">Item ID</th>
        <th data-field="actividad" data-align="center" data-sortable="true">Actividad</th>
        <th data-field="titulo" data-sortable="true">Título</th>
    </tr>
    </thead>
</table>

</div>
<script src="assets/js/jquery-1.11.0.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstraptable/bootstrap-table.js"></script>
<script src="assets/js/table.js"></script>
</body>


</html>