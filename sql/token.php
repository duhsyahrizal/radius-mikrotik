<?php
include('./sql/connection.php');
date_default_timezone_set('Asia/Jakarta');
$timestamp = date('Y-m-d H:i:s');

// Create connection
$conn = new mysqli($servername, $userdb, $passworddb, $database);
if(isset($_SESSION['token'])){
  $sql_token="SELECT * from user_token where username='".$_SESSION["user"]."'";
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  // Update user token 
  $result_token = $conn->query($sql_token);

  if($result_token->num_rows > 0){
    while($row = $result_token->fetch_assoc()){
      $token_id = $row['token'];
    }
  }
}
?>