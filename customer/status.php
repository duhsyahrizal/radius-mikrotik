<?php    
    $ip=isset($_GET['userip'])?$_GET['userip']:'';
    $username=isset($_GET['username'])?$_GET['username']:'';
    $linklogout=isset($_GET['linklogout'])?$_GET['linklogout']:'';
    $linkstatus=isset($_GET['linkstatus'])?$_GET['linkstatus']:'';
    $identity=isset($_GET['identity'])?$_GET['identity']:'';
    $uptime=isset($_GET['uptime'])?$_GET['uptime']:'';
    $refreshtimeout=isset($_GET['refreshtimeout'])?$_GET['refreshtimeout']:'';
    $refreshtimeoutsecs=isset($_GET['refreshtimeoutsecs'])?$_GET['refreshtimeoutsecs']:'';
    $sessiontimeleft=isset($_GET['sessiontimeleft'])?$_GET['sessiontimeleft']:'';
    $bytesinnice=isset($_GET['bytesin'])?$_GET['bytesin']:'';
    $bytesoutnice=isset($_GET['bytesout'])?$_GET['bytesout']:'';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bayhost Internet | Session Status</title>
    <?php if($refreshtimeout) : ?>
    <meta http-equiv="refresh" content="<?=$refreshtimeoutsecs?>; url=<?=$linkstatus?>">
    <?php endif ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />   
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="-1">
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
                <a class="navbar-brand" href="#"><?= $identity ?></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?=$linklogout?>" id="alert">Logout</a></li>
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
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <h4>Welcome, <?= $username ?></h4>
                                </tr>
                                <tr>
                                    <td>IP address :</td>
                                    <td><?php echo $ip; ?></td>
                                </tr>
                                <tr>
                                    <td>Upload / Download :</td>
                                    <td><?php echo $bytesoutnice; ?> / <?php echo $bytesinnice; ?> </td>
                                </tr>
                                <?php if($sessiontimeleft) : ?>
                                <tr>
                                    <td>Connected / left</td><td><?=$uptime?> / <?=$sessiontimeleft?></td>
                                </tr>
                                <?php else : ?>
                                <tr>
                                    <td>Connected : </td><td><?=$uptime?></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div style="padding: 0 40px;">
                            <button class="btn btn-danger btn-block" onclick="return doLogout();">Logout</button>
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

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    function doLogout() {
        window.location = "<?=$linklogout?>";
    }
</script>

</body>
</html>
