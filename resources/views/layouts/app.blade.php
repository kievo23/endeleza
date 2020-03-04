<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- Favicon icon -->
    <link rel="icon" href="\assets\images\favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Manjari|Montserrat&display=swap" rel="stylesheet">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components\bootstrap\css\bootstrap.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets\icon\feather\css\feather.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets\icon\font-awesome\css\font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets\icon\material-design\css\material-design-iconic-font.min.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets\css\style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets\css\jquery.mCustomScrollbar.css') }}">
    @yield('assets')
</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            @if(Auth::check())
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">

                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu"></i>
                        </a>
                        <a href="index-1.htm">
                            <img class="img-radius" src="\assets\images\Endeleza.png" width="50px" alt="Endeleza-Logo">
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="feather icon-maximize full-screen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">

                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="\assets\images\user2.png" class="img-radius" alt="User-Profile-Image">
                                        <span>{{Auth::user()->email}}</span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <a href="#!">
                                                <i class="feather icon-settings"></i> Settings
                                            </a>
                                        </li>
                                        <li>
                                            <a href="user-profile.htm">
                                                <i class="feather icon-user"></i> Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                <i class="feather icon-log-out"></i>{{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            @endif
            <!-- Sidebar chat start -->
            <div id="sidebar" class="users p-chat-user showChat">
                <div class="had-container">
                    <div class="card card_main p-fixed users-main">
                        <div class="user-box">
                            <div class="chat-inner-header">
                                <div class="back_chatBox">
                                    <div class="right-icon-control">
                                        <input type="text" class="form-control  search-text" placeholder="Search Friend" id="search-friends">
                                        <div class="form-icon">
                                            <i class="icofont icofont-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-friend-list">
                                <div class="media userlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius img-radius" src="\assets\images\avatar-3.jpg" alt="Generic placeholder image ">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Josephin Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="2" data-status="online" data-username="Lary Doe" data-toggle="tooltip" data-placement="left" title="Lary Doe">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="\assets\images\avatar-2.jpg" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Lary Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice" data-toggle="tooltip" data-placement="left" title="Alice">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="\assets\images\avatar-4.jpg" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alice</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="4" data-status="online" data-username="Alia" data-toggle="tooltip" data-placement="left" title="Alia">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="\assets\images\avatar-3.jpg" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alia</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="5" data-status="online" data-username="Suzen" data-toggle="tooltip" data-placement="left" title="Suzen">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="\assets\images\avatar-2.jpg" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Suzen</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar inner chat start-->
            <div class="showChat_inner">
                <div class="media chat-inner-header">
                    <a class="back_chatBox">
                        <i class="feather icon-chevron-left"></i> Josephin Doe
                    </a>
                </div>
                <div class="media chat-messages">
                    <a class="media-left photo-table" href="#!">
                        <img class="media-object img-radius img-radius m-t-5" src="\assets\images\avatar-3.jpg" alt="Generic placeholder image">
                    </a>
                    <div class="media-body chat-menu-content">
                        <div class="">
                            <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                            <p class="chat-time">8:20 a.m.</p>
                        </div>
                    </div>
                </div>
                <div class="media chat-messages">
                    <div class="media-body chat-menu-reply">
                        <div class="">
                            <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                            <p class="chat-time">8:20 a.m.</p>
                        </div>
                    </div>
                    <div class="media-right photo-table">
                        <a href="#!">
                            <img class="media-object img-radius img-radius m-t-5" src="\assets\images\avatar-4.jpg" alt="Generic placeholder image">
                        </a>
                    </div>
                </div>
                <div class="chat-reply-box p-b-20">
                    <div class="right-icon-control">
                        <input type="text" class="form-control search-text" placeholder="Share Your Thoughts">
                        <div class="form-icon">
                            <i class="feather icon-navigation"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar inner chat end-->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigatio-lavel">Navigation</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="{!! Request::is('/') ? 'active' : '' !!}">
                                    <a href="{{url('/')}}">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                </li>
                                <!-- <li class="pcoded-hasmenu {!! Request::is('persons*') ? 'active' : '' !!}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                        <span class="pcoded-mtext">Persons</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="{{url('/persons')}}">
                                                <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                                <span class="pcoded-mtext">Persons List</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('/persons/create')}}">
                                                <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                                <span class="pcoded-mtext">Create Person</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li> -->
                                <li class="{!! Request::is('persons*') ? 'active' : '' !!}">
                                    <a href="{{url('/persons')}}">
                                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                        <span class="pcoded-mtext">Persons</span>
                                    </a>
                                </li>
                                <!-- <li class="pcoded-hasmenu {!! Request::is('customers*') ? 'active' : '' !!}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-user-check"></i></span>
                                        <span class="pcoded-mtext">Customers</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="{{url('/customers')}}">
                                                <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                                <span class="pcoded-mtext">Customers List</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('/customers/create')}}">
                                                <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                                <span class="pcoded-mtext">Create Customer</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li> -->
                                <li class="{!! Request::is('customers*') ? 'active' : '' !!}">
                                    <a href="{{url('/customers')}}">
                                        <span class="pcoded-micon"><i class="feather icon-user-check"></i></span>
                                        <span class="pcoded-mtext">Customers</span>
                                    </a>
                                </li>
                                <!-- <li class="pcoded-hasmenu {!! Request::is('agents*') ? 'active' : '' !!}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-user-plus"></i></span>
                                        <span class="pcoded-mtext">Agents</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="{{url('/agents')}}">
                                                <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                                <span class="pcoded-mtext">Agents List</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('/agents/create')}}">
                                                <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                                <span class="pcoded-mtext">Create Agent</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li> -->
                                <li class="pcoded-hasmenu {!! Request::is('loan_accounts*') ? 'active' : '' !!}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-trending-up"></i></span>
                                        <span class="pcoded-mtext">Loan Accounts</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="{{ url('loan_accounts') }}">
                                                <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                                <span class="pcoded-mtext">All </span>
                                            </a>
                                        </li> 
                                        <li class="">
                                            <a href="{{ url('loan_accounts/pending') }}">
                                                <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                                <span class="pcoded-mtext">Active Loans</span>
                                            </a>
                                        </li>                                       
                                        <li class="">
                                            <a href="{{ url('loan_accounts/fullypaid') }}">
                                                <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                                <span class="pcoded-mtext">Paid Loans</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{ url('loan_accounts/today') }}">
                                                <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                                <span class="pcoded-mtext">Today</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{ url('loan_accounts/yesterday') }}">
                                                <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                                <span class="pcoded-mtext">Yesterday</span>
                                            </a>
                                        </li>
                                        <!-- <li class="">
                                            <a href="{{ url('loan_accounts/pendingBelow/3') }}">
                                                <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                                <span class="pcoded-mtext">Below 3 days</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{ url('loan_accounts/pendingBelow/6') }}">
                                                <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                                <span class="pcoded-mtext">3-6 days</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{ url('loan_accounts/pendingBelow/10') }}">
                                                <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                                <span class="pcoded-mtext">6-10 days</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{ url('loan_accounts/pendingBelow/15') }}">
                                                <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                                <span class="pcoded-mtext">10-15 days</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{ url('loan_accounts/pendingBelow/30') }}">
                                                <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                                <span class="pcoded-mtext">15-30 days</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{ url('loan_accounts/pendingAbove30') }}">
                                                <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                                <span class="pcoded-mtext">Above 30 days</span>
                                            </a>
                                        </li> -->
                                    </ul> 
                                </li>

                                <li class="{!! Request::is('loan_requests*') ? 'active' : '' !!}">
                                    <a href="{{ url('loan_requests') }}">
                                        <span class="pcoded-micon"><i class="feather icon-message-square"></i></span>
                                        <span class="pcoded-mtext">Loan Requests</span>
                                    </a>
                                </li>
                                <li class="pcoded-hasmenu {!! Request::is('transactions*') ? 'active' : '' !!}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-trending-up"></i></span>
                                        <span class="pcoded-mtext">Transactions</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="{{url('transactions')}}">
                                                <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                                <span class="pcoded-mtext">All Transactions</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('transactionQuery')}}">
                                                <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                                <span class="pcoded-mtext">Query Transaction</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('transactions/suspense')}}">
                                                <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                                <span class="pcoded-mtext">Suspense Transactions</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="{!! Request::is('online_checkout*') ? 'active' : '' !!}">
                                    <a href="{{ url('online_checkout') }}">
                                        <span class="pcoded-micon"><i class="feather icon-at-sign"></i></span>
                                        <span class="pcoded-mtext">Online Checkout</span>
                                    </a>
                                </li>
                                <li class="pcoded-hasmenu {!! Request::is('user*') ? 'active' : '' !!}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                        <span class="pcoded-mtext">Users</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="{{url('/users')}}">
                                                <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                                <span class="pcoded-mtext">Users List</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('/register')}}">
                                                <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                                <span class="pcoded-mtext">Create User</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                 <!-- <li class="pcoded-hasmenu"> -->
                                 <!-- <li class="{!! Request::is('messages*') ? 'active' : '' !!}">
                                    <a href="{{ url('messages') }}">
                                        <span class="pcoded-micon"><i class="feather icon-message-circle"></i></span>
                                        <span class="pcoded-mtext">Messages</span>
                                    </a>
                                </li> -->
                                <!-- <li class="pcoded-hasmenu {!! Request::is('logs*') ? 'active' : '' !!}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                        <span class="pcoded-mtext">Logs</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="{{url('/logs/sms')}}">
                                                <span class="pcoded-micon"><i class="feather icon-cpu"></i></span>
                                                <span class="pcoded-mtext">SMS logs</span>
                                            </a>
                                        </li>

                                    </ul>
                                </li> -->
                                <!-- <li class="{!! Request::is('settings*') ? 'active' : '' !!}">
                                    <a href="{{ url('settings') }}">
                                        <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                                        <span class="pcoded-mtext">Settings</span>
                                    </a>
                                </li> -->
                                <!-- <li class="{!! Request::is('check*') ? 'active' : '' !!}">
                                    <a href="{{ route('checker.index') }}">
                                        <span class="pcoded-micon"><i class="feather icon-anchor"></i></span>
                                        <span class="pcoded-mtext">Pending Approvals</span>
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="div pcoded-inner-content">
                            <div class="div main-body">
                                <div class="page-wrapper">
                                    <div class="page-title">
                                    @if (session('status'))
                                        <div class="alert alert-primary">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if(session('warning'))
                                        <div class="alert alert-warning">
                                            {{ session('warning') }}
                                        </div>
                                    @endif
                                    @if(session('danger'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    </div>
                                    <div class="page-body">
                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="{{ asset('bower_components\jquery\js\jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components\popper.js\js\popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components\bootstrap\js\bootstrap.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('bower_components\jquery-slimscroll\js\jquery.slimscroll.js') }}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ asset('bower_components\modernizr\js\modernizr.js') }}"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{ asset('bower_components\chart.js\js\Chart.js') }}"></script>
    <!-- amchart js -->
    <script src="{{ asset('assets\pages\widget\amchart\amcharts.js') }}"></script>
    <script src="{{ asset('assets\pages\widget\amchart\serial.js') }}"></script>
    <script src="{{ asset('assets\pages\widget\amchart\light.js') }}"></script>
    <script src="{{ asset('assets\js\jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets\js\SmoothScroll.js') }}"></script>
    <script src="{{ asset('assets\js\pcoded.min.js') }}"></script>
    <!-- custom js -->
    <script src="{{ asset('assets\js\vartical-layout.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets\pages\dashboard\custom-dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets\js\script.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('bower_components\spectrum\js\spectrum.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components\jscolor\js\jscolor.js') }}"></script>
    <!-- Mini-color js -->
    <script type="text/javascript" src="{{ asset('bower_components\jquery-minicolors\js\jquery.minicolors.min.js') }}"></script>
    <!-- i18next.min.js -->
    <script type="text/javascript" src="{{ asset('bower_components\i18next\js\i18next.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components\i18next-xhr-backend\js\i18nextXHRBackend.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components\i18next-browser-languagedetector\js\i18nextBrowserLanguageDetector.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components\jquery-i18next\js\jquery-i18next.min.js') }}"></script>
    <!-- Custom js -->

    <script type="text/javascript" src="{{ asset('assets\pages\advance-elements\custom-picker.js') }}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
@yield('js')
</body>

</html>
