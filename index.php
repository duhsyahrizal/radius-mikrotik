<?php
session_start();
include('./sql/token.php');
date_default_timezone_set('Asia/Jakarta');
// include('./conf/conf.php');
// require('./lib/routeros_api.class.php');
include('./sql/connection.php');
$url = $_SERVER['REQUEST_URI'];

if(empty($_SESSION['token']) || $token_id != $_SESSION['token']){
  echo '<script language="javascript">';
  echo 'window.location.href = "login.php";';
  echo '</script>';
}
else{
  header("Location:./admin.php?token=".$_SESSION['token']."&task=dashboard");
  // echo "<script>";
  // echo "window.location.href = './admin.php?token=".$_SESSION['token']."&page=dashboard'";
  // echo "</script>";
}
?>

