<!DOCTYPE HTML>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js"><!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,target-densitydpi=device-dpi, user-scalable=no" />
	<link rel="icon" href="images/favicon.png?v=2" type="image/png" />
    <meta name="description" content="Backend UI" />
    <meta name="author" content="SPADA Digital Consulting" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>SPADA Backend UI | {{ $data['title'] }}</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css"/>
	<link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}" type="text/css" media="screen">
	<link rel="stylesheet" href="{{ asset('assets/css/grid.css') }}" type="text/css" media="screen">
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css" media="screen">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}" type="text/css" media="screen">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.css"/>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.js"></script>
    <style>
        .card{
            color:black;background:white;padding:15px;border-radius:10px
        }
        .btn-warning{
            color: black !important;
        }
        .btn-success{
            color: white !important;
        }
        label{
            color: black;
        }
        .modal-dialog {
            padding-top: 10%;
        }
    </style>
</head>
<body>
    <?php
        use App\Menu;
    ?>
    <div id="main" class="group">
        <div id="left-panel" class="col">
            <div id="logo">
                <img src="{{ asset('assets/images/logo.png') }}">
            </div>
            <div id="left-navigation">
                <ul class="main-menu">
                    <li class="menu-item">
                        <a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    </li>
                    @php
                        $menuParent = Menu::where(['menuParent' => 0])->orderBy('menuName','asc')->get();
                    @endphp
                    @foreach ($menuParent as $mp)
                        @php
                            $subMenu = Menu::where(['menuParent' => $mp->menuId])->orderBy('menuName','asc')->get();
                        @endphp
                        <li class="menu-item">
                            <a href="#"><i class="fas {{ $mp->menuIcon }}"></i>{{ $mp->menuName }}</a>
                            <ul class="sub-menu">
                                @foreach ($subMenu as $sm)
                                    <li class="sub-menu-item">
                                        <a href="{{ url('admin/'.$sm->menuUrl) }}">{{ $sm->menuName }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div id="content" class="group">
            <div id="top-panel">
                <div class="top-wrapper">
                    <div id="page-title" class="left">
                        <h1>{{ $data['title'] }}</h1>
                    </div>
                    <div id="user-account" class="right">
                        <a href="#"><span>{{ session('adminName') }}</span><img src="images/user.png"></a>
                    </div>
                    <div id="notification" class="right">
                        <a href="#"><i class="fas fa-bell"></i></a>
                    </div>
                    <div id="search-panel" class="right">
                        <form>
                            <input type="text" name="search" placeholder="Search">
                            <span>
                                <input type="button" value="">
                                <i class="fas fa-search"></i>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
            <div id="content-wrapper" class="group">