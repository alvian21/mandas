<!-- light-blue - v4.0.2 - 2020-12-08 -->

<!DOCTYPE html>
<html>

<head>
    <title>Mandas - Dashboard</title>

    <link href="{{asset('assets/css/application.css')}}" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Light Blue Dashboard - Bootstrap Admin Template">
    <meta name="keywords"
        content="bootstrap admin template,admin template,admin dashboard,admin dashboard template,admin,dashboard,bootstrap,template">
    <meta name="author" content="Flatlogic LLC">
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script>

    </script>
</head>

<body>
    <div class="logo">
        <h5><strong>PT. INDOSPRING, Tbk.</strong></h5>
    </div>
    <nav id="sidebar" class="sidebar nav-collapse collapse">
        @include('dashboard.include.sidebar')
    </nav>
    <div class="wrap">
        <header class="page-header">
            <div class="navbar">
                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="visible-phone-landscape">
                        <a href="#" id="search-toggle">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>


                   
                    <li class="hidden-xs">
                        <a href="#" id="settings" title="Settings" data-toggle="popover" data-placement="bottom">
                            <i class="glyphicon glyphicon-cog"></i>
                        </a>
                    </li>

                    <li class="visible-xs">
                        <a href="#" class="btn-navbar" data-toggle="collapse" data-target=".sidebar" title="">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                    <li class="hidden-xs"><a href="login.html"><i class="glyphicon glyphicon-off"></i></a></li>
                </ul>

            </div>
        </header>
        <div class="content container">
            @yield('content')
            @include('dashboard.include.footer')
        </div>
        <div class="loader-wrap hiding hide">
            <i class="fa fa-circle-o-notch fa-spin"></i>
        </div>
    </div>
    @include('dashboard.include.script')
    @stack('script')
</body>

</html>
