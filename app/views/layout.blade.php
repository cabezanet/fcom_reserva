<!doctype html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Aplicación de reserva y gestión de espacios de la Facultad de Comunicación, Universidad de Sevilla">
    <meta name="author" content="Juan Antonio Fernández, E.E UNITIC Fcom">
    <link rel="icon" href="">


    @yield('title')
    
   
  
    {{HTML::style('assets/css/bootstrap.css')}}
    <!--{{HTML::style('assets/css/bootstrap-theme.css')}}-->
    {{HTML::style('assets/css/datepicker.css')}}
    <!--{{HTML::style('assets/css/normalize.css')}}-->
    {{HTML::style('assets/css/stilo.css')}}
    <!--
    {{HTML::style('assets/css/starter-template.css')}}
    {{HTML::style('assets/css/dashboard.css')}}
   -->
   <!-- MetisMenu CSS -->
   {{HTML::style('assets/css/plugins/metisMenu/metisMenu.min.css')}}

    <!-- Timeline CSS -->
    {{HTML::style('assets/css/plugins/timeline.css')}}

    {{HTML::style('assets/css/sb-admin-2.css')}}
     <!-- Morris Charts CSS -->
   
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
  
<div class="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
           
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{URL::route('inicio')}}">UNITIC fcom</a>
            </div>
            <!-- /.navbar-header -->
           
            <ul class="nav navbar-top-links navbar-right">

                    <li><a href="#about">Ayuda</a></li>
                    <li><a href="#contact">Contacto</a></li>
                    
                   </ul>
                    <!-- /.navbar-top-links -->    
        </nav>

@yield('content')

<div class ="row">
    <div class="col-lg-12  col-xs-12 text-right" id="credits">
          <a href="http://fcom.us.es" alt="Facultad de Comunicación"><img src = "{{ asset('assets/img/logofcom.png') }}"></a>
          &nbsp;&nbsp;&nbsp;<a href="http://www.us.es" alt="Universidad de Sevilla"><img src = "{{ asset('assets/img/logo_us.jpg') }}"></a>
          <div class="">
                Developed by UNITIC Facultad de Comunicación. Universidad de Sevilla.
          </div>
    </div>

</div>


    <script src="//code.jquery.com/jquery-1.11.1.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.js"></script>


    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../assets/js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../../assets/js/plugins/morris/raphael.min.js"></script>
    <script src="../../assets/js/plugins/morris/morris.min.js"></script>
    <script src="../../assets/js/plugins/morris/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../assets/js/sb-admin-2.js"></script>



    @yield('calendar-js')
</body>

</html>