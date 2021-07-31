<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartWarehouse') }}</title>


    <link rel="icon" href="/dist/img/Sw2021.png" type="image/gif" sizes="16x16">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    @yield('css')
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="/dist/img/Sw2021.png" alt="SWLogo" height="200" width="200">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="/dist/img/Sw2021.png" alt="SWLogo" class="brand-image img-circle elevation-3" >
            <span class="brand-text font-weight-light">SmartWarehouse</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <p class="d-block">{{ Auth::user()->name.' '.Auth::user()->last_name.' '.'('.Auth::user()->role->name.')' }}</p>
                    <a class="dropdown-item text-white" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        {{ __('Cerrar sesión') }}
                    </a>
                    <a class="dropdown-item text-white" href="cambio-contraseña">
                        Cambiar contraseña
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    @if (auth()->user()->hasRoles(['Administrador']))
{{--                     <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li> --}}
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('productos') }}" class="nav-link">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>
                                Productos
                            </p>
                        </a>
                    </li>
                    @if (auth()->user()->hasRoles(['Administrador']))
                    <li class="nav-item">
                        <a href="{{ route('proveedores') }}" class="nav-link">
                            <i class="nav-icon fas fa-truck-loading"></i>
                            <p>
                                Proveedores
                            </p>
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-file-alt nav-icon"></i>
                            <p>
                                Ordenes de compra
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('nueva-orden') }}" class="nav-link">
                                    <i class="fas fa-file-medical    nav-icon"></i>
                                    <p>Nueva orden de compra</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('estado-oc') }}" class="nav-link">
                                    <i class="fas fa-file-signature nav-icon"></i>
                                    <p>Estado de pago OC</p>
                                    <i class="right fas fa-angle-left"></i>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('estado-oc') }}" class="nav-link">
                                           <p>Pendientes de pago</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('oc-pagadas') }}" class="nav-link">                                          
                                            <p>Ordenes pagadas</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @if (auth()->user()->hasRoles(['Administrador']))
                    <li class="nav-item">
                        <a href="{{ route('auditoria') }}" class="nav-link">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>
                                Auditoría
                            </p>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
{{--                        <h1 class="m-0">{{ Route::currentRouteName() }}</h1>--}}
                    </div><!-- /.col -->
                    <div class="col-sm-6">
<!--                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v2</li>
                        </ol>-->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
                <div id="app">
                    @yield('components')
                </div>
            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2020-2021 <a href="#">SmartWarehouse</a>.</strong>
        <div class="float-right d-none d-sm-inline-block">
{{--            <b>Version</b> 0.5.0--}}
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="/js/app.js"></script>
<script src="/plugins/jquery/jquery.min.js"></script>
@yield('scripts')
<!-- Bootstrap -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- ChartJS -->
<script src="/plugins/chart.js/Chart.min.js"></script>
</body>
</html>
