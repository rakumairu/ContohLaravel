<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IKI Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('/img/i-logo.png') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/css/adminlte.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo" style="">
            <img src="{{ asset('/img/i-logo.png') }}" alt="" style="width: 35%; border-radius: 50%;">
            <a style=""><b>IKI Portal</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <form method="POST" action="{{ url('login') }}">
                {{ csrf_field() }}
                
                <div class="card-body login-card-body">
                    <p class="login-box-msg">IKI Portal Login</p>
                    
                    <div class="input-group mb-3">
                        <input name="username" id="username" type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" placeholder="username" autocomplete="off" value="{{ old('username') }}" required autocomplete="username" autofocus>
                        
                        <div class="input-group-append input-group-text">
                            <span class="fa fa-user"></span>
                        </div>
                        
                        @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="input-group mb-3">
                        <input name="password" id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' :  '' }}" placeholder="password" required autocomplete="current-password">
                        <div class="input-group-append input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                        
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-7 col-sm-12 col-md-6">
                        </div>
                        <div class="col-xl-5 col-sm-12 col-md-6">
                            <button type="submit" class="btn btn-danger btn-block btn-flat" style="background-color: #E3001B;"><text id="login_text">Masuk</text> <i id="load_login" class="fa fa-sign-in-alt fa-sm"></i></button>
                        </div>
                    </div>
                    
                </div>
            </form>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</body>
</html>

