<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>EC Aprendizaje | Log in</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="packages/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="packages/adminLTE/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="packages/adminLTE/plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><b>EC</b> Aprendizaje</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="login" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xs-1 col-sm-1 col-md-1" >
                        </div>
                        <div class="col-xs-10 col-sm-10 col-md-10" >
                            <div class="input-group" style="margin-bottom:20px;">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                                <input name="username" type="text" id="username" class="form-control" placeholder="Usuario" required>
                                <!--<div class="input-group-addon">@haydominio.com</div>-->
                            </div>
                        </div>
                        <div class="col-xs-1 col-sm-1 col-md-1" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-1 col-sm-1 col-md-1" >
                        </div>
                        <div class="col-xs-10 col-sm-10 col-md-10" >
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Contrase&ntilde;a" required>
                            </div>
                        </div>
                        <div class="col-xs-1 col-sm-1 col-md-1" >
                        </div>
                    </div>
                    <hr class="colorgraph">
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4" >
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4" >
                            <input type="submit" name="Submit" value="Entrar" class="btn btn-primary btn-block btn-fla">
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4" >
                        </div>
                    </div>
                    <?php if (Session::get('error') && Session::get('error') != "") { ?>
                        <hr class="colorgraph">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 alert alert-danger" style="text-align: center;">
                                {{Session::get('error')}} 
                            </div>
                        </div>
                    <?php } ?>
                    @if(Session::get('csrf_error'))
                    <hr class="colorgraph">
                    <div class="row">
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">Error:</span>
                            <strong>{{Session::get('csrf_error')}} </strong>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 2.2.3 -->
        <script src="packages/adminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="packages/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="packages/adminLTE/plugins/iCheck/icheck.min.js"></script>
        <script>
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});
        </script>
    </body>
</html>
