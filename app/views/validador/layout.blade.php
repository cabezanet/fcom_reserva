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
    

    
    {{HTML::style('assets/css/stilo.css')}}
    {{HTML::style('assets/css/sb-admin-2.css')}}
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
              <a class="active" href="{{route('validadorHome.html');}}"><i class="fa fa-dashboard fa-fw"></i> Escritorio
            </li>
                <li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil</a>
                </li>
                <li class="divider"></li>
                <li><a href="{{URL::route('salir')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
            <a  href="home.html"><i class="fa fa-dashboard "></i> Escritorio</a>
          </li>

          <li>
            <a href="{{route('calendarios.html')}}"><i class="fa fa-calendar fa-fw"></i> Añadir Reserva</a>
          </li>
          
          <li>
            <a  href=""><i class="fa fa-check"></i> Validaciones</a>
          </li>
          
          
          <li>
            <a  href=""><i class="fa fa-files-o fa-fw"></i> Logs</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- /.navbar-static-side -->
  </nav>

  @yield('modal')
  <div id="page-wrapper">
    @yield('content')
   </div>
  <!-- /#page-wrapper -->


</div>
    <!-- /#wrapper -->
<script src="../assets/js/jquery-1.11.0.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/plugins/metisMenu/metisMenu.js"></script>
<script src="../assets/js/sb-admin-2.js"></script>
<script src="../assets/js/validador.js"></script>

@yield('js')
</body>
</html>