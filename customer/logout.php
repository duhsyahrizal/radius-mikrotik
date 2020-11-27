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
    <title>Mikrotik Hotspot | Logout</title>
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
                <a class="navbar-brand" href="#"><?php echo $identity; ?></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?=$linklogin?>">Login</a></li>
                    <li><a href="#status" id="alert">Status</a></li>
                    <li class="active"><a href="#logout" id="alert">Logout</a></li>
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
                <div class="alert alert-success">You have just logged out.</div>
            </div>
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td>user name</td>
                                <td><?php echo $username; ?></td>
                            </tr>
                            <tr>
                                <td>IP address</td>
                                <td><?php echo $ip; ?></td>
                            </tr>
                            <tr>
                                <td>MAC address</td>
                                <td><?php echo $mac; ?></td>
                            </tr>
                            <tr>
                                <td>session time</td>
                                <td><?php echo $uptime; ?></td>
                            </tr>
                            <?php if($sessiontimeleft) : ?>
                                <tr>
                                    <td>time left</td>
                                    <td><?php echo $sessiontimeleft; ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td>bytes up/down:</td>
                                <td><?php echo $bytesinnice; ?> / <?php echo $bytesoutnice; ?></td>
                            </tr>
                            </tbody>
                        </table>
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


<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>