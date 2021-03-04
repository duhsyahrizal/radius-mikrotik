<?php
    $ip=isset($_GET['userip'])?$_GET['userip']:'';
    $linkloginonly=isset($_GET['loginin'])?$_GET['loginin']:'';
    $linkorig=isset($_GET['userurl'])?$_GET['userurl']:'';
    $error=isset($_GET['msgerr'])?$_GET['msgerr']:'';
    $trial=isset($_GET['trial'])?$_GET['trial']:'';
    $chapid=isset($_GET['chapid'])?$_GET['chapid']:'';
    $chapchallenge=isset($_GET['chapchall'])?$_GET['chapchall']:'';
    $identity=isset($_GET['identity'])?$_GET['identity']:'';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bayhost Internet | Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>
<body>

<form name="login" action="<?=$linkloginonly?>" class="form-horizontal" onsubmit="return doLogin()" method="GET">
    <div id="wrap">
        <div class="navbar navbar-inverse navbar-static-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><?= $identity ?></a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="<?= $linkloginonly ?>">Login</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="bottom-menu">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-1 mylogo">
                        <a href="https://bandungcctv.com"><img src="img/logo.png"style="margin-left: 1rem;"  width="90%" alt="logo"></a>
                    </div> 
                    <div class="col-xs-12 textlogo">
                        <h1>Bayhost Radius</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            
                <div class="row">
                    <?php if($error) : ?>
                        <div class="alert alert-danger"><?= $error; ?></div>
                    <?php endif; ?>

                    <div class="alert alert-info">Please log on to use the hotspot service.</div>
                    <?php if($trial == 'yes') : ?> 
                        <div class="alert alert-info">
                            Free trial available, <a href="<?php echo $linkloginonly; ?>?dst=<?php echo $linkorigesc; ?>&amp;username=T-<?php echo $macesc; ?>">click here</a>.
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row">            
                    <div class="panel panel-default">
                        
                        <div class="panel-body">
                                <input type="hidden" name="dst" value="<? $linkorig ?>"/>
                                <input type="hidden" name="popup" value="true"/>

                                <div class="form-group">
                                    <label for="inputLogin" class="col-sm-2 control-label">Username</label>

                                    <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
                                        <input type="text" class="form-control input-lg" id="inputLogin" name="username"
                                            placeholder="Username" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="col-sm-2 control-label">Password</label>

                                    <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
                                        <input type="password" class="form-control input-lg" id="inputPassword" name="password"
                                            placeholder="Password" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
                                    </div>
                                </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="card hovercard">
                            <div class="cardheader">
                            </div>
                            <div class="avatar">
                            <img alt="" src="img/logo.png">
                            </div>
                            <div class="info">
                            <div class="title">
                            Fast Internet Access
                            </div>
                            <div class="desc">Jl. GKPN No. 1 Jatinangor, Sumedang<br>
                                Phone : 0813 1202 8876 / 0852 2258 0028<br>
                                Email : bayhostinternet@gmail.com<br>
                                Twitter : @BAYHOSTint</div>
                            </div>
                            <div class="bottom">
                                <a class="btn btn-primary btn-twitter btn-sm" href="https://twitter.com/BAYHOSTint?s=08"><i class="fa fa-twitter"></i></a>
                                <a class="btn btn-danger btn-sm" rel="publisher" href="https://plus.google.com/+bayhostinternet"><i class="fa fa-google-plus"></i></a>
                                <a class="btn btn-primary btn-sm" rel="publisher" href="https://www.facebook.com/bayhostinternet"><i class="fa fa-facebook"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php if ($chapid) : ?>
    <form name="sendin" action="<?= $linkloginonly ?>" method="get" style="display:none">
        <input type="hidden" name="username" />
        <input type="hidden" name="password" />
        <input type="hidden" name="dst" value="<?= $linkorig ?>" />
        <input type="hidden" name="popup" value="true" />
    </form>

    <script type="text/javascript" src="js/md5.js"></script>
    <script>
        function doLogin() {
        <?php if(strlen($chapid) < 1) echo "return true;\n"; ?>
        document.sendin.username.value = document.login.username.value;
        document.sendin.password.value = hexMD5('<?php echo $chapid; ?>' + document.login.password.value + '<?php echo $chapchallenge; ?>');
        document.sendin.submit();
        return false;
        }
    </script>
<?php endif; ?>


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<script type="text/javascript">
  document.login.username.focus();
</script>

</body>
</html>
