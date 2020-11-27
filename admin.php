<?php
session_start();
include('./include/title.php');
include('./conf/conf.php');
require_once('./lib/routeros_api.class.php');
include('./sql/token.php');
include('./sql/connection.php');

$queryRole = "SELECT role FROM bayhost_users WHERE `username` = '".$_SESSION['user']."'";

$result = $conn->query($queryRole);
$res = $result->fetch_assoc();

if(empty($_SESSION['token']) || $token_id != $_SESSION['token']){
  echo "<script>";
  echo "window.location.href = './index.php'";
  echo "</script>";
  // header('Location:./login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Billing Radius | <?= $title ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include("include/css-plugins.php"); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  
  <!-- /.navbar -->
  <?php 
  include("include/header.php");
  include("include/main-sidebar.php"); 
  ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
      include('./conf/page.php');
    ?>
    <!-- /.content -->
  </div>

  <?php include("./include/footer.php"); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include("./include/js-plugins.php"); ?>
<script>
function goBack() {
  window.history.back();
}

$(document).ready(function(){
  $('#check').click(function(){
    $(this).is(':checked') ? $('#password').attr('type', 'text') : $('#password').attr('type', 'password');
  });
  $('#report-table').DataTable({
    pageLength: 25,
  });
});

</script>
</body>
</html>
