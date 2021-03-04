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
    <title>Bayhost Internet | Redirect</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>
<body onload="return refreshData()">

<div id="wrap">

    <div class="container">
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <div class="alert alert-success">
                    You are logged in successfully. If nothing happens, click <a href="<?php echo $linkstatus; ?>">here</a>.
                </div>
            </div>
        </div>


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
