<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/bootstrap-material-design.min.css">
    <link rel="stylesheet" href="/css/ripples.min.css">
    <link rel="stylesheet" href="/css/site.css">
    <link rel="stylesheet" href="/css/jquery.autocomplete.css">

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/dist/autocomplete/jquery.autocomplete.min.js"></script>

</head>
<body id="app-layout">
<div class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/home">{{ config('app.name') }}</a>
        </div>
        <div class="navbar-collapse collapse navbar-inverse-collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Menu
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/home">My Dashboard</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Customers</li>
                        <li><a href="/customer">All Customers</a></li>
                        <li><a href="#">Customer Search</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Vehicles</li>
                        <li><a href="#">Vehicle Search</a></li>
                        <li class="dropdown-header">Vehicle Management</li>
                        <li><a href="/vehicle_type">Types</a></li>
                        <li><a href="/vehicle_make">Makes</a></li>
                        <li><a href="{{ route('vehicle_model.index') }}">Models</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control col-md-8" placeholder="Search">
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                <li><a href="{{ url('/login') }}">Login</a></li>
                <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                <li class="dropdown">
                    <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }}
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/logout') }}">Logout</a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="/js/material.min.js"></script>
    <script src="/js/ripples.min.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
