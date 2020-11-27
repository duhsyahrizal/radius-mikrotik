<?php
include('../conf/conf.php');
include('../sql/connection.php');
include_once('../lib/format-bytes.php');
require_once('../lib/routeros_api.class.php');

$conn = new mysqli($servername, $userdb, $passworddb, $database);
$m_id = $_GET['id'];
$sql = "SELECT 
        radius_account.radius_account_id,
        radius_account.radius_user_id,
        radius_account.radius_package_name,
        radius_account.radius_package_price,
        radius_account.active_period,
        radius_account.start_time,
        radius_account.end_time,
        radius_users.mikrotik_id,
        radius_users.username,
        radius_users.password,
        radius_users.shared_users,
        radius_users.download_used,
        radius_users.upload_used,
        radius_users.status
        FROM radius_account
        INNER JOIN radius_users ON radius_account.radius_user_id = radius_users.mikrotik_id
        WHERE radius_account.radius_user_id = '".$m_id."'";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
  $username = $row['username'];
  $password = $row['password'];
  $upload_used = isset($row['upload_used']) ? $row['upload_used'] : 0;
  $check_up_gb = number_format($upload_used/1073741824,0);
  $upload_used = ($check_up_gb == '0') ? convert_bytes($upload_used,'M').' MB' : convert_bytes($upload_used,'G').' GB';
  $download_used = isset($row['download_used']) ? $row['download_used'] : 0;
  $check_down_gb = number_format($download_used/1073741824,0);
  $download_used = ($check_down_gb == '0') ? convert_bytes($download_used,'M').' MB' : convert_bytes($download_used,'G').' GB';
  $shared_users = $row['shared_users'];
  $end_time = $row['end_time'];
  $end_time = explode(" ", $end_time);
}

// $end_date = date_create($row['end_time']);
// $end_date = date_format($end_date,"d-M-Y H:i:s");

?>
<div class="modal-header bg-primary">
<h5 class="modal-title ml-2" id="exampleModalLabel">Detail user (<?=$username?>)</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
  <fieldset class="px-3" disabled>
    <div class="form-group">
      <label for="disabledTextInput">Username</label>
      <input type="text" id="disabledTextInput" class="form-control" value="<?=$username?>">
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Password</label>
      <input type="text" id="disabledTextInput" class="form-control" value="<?=$password?>">
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Shared Users</label>
      <input type="text" id="disabledTextInput" class="form-control" value="<?=$shared_users?>">
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Upload Used</label>
      <input type="text" id="disabledTextInput" class="form-control" value="<?=($upload_used != 0) ? $upload_used : '0'?>">
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Download Used</label>
      <input type="text" id="disabledTextInput" class="form-control" value="<?=($download_used != 0) ? $download_used : '0'?>">
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Expired At</label>
      <?=($end_time[0]!='')?'<input type="text" id="disabledTextInput" class="form-control" value="'.$end_time[0].'">':'<input type="text" id="disabledTextInput" class="form-control" value="Account was Expired">'?>
    </div>
  </fieldset>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>