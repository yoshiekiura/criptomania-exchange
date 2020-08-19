@include('backend.layouts.includes._header')

<body class="">
    <div class="wrapper" id="app">
        @include('backend.layouts.includes._top_navigation_header')
        <!-- Left side column. contains the logo and sidebar -->
        <div class="settings mtb15">
            <div class="container-fluid">
                <div class="row">
                    @include('backend.layouts.includes._sidebar')

                    <!-- Content Wrapper. Contains page content -->
                    <div class="content-wrapper">
                        <!-- Content Header (Page header) -->
                        @include('backend.layouts.includes._content_header')


                        <!-- Main content -->
                        <section class="content">
                            @yield('content')
                        </section>
                        <!-- /.content -->
                        <!-- Extended content -->
                        @yield('extended-content')
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
        @include('backend.layouts.includes._footer')