<?php
session_start();
include('../conf/conf.php');
require_once('../lib/routeros_api.class.php');
date_default_timezone_set('Asia/Jakarta');
include('../sql/connection.php');

  $action = $_GET['action'];
  $data = !isset($_GET['data'])?'':$_GET['data'];
  $timestamp = date('Y-m-d H:i:s');

  if($action == 'login'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember'])?$_POST['remember']:'';
    $token = openssl_random_pseudo_bytes(16);
    // connection
    $conn = new mysqli($servername, $userdb, $passworddb, $database);
    $sql = "SELECT * FROM bayhost_users WHERE `username` = '".$username."' AND `password` = '".$password."'";
    $time = time();
    $matching = $conn->query($sql);
    $check = $matching->num_rows;
    

    //Convert the binary data into hexadecimal representation.
    $token = bin2hex($token);
    
    if($check > 0){
      if($remember){
        setcookie("username", $username, $time + 60*60*24*30, '/');
        setcookie("password", $password, $time + 60*60*24*30, '/');
        setcookie("remember", 1, $time + 60*60*24*30, '/');
      }
      $_SESSION['user'] = $username;
      $_SESSION['token'] = $token;
      $sql_insert = "INSERT INTO user_token (`username`, `token`, `modified_at`) VALUES ('".$username."', '".$_SESSION['token']."', '".$timestamp."')";
      $sql_update = "UPDATE user_token set token='".$token."', modified_at='".$timestamp."' WHERE username='".$username."'";
      
      $sql_check_token="SELECT * from user_token where username='".$username."'";
      // Create connection
      $connect = new mysqli($servername, $userdb, $passworddb, $database);
      // Update user token 
      $result_token = $connect->query($sql_check_token);

      if($result_token->num_rows > 0){
        // Update token to table
        $connect->query($sql_update);
      }else{
        // Insert token to table
        $connect->query($sql_insert);
      }
      // $member = $matching->fetch_assoc();
      // $data['username'];
      // $data['password'];
      // $data['remember'];
      // // array_push($data, $member);
      // array_push($data, $_COOKIE['username']);
      // array_push($data, $_COOKIE['password']);
      // array_push($data, $_COOKIE['remember']);
      // $json = json_encode($data);
      // echo $json;
      echo 'success';
      // echo '<script language="javascript">';
			// echo 'alert("Welcome to Bayhost Radius, '.ucfirst($_SESSION['user']).'");';
			// echo 'window.location.href = "../admin.php?token='.$_SESSION['token'].'&task=dashboard";';
			// echo '</script>';
      // header("Location:../admin.php?token='.$_SESSION['token'].'&page=dashboard");
    }else {
      echo 'failed';
      // echo '<script language="javascript">';
      // echo 'alert("Please type username and password correctly.");';
      // echo 'window.location.href = "../index.php";';
      // echo '</script>';
    }
  }
  else if($action == 'logout'){
    unset($_SESSION['user']);
    unset($_SESSION['token']);
    session_destroy();
    header("Location:../index.php");
  }
  else if($data == 'user'){
    if($action == 'save'){
      if($_POST['username'] != ''){
        // set start & end time
        $time_indo = date('H:i:s');
        // get all post data
        $num = 0;
        $username = $_POST['username'];
        $password = $_POST['password'];
        $profile = $_POST['profile'];
        $shared_users = $_POST['shared_users'];

        $start_date = $_POST['start_date'];
        $start_from = date_create($start_date);
        $payment = $_POST['payment'];
        switch($_POST['payment']){
          case '1':
            $paymentName = 'Cash';
            $payment = 1;
            break;
          case '2':
            $paymentName = 'Transfer';
            $payment = 2;
            break;
          case '3':
            $paymentName = 'Hutang';
            $payment = 3;
            break;
        }
        $description = !isset($_POST['description'])?'':$_POST['description'];
        $created_at = $start_date. ' ' . $time_indo;

        $end_date = $_POST['end_date'];
        $end = date_create($end_date);
        $expired_at = $end_date. ' ' . $time_indo;

        $date_diff = date_diff($start_from, $end);
        $active_period = $date_diff->format("%a days");
        $fullname = !isset($_POST['fullname'])?'':$_POST['fullname'];
        $place_of_birth = !isset($_POST['place_of_birth'])?'':$_POST['place_of_birth'];
        $date_of_birth = !isset($_POST['date_of_birth'])?'':$_POST['date_of_birth'];
        $gender = !isset($_POST['gender'])?'':$_POST['gender'];
        $boarding_house_name = !isset($_POST['boarding_house_name'])?'':$_POST['boarding_house_name'];
        $telephone = !isset($_POST['telephone'])?'':$_POST['telephone'];
        $user_login = $_SESSION['user'];
        $time = date('d-m-Y');
        $API = new RouterosAPI();
        $API->debug = false;
    
        $pass = decrypt($pass);
        $num = 0;
        if(!$API->connect($host, $user, $pass)){
          echo "Mikrotik Could Not Connect.";
        } else{
          $add_user = $API->comm("/tool/user-manager/user/add", array(
              "customer" => "admin",
              "username" => "$username",
              "password" => "$password",
          ));
          $response = $API->comm("/tool/user-manager/user/create-and-activate-profile", array(
              "customer" => "admin",
              ".id" => "$add_user",
              "profile" => $profile
          ));
          $API->comm("/tool/user-manager/user/set", array(
            ".id" => $add_user,
            "shared-users" => $shared_users,
          ));
          $res = $API->comm("/tool/user-manager/profile/print", array(
            "?.id" => $profile,
            ".proplist" => "price,name"
          ));
          $price = $res[0]['price'];
          $package_name = $res[0]['name'];

          // Create connection
          $conn = new mysqli($servername, $userdb, $passworddb, $database);
    
          $sql = "INSERT INTO radius_users (`mikrotik_id`, `username`, `password`, `shared_users`) VALUES ('".$add_user."', '".$username."', '".$password."', '".$shared_users."')";
          $insertAcc = "INSERT INTO radius_account (radius_user_id, radius_package_name, radius_package_price, fullname, place_of_birth, date_of_birth, gender, boarding_house_name, telephone, active_period, start_time, end_time) VALUES ('".$add_user."', '".$package_name."', $price, '".$fullname."', '".$place_of_birth."', '".$date_of_birth."', '".$gender."', '".$boarding_house_name."', '".$telephone."', '".$active_period."', '".$created_at."', '".$expired_at."')";
          $report = "INSERT INTO radius_report (`radius_user_name`, `payment`, `package`, `price`, `type`, `created_by`, `created_at`) VALUES ('".$username."', '".$payment."', '".$package_name."', '".$price."', 'user', '".$user_login."',  '".$time."')";
          $descPayment = "INSERT INTO radius_payment (`payment_name`, `description`) VALUES ('".$paymentName."', '".$description."')";

          $conn->query($descPayment);
          if ($conn->query($report) === TRUE) {
            echo "New record Report created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }

          if ($conn->query($insertAcc) === TRUE) {
            echo "New record Account created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
          
          if ($conn->query($sql) === TRUE) {
            echo "New record User created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
          header("Location:../admin.php?token=".$_SESSION['token']."&task=user-list");
        }
      } else {
        echo "data tidak ada";
      }
    }
    else if($action == 'disable_user'){
      $conn = new mysqli($servername, $userdb, $passworddb, $database);
      $check = "SELECT status FROM radius_users WHERE mikrotik_id='".$_GET['user_id']."'";
      $enable = "UPDATE radius_users SET status = 1 WHERE mikrotik_id='".$_GET['user_id']."'";
      $disable = "UPDATE radius_users SET status = 0 WHERE mikrotik_id='".$_GET['user_id']."'";
      
      $API = new RouterosAPI();
      $API->debug = false;
  
      $pass = decrypt($pass);
      $result = $conn->query($check);
      $hasil = $result->fetch_assoc();
      if ($hasil['status'] == 0){
        $conn->query($enable);
      
        if(!$API->connect($host, $user, $pass)){
          echo "Mikrotik Could Not Connect.";
        } else{
          $API->comm("/tool/user-manager/user/set", array(
            ".id" => $_GET['user_id'],
            "disabled" => 'false'
          ));
        } 
        echo 'success';
      } else {
        $conn->query($disable);
        if(!$API->connect($host, $user, $pass)){
          echo "Mikrotik Could Not Connect.";
        } else{
          $API->comm("/tool/user-manager/user/set", array(
            ".id" => $_GET['user_id'],
            "disabled" => 'true'
          ));
        } 
        echo 'success';
      }
    }
    else if($action == 'get_status_user'){
      $conn = new mysqli($servername, $userdb, $passworddb, $database);
      $check = "SELECT status FROM radius_users WHERE mikrotik_id='".$_GET['user_id']."'";
      
      $result = $conn->query($check);
      $hasil = $result->fetch_assoc();
  
      if ($hasil['status'] == 0){
        echo 'disable';
      } else {
        echo 'active';
      }
    }
    else if($action == 'edit'){
      $API = new RouterosAPI();
      $API->debug = false;
      $mikrotik_id = $_POST['id'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $shared_users = $_POST['shared_users'];
      $pass = decrypt($pass);
      $num = 0;
        if(!$API->connect($host, $user, $pass)){
          echo "Mikrotik Could Not Connect.";
        } else{
          $updateUser = $API->comm("/tool/user-manager/user/set", array(
              ".id" => $mikrotik_id,
              "username" => "$username",
              "password" => "$password",
              "shared-users" => $shared_users
          ));
          header("Location:../admin.php?token=".$_SESSION['token']."&task=user-list");
        }
    }
    else if($action == 'delete'){
      $user_id = $_GET['user_id'];
    
      $API = new RouterosAPI();
      $API->debug = false;
  
      $pass = decrypt($pass);
      $num = 0;
      if(!$API->connect($host, $user, $pass)){
        echo "Mikrotik Could Not Connect.";
      } else{
        // remove by profile number
        $API->comm("/tool/user-manager/user/remove", array(
          ".id" => $user_id
        ));
  
        $query_remove_user="DELETE from radius_users WHERE mikrotik_id='".$user_id."'";
        $query_remove_acc="DELETE from radius_account WHERE radius_user_id='".$user_id."'";

        $conn->query($query_remove_acc);
        if ($conn->query($query_remove_user) === TRUE) {
          echo "success";
        } else {
          echo "failed";
        }
      }
    }
  }
  else if($data == 'package'){
    if($action == 'save'){
      if($_POST['name'] != ''){
        $name = $_POST['name'];
        $validity = $_POST['expired'];
        $uptime = ($_POST['uptime']=='') ? "0s" : $_POST['uptime']."h";
        $rate_limit = $_POST['rate_limit'];
        // set rate_limit to Kbps
        $rate_limit = $rate_limit * 1024;
        $format_size = $_POST['format_size'];
        $transfer_limit = $_POST['transfer_limit'];
        $price = ($_POST['price'] == '') ? '0' : $_POST['price'];
        switch($format_size){
          case 'GB':
            $transfer_limit = $transfer_limit * 1073741824;
            break;
          case 'MB':
            $transfer_limit = $transfer_limit * 1048576;
            break;
        }
        $API = new RouterosAPI();
        $API->debug = false;
      
        $pass = decrypt($pass);
        $num = 0;
        if(!$API->connect($host, $user, $pass)){
          echo "Mikrotik Could Not Connect.";
        } 
        else{ 
          $add_profile = $API->comm("/tool/user-manager/profile/add", array(
            "owner" => "admin",
            "name" => $name,
            "validity" => $validity,
            "price" => $price,
            "starts-at" => "logon",
            "override-shared-users" => "unlimited"
          ));
          $add_limit = $API->comm("/tool/user-manager/profile/limitation/add", array(
            "owner" => "admin",
            "name" => "$name",
            "uptime-limit" => $uptime,
            "transfer-limit" => $transfer_limit,
            "rate-limit-rx" => "$rate_limit",
            "rate-limit-tx" => "$rate_limit"
          ));
          $add_pl = $API->comm("/tool/user-manager/profile/profile-limitation/add", array(
            "profile" => $name,
            "limitation" => $name
          ));
    
          $sqlInsertId = "INSERT INTO mikrotik_package (`profile_id`, `limitation_id`, `profile_limitation_id`) VALUES ('".$data['.id']."', '".$limitation[0]['.id']."', '".$profLimit[0]['.id']."')";
          $sql = "INSERT INTO bayhost_packet (`mikrotik_id`, `packet_name`, `active_period`, `time_limit`, `quota_limit`, `rate_limit`, `price`) VALUES ('".$add_profile."','".$name."', '".$validity."', '".$uptime."', '".$transfer_limit."', '".$rate_limit."', $price)";
          $conn->query($sqlInsertId);
          if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
    
          header("Location:../admin.php?token=".$_SESSION['token']."&task=profile-list");
        }
      } else {
        echo "data tidak ada";
      }
    }
    else if($action == 'edit'){
      $mikrotik_id = $_POST['id'];
      $name = $_POST['name'];
      $validity = $_POST['expired'];
      $uptime = ($_POST['uptime'] == "0s") ? "0s" : $_POST['uptime']."h";
      $rate_limit = $_POST['rate_limit'];
      // set rate_limit to Kbps
      $rate_limit = $rate_limit * 1024;
      $format_size = $_POST['format_size'];
      $transfer_limit = $_POST['transfer_limit'];
      $price = ($_POST['price'] == '') ? '0' : $_POST['price'];
      
      $API = new RouterosAPI();
      $API->debug = false;
    
      $pass = decrypt($pass);
      $num = 0;
      if(!$API->connect($host, $user, $pass)){
        echo "Mikrotik Could Not Connect.";
      } else{
        $res2 = $API->comm("/tool/user-manager/profile/set", array(
          "numbers" => "$mikrotik_id",
          "name" => "$name",
          "validity" => "$validity",
          "price" => "$price",
        ));
        $response = $API->comm("/tool/user-manager/profile/limitation/set", array(
          "numbers" => "$mikrotik_id",
          "name" => "$name",
          "uptime-limit" => $uptime,
          "transfer-limit" => $transfer_limit,
          "rate-limit-rx" => "$rate_limit",
          "rate-limit-tx" => "$rate_limit",
          "rate-limit-min-rx" => "$rate_limit",
          "rate-limit-min-tx" => "$rate_limit",
        ));
        header("Location:../admin.php?token=".$_SESSION['token']."&task=profile-list");
      }
    }
    else if($action == 'delete'){
      $profile_id = $_GET['profile_id'];
      $limit_id = $_GET['limit_id'];
      $pl_id = $_GET['profile_limit_id'];
      
      $API = new RouterosAPI();
      $API->debug = false;
    
      $pass = decrypt($pass);
      $num = 0;
      if(!$API->connect($host, $user, $pass)){
        echo "Mikrotik Could Not Connect.";
      } else{
        // remove by profile number
        $API->comm("/tool/user-manager/profile/remove", array(
          ".id" => $profile_id
        ));
        // remove by limitation number
        $API->comm("/tool/user-manager/profile/limitation/remove", array(
          ".id" => $limit_id
        ));
        // remove by profile-limitation number
        $deletePl = $API->comm("/tool/user-manager/profile/profile-limitation/remove", array(
          ".id" => $pl_id
        ));
        $query_remove_profile="DELETE FROM radius_package WHERE mikrotik_id='".$profile_id."'";
    
        if ($conn->query($query_remove_profile) === TRUE) {
          echo "success";
        } else {
          echo "failed";
        }
      } 
    }
  }
  
  
  
?>