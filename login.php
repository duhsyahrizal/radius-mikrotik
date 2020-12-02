<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
    include('./include/css-plugins.php');
  ?>
  <style type="text/css">
        .error{ color: red; }
        .success{ color: green; }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="https://bandungcctv.com"><b>Bayhost</b>Radius</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <div class="callout callout-danger d-none" id="loginFailed">
        <h5>Login Failed!</h5>
        <p>Username or password doesn't match</p>
      </div>
      <div>
        <div class="form-group mb-3">
          <input id="username" name="username" type="text" value="<?= isset($_COOKIE['username'])?$_COOKIE['username']:''?>" class="form-control" placeholder="Username" required>
          <div class="invalid-feedback">
            Please check again your username
          </div>
        </div>
        <div class="form-group mb-3">
          <input id="password" name="password" type="password" value="<?= isset($_COOKIE['password'])?$_COOKIE['password']:''?>" class="form-control" placeholder="Password" required>
          <div class="invalid-feedback">
            Please check again your password
          </div>
        </div>
        <div class="row">
          <div class="col-7">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember" <?= isset($_COOKIE['remember'])?'checked':''?>>
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-5">
            <button type="submit" id="submit" class="btn btn-primary btn-block">Sign In <span class="ml-1 loader spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span></button>
          </div>
          <!-- /.col -->
        </div>
      </div>
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<?php
  include('./include/js-plugins.php');
?>
<script>
  $("#submit").on("click", function(){
    var username = $("#username").val();
    var password = $("#password").val();
    var remember = $("#remember").val();
    $(this).addClass('disabled');
    $(".loader").removeClass('d-none');
    setTimeout(() => {
      $.ajax({
        method: "POST",
        url: "./userman/process.php?action=login",
        data: {
          username: username,
          password: password,
          remember: remember,
        },
        success: function(res) {
          // console.log(invalidLogin);
          if (res == "success") {
            window.location.href = "index.php";
          }else{
            $("#username").addClass("is-invalid");
            $("#password").addClass("is-invalid");
            $("#loginFailed").removeClass("d-none");
            $("#submit").removeClass('disabled');
            $(".loader").addClass("d-none");
          }
        }
      })
    }, 3000);
    
  })
</script>