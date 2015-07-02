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
    

    {{HTML::style('assets/css/datepicker.css')}}
    {{HTML::style('assets/css/stilo.css')}}
    {{HTML::style('assets/css/plugins/metisMenu/metisMenu.min.css')}}
    {{HTML::style('assets/css/plugins/timeline.css')}}
    {{HTML::style('assets/css/sb-admin-2.css')}}
    {{HTML::style('assets/css/plugins/morris.css')}}
    {{HTML::style('assets/font-awesome-4.1.0/css/font-awesome.min.css')}}
        
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('calendar-css')
    @yield('head')

</head>
<body>
<div id="wrapper">

  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
     
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="">UNITIC fcom</a>
    </div>
    <!-- /.navbar-header -->
     
    <ul class="nav navbar-top-links navbar-right">
      
        <li class="dropdown"><a href="#about">Ayuda</a></li>
        <li class="dropdown"><a href="#contact">Contacto</a></li>
        @if (Auth::check())
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{Auth::user()->nombre}} {{Auth::user()->apellidos}}  <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-user">
            <li>
              <a class="active" href="{{route('adminHome.html');}}"><i class="fa fa-dashboard fa-fw"></i> Escritorio
            </li>
                <li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil</a>
                </li>
                <li class="divider"></li>
                <li><a href="{{URL::route('logout')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
          </ul>
          <!-- /.dropdown-user -->
        </li>
        @endif
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->    
   
    <div class="navbar-default sidebar" role="navigation">
      <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
          <li>
            <a  href="home.html"><i class="fa fa-dashboard fa-fw"></i> Escritorio</a>
          </li>

          <li>
            <a href="{{route('calendarios.html')}}"><i class="fa fa-calendar fa-fw"></i> Reservas</a>
          </li>
          <li>
            <a href="{{route('pod.html')}}"><i class="fa fa-upload fa-fw"></i> P.O.D</a>
          </li>

          <li>
           <a  href="#"><i class="fa fa-user fa-fw"></i> Usuarios<span class="fa arrow"></span></a>
           <ul class="nav nav-second-level">
            <li>
              <a  href="adduser.html"><i class="fa fa-plus fa-fw"></i> Nuevo</a>
            </li>
            <li>
              <a  href="searchuser.html"><i class="fa fa-search fa-fw"></i> Buscar</a>
            </li>
            <li>
              <a href="users.html"><i class="fa fa-list fa-fw"></i> Listar</a>
            </li>
            
           </ul>
          <!-- /.nav-second-level -->
          </li>
          
          <li>
            <a href="config.html"><i class="fa fa-wrench fa-fw"></i> Configuración</a>
          </li>
          
          <li>
            <a  href="logs.html"><i class="fa fa-files-o fa-fw"></i> Logs</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- /.navbar-static-side -->
  </nav>

  <div id="page-wrapper">
    @yield('content')


   </div>
  <!-- /#page-wrapper -->


</div>
<div class ="row col-lg-12  col-xs-12 text-right" id ="credits">
        <div class="">
        <a href="http://fcom.us.es" alt="Facultad de Comunicación"><img src = "{{ asset('assets/img/logofcom.png') }}"></a>
        &nbsp;&nbsp;&nbsp;<a href="http://www.us.es" alt="Universidad de Sevilla"><img src = "{{ asset('assets/img/logo_us.jpg') }}"></a>
        </div>
           
      <div class="">
        Developed by UNITIC Facultad de Comunicación. Universidad de Sevilla.
      </div>
   
    </div>
    <!-- /#wrapper -->
    @yield('calendar-js')
    <!--  {{HTML::script('assets/js/jquery-1.11.0.js')}}
      {{HTML::script('assets/js/bootstrap.min.js')}}
      {{HTML::script('assets/js/plugins/metisMenu/metisMenu.js')}}
    
      {{HTML::script('assets/js/plugins/morris/raphael.min.js')}}
      {{HTML::script('assets/js/plugins/morris/morris.js')}}
     
      {{HTML::script('assets/js/sb-admin-2.js')}}

-->
<script src="../assets/js/jquery-1.11.0.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>

<script src="../assets/js/plugins/metisMenu/metisMenu.js"></script>


<script src="../assets/js/sb-admin-2.js"></script>
<script src="../assets/js/notificaciones.js"></script>
</body>
</html>