<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SPADA Login</title>
        <link rel="icon" href="{{ asset('assets/spada/images/icon.png') }}" type="image/png" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css"/>
        <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}" type="text/css" media="screen">
        <link rel="stylesheet" href="{{ asset('assets/css/grid.css') }}" type="text/css" media="screen">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css" media="screen">
        <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}" type="text/css" media="screen">
        <link rel="stylesheet" href="{{ asset('assets/spada/css/logres.css') }}" type="text/css" media="screen">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.css"/>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.min.js"></script>
    </head>
    <body>
        <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" style="margin-top:10%">
                <img src="{{ asset('assets/images/logo.png')}}" alt="logo" class="img-responsive mb-5"/>
                <br>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">SPADA Login</h3>
                    </div>
                    <div class="panel-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Gagal!</strong> {{ Session::get('error') }}
                            </div>
                        @endif
                        <form action="{{ url('/doLogin') }}" method="POST">
                            @csrf
                            {{-- <fieldset> --}}
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a class="btn btn-default" type="button"><i class="fa fa-user"></i></a>
                                        </span>
                                            <input type="text" name="adminUsername" id="adminUsername" class="form-control" placeholder="Username" focus>
                                            @error('adminUsername') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a class="btn btn-default" type="button"><i class="fa fa-lock"></i></a>
                                        </span>
                                        <input type="password" name="adminPassword" id="adminPassword" class="form-control" id="password" placeholder="Password">
                                        @error('adminPassword') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>     
                            <input type="submit" id="btnLogin" class="btn btn-success btn-block" value="Login">
                        {{-- </fieldset> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>