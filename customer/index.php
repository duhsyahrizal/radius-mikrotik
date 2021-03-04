<?php
    $mac=isset($_POST['mac'])?$_POST['mac']:'';
    $ip=isset($_POST['ip'])?$_POST['ip']:'';
    $statuslogin=isset($_POST['login'])?$_POST['login']:'';
    $username=isset($_POST['username'])?$_POST['username']:'';
    $linklogin=isset($_POST['link-login'])?$_POST['link-login']:'';
    $linkloginonly=isset($_POST['link-login-only'])?$_POST['link-login-only']:'';
    $linkorig=isset($_POST['link-orig'])?$_POST['link-orig']:'';
    $linkorigesc=isset($_POST['link-orig-esc'])?$_POST['link-orig-esc']:'';
    $error=isset($_POST['error'])?$_POST['error']:'';
    $trial=isset($_POST['trial'])?$_POST['trial']:'';
    $chapid=isset($_POST['chap-id'])?$_POST['chap-id']:'';
    $chapchallenge=isset($_POST['chap-challenge'])?$_POST['chap-challenge']:'';
    $macesc=isset($_POST['mac-esc'])?$_POST['mac-esc']:'';
    $identity=isset($_POST['identity'])?$_POST['identity']:'';
    $bytesinnice=isset($_POST['bytes-in-nice'])?$_POST['bytes-in-nice']:'';
    $bytesoutnice=isset($_POST['bytes-out-nice'])?$_POST['bytes-out-nice']:'';
    $sessiontimeleft=isset($_POST['session-time-left'])?$_POST['session-time-left']:'';
    $uptime=isset($_POST['uptime'])?$_POST['uptime']:'';
    $refreshtimeout=isset($_POST['refresh-timeout'])?$_POST['refresh-timeout']:'';
    $linkstatus=isset($_POST['link-status'])?$_POST['link-status']:'';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mikrotik Hotspot | Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>
<body>

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
                <a class="navbar-brand" href="#"><?= isset($identity)?$identity:'' ?></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="<?= $linklogin ?>">Login</a></li>
                    <!-- <li><a href="package-list.php" id="alert">Package</a></li> -->
                </ul>
            </div>
        </div>
    </div>

    <div id="bottom-menu">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xs-10 textlogo text-center">
                    <h1>Bayhost Radius</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="col-md-6 col-sm-12">
        
            <div class="row">
                <?php if($error) : ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
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

                        <form id="loginForm" class="form-horizontal" role="form" action="<?php echo $linkloginonly; ?>" method="post">
                            <input type="hidden" name="dst" value="<?php echo $linkorig; ?>"/>
                            <input type="hidden" name="popup" value="true"/>

                            <div class="form-group">
                                <label for="inputLogin" class="col-sm-2 control-label">Login</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control input-lg" id="inputLogin" name="username"
                                           placeholder="Login" autofocus required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="col-sm-2 control-label">Password</label>

                                <div class="col-sm-10">
                                    <input type="password" class="form-control input-lg" id="inputPassword" name="password"
                                           placeholder="Password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="card hovercard">
                        <div class="cardheader">
                        </div>
                        <div class="avatar">
                        <img alt="" src="img/bayhost2.png">
                        </div>
                        <div class="info">
                        <div class="title">
                        Bayhost Radius | Hotspot
                        </div>
                        <div class="desc">Internet Speed Bayhost</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>


<script type="text/javascript" src="js/md5.js"></script>
<script type="text/javascript">
<!--
    function doLogin() {
    <?php if(strlen($chapid) < 1) echo "return true;\n"; ?>
    document.sendin.username.value = document.login.username.value;
    document.sendin.password.value = hexMD5('<?php echo $chapid; ?>' + document.login.password.value + '<?php echo $chapchallenge; ?>');
    document.sendin.submit();
    return false;
    }
//-->
</script>

<script type="text/javascript">
  document.login.username.focus();
</script>

</body>
</html>
