<!DOCTYPE html>
<!--
IMPORTANTE
Este proyecto ha sido creado para ser utilizado con fines interno a la empresa. Wilfredo Fermin, quien lo ha desarrollado no ha pedido ningun beneficio a cambio.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ADManager Viva</title>

    <!-- Style -->
    <link rel="stylesheet" href="/css/app.css">
</head>

<body class="sidebar-mini sidebar-collapse layout-navbar-fixed" style="height: auto" ;>

    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
					<a href="index3.html" class="nav-link">Home</a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="#" class="nav-link">Contact</a>
				</li> --}}
            </ul>

            <!-- SEARCH FORM -->
            <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- SALIR DEL SISTEMA -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ">
                    {{-- <a href=#  class="nav-link">  --}}
                    <a href=# class="nav-link  fas fa-power-off" href="{{ route('logout') }}" onclick="event.preventDefault();
														document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="/img/logoviva.png" alt="Viva Logo" class="brand-image img-circle" style="opacity: .8">
                <span class="brand-text font-weight-light">ADManager</span>
                <title>{{ config('app.name', 'Laravel') }}</title>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('img/profile/wfermin.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    {{-- INFORMACION DEL USUARIO LOGEADO --}}
                    <div class="info ">
                        <h4><a href="#" class="d-block text-center text-white ">{{ Auth::user()->nombres }} </a></h4>
                        <h5><a href="#" class="d-block text-center text-white ">{{ Auth::user()->apellidos }} </a></h5>
                        <h5><a href="#" class="d-block text-center text-sm ">{{ Auth::user()->puesto }} </a></h5>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
							 with font-awesome or any other icon font library -->

                        {{-- MENU DASHBOARD --}}
                        <li class="nav-item">
                            <router-link to="/dashboard" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    DASHBOARD
                                    {{-- <span class="right badge badge-danger">New</span> --}}
                                </p>
                                </a>
                            </router-link>
                        </li>
                        {{-- MENU PERFIL --}}
                        <li class="nav-item">
                            <router-link to="/perfil" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    PERFIL
                                    {{-- <span class="right badge badge-danger">New</span> --}}
                                </p>
                                </a>
                            </router-link>
                        </li>
                        {{-- MENU ADMINISTRAR --}}
                        <li class="nav-item has-treeview">
                            <!--Para mantener el menu contraido-->
                            {{-- <li class="nav-item has-treeview menu-open"> --}}
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    SOLICITUDES
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/serviceskit" class="nav-link">
                                        <i class="fas fa-user-check nav-icon"></i>
                                        <p>Servicekit</p>
                                        </a>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/inactivos" class="nav-link">
                                        <i class="fas fa-user-times nav-icon"></i>
                                        <p>Inactivos</p>
                                        </a>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/miembros" class="nav-link ">
                                        <i class="fas fa-user-minus nav-icon"></i>
                                        <p>Desactivos</p>
                                        </a>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <!--Para mantener el menu contraido-->
                            {{-- <li class="nav-item has-treeview menu-open"> --}}
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    ADMINISTRAR
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/miembros" class="nav-link">
                                        <i class="fas fa-user-shield nav-icon"></i>
                                        <p>Miembros</p>
                                        </a>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/permisos" class="nav-link">
                                        <i class="fas fa-user-cog nav-icon"></i>
                                        <p>Permisos</p>
                                        </a>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/entidad" class="nav-link ">
                                        <i class="fas fa-building nav-icon"></i>
                                        <p>Entidad</p>
                                        </a>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <br>
                    {{-- -----------------------CONTENIDO DINAMICO AQUI---------------------------- --}}
                    <router-view></router-view>
                    {{-- @yield('content') --}}
                    {{-- --------------------------------------------------------------------------- --}}
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            <strong>STI</strong> <small>Departamento de tecnologia</small>
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2020 <a href="https://viva.com.do">Trilogy Dominicana </a> ADManager</strong>
    </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('js/app.js') }}" defer></script>


</body>