<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>@yield('title') | PT. Patria Maritim Perkasa</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset ('assets/images/favicon.ico' ) }}">

        <!-- Sweet Alert-->
        <link href="{{ asset ('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- jquery.vectormap css -->
        {{-- <link href="{{ asset ('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css' ) }}" rel="stylesheet" type="text/css" /> --}}

        <!-- DataTables -->
        {{-- <link href="{{ asset ('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css' ) }}" rel="stylesheet" type="text/css" /> --}}

        <!-- Responsive datatable examples -->
        <link href="{{ asset ('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css' ) }}" rel="stylesheet" type="text/css" />  

        <!-- Bootstrap Css -->
        <link href="{{ asset ('assets/css/bootstrap.min.css' ) }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset ('assets/css/icons.min.css' ) }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset ('assets/css/app.min.css' ) }}" id="app-style" rel="stylesheet" type="text/css" />

        @livewireStyles
    </head>

    <body data-sidebar="light" data-keep-enlarged="true" class="vertical-collpsed">

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <header id="page-topbar">
                @include('components.navbar')
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!-- User details -->
                    {{-- <div class="user-profile text-center mt-3">
                        <div class="">
                            <img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-md rounded-circle">
                        </div>
                        <div class="mt-3">
                            <h4 class="font-size-16 mb-1">Julia Hudda</h4>
                            <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i> Online</span>
                        </div>
                    </div> --}}

                    <!--- Sidemenu -->
                    @include('components.sidebar')
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">@yield('title')</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                            <li class="breadcrumb-item active">@yield('title')</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        @yield('content')
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                @include('components.footer')
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- JAVASCRIPT -->
        <script src="{{ asset ('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset ('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset ('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset ('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset ('assets/libs/node-waves/waves.min.js') }}"></script>

        <!-- apexcharts -->
        {{-- <script src="{{ asset ('assets/libs/apexcharts/apexcharts.min.js') }}"></script> --}}

        <!-- jquery.vectormap map -->
        {{-- <script src="{{ asset ('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset ('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script> --}}

        <!-- Required datatable js -->
        <script src="{{ asset ('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset ('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        
        <!-- Responsive examples -->
        <script src="{{ asset ('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset ('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

        {{-- <script src="{{ asset ('assets/js/pages/dashboard.init.js') }}"></script> --}}

        <script src="{{ asset ('assets/js/app.js') }}"></script>

        <script src="{{ asset ('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

        <script src="{{ asset ('assets/libs/parsleyjs/parsley.min.js') }}"></script>

        @livewireScripts
    </body>
</html>
