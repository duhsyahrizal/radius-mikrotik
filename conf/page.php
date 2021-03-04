<?php
include('./lib/format-bytes.php');
require_once('./lib/routeros_api.class.php');
include_once('./conf/conf.php');
$API = new RouterosAPI();
$API->debug = false;

$date = date("d-m-Y");
$endDate = date("d-m-Y", strtotime("+30 days"));

$pass = decrypt($pass);
$num = 0;
$qc2 = "SELECT * FROM client_gateway WHERE id=2";
$queryClient = "SELECT * FROM client_gateway";

$res = $conn->query($queryClient);
    
if(!$conn){
  die("Connection failed: " . mysqli_connect_error());
}
else {
  // get all client in database
  $total_router = $res->num_rows;
  mysqli_close($conn);
}

if(!$API->connect($host, $user, $pass)){
    echo "Mikrotik Could Not Connect.";
} else{
  $ARRAY = $API->comm("/system/resource/print");
        $first = $ARRAY['0'];
        $cpu = $first['cpu-load'];
        $active_users = $API->comm("/tool/user-manager/session/print", array(
            "?active" => "true",
            "count-only" => ""
        ));
        $all_user = $API->comm("/tool/user-manager/user/print", array(
            "count-only" => "",
        ));
  $limitations = $API->comm("/tool/user-manager/profile/limitation/print");
  $profiles = $API->comm("/tool/user-manager/profile/print");
    
  if(isset($_GET['id'])){
    $mikrotik_id = $_GET['id'];
    if(!$API->connect($host, $user, $pass)){
        echo "Mikrotik Could Not Connect.";
    } else{
      // query get profile on page edit
      $profile = $API->comm("/tool/user-manager/profile/print", array(
        "?.id" => $mikrotik_id
      ));
      $user = $API->comm("/tool/user-manager/user/print", array(
        "?.id" => $mikrotik_id
      ));
      foreach($user as $row){
        $username = $row['username'];
        $password = $row['password'];
        $shared_users = $row['shared-users'];
      }
      foreach($profile as $row){
        $name = $row['name'];
        $validity = $row['validity'];
        $price = $row['price'];

        $limitation = $API->comm("/tool/user-manager/profile/limitation/print", array(
            "?name" => "$name"
        ));
        foreach($limitation as $row){
            $uptime = $row['uptime-limit'];
            $rate_limit = isset($row['rate-limit-rx'])?$row['rate-limit-rx']:0;
            // inisialitation rate limit to selected option
            $rate_limit = convert_bytes_without_comm($rate_limit,'K',0);
            $rate_limit = (int)$rate_limit;
            $quota = convert_bytes($row['transfer-limit'],'G',0);
            $uptime = substr($uptime, 0, 1);
        }
      }
    }
  }
}
if(isset($_GET['task'])){
  $task = $_GET['task'];
  switch ($task) {
    // Beranda
    case 'dashboard':
      include 'pages/dashboard.php';
      break;
    case 'router-client':
      include 'pages/router-client.php';
      break;
    case 'user-list':
      include 'pages/user-list.php';
      break;
    case 'add-user':
      include 'pages/add-user.php';
      break;
    case 'edit-user':
      include 'pages/edit-user.php';
      break;
    case 'profile-list':
      include 'pages/profile-list.php';
      break;
    case 'add-profile':
      include 'pages/add-profile.php';
      break;
    case 'edit-profile':
      include 'pages/edit-profile.php';
      break;
    case 'user-active':
      include 'pages/user-active.php';
      break;
    case 'migration-package':
      include 'pages/add-package.php';
      break;
    case 'report':
      include 'pages/reports.php';
      break;
    case 'report-data':
      include 'pages/report-data.php';
      break;
      // featured will created
    case 'preference':
      include 'pages/active-soon.php';
      break;
    case 'system':
      include 'pages/active-soon.php';
      break;
  }
}
?>