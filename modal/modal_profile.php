<?php
include('../conf/conf.php');
include('../sql/connection.php');
include_once('../lib/format-bytes.php');
require_once('../lib/routeros_api.class.php');
$conn = new mysqli($servername, $userdb, $passworddb, $database);
$m_id = $_GET['id'];
$sql = "SELECT 
        radius_package.radius_package_id,
        radius_package.mikrotik_id,
        radius_package.package_name,
        radius_package.active_period,
        radius_package.time_limit,
        radius_package.quota_limit,
        radius_package.rate_limit,
        radius_package.price,
        mikrotik_package.profile_id,
        mikrotik_package.profile_limitation_id,
        mikrotik_package.limitation_id
        FROM radius_package
        INNER JOIN mikrotik_package ON radius_package.radius_package_id = mikrotik_package.mikrotik_package_id
        WHERE radius_package.mikrotik_id = '".$m_id."'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
  $profile_name = $row['package_name'];
  $validity = ($row['active_period']=='4w2d')?'30 days':$row['active_period'];
  $price = number_format($row['price'], 2, ",", ".");
  $rate_limit = isset($row['rate_limit'])?$row['rate_limit']:0;
  $rate_limit = convert_bytes_without_comm($rate_limit, 'K');
  $quota = isset($row['quota_limit'])?$row['quota_limit']:0;
}
?>
<div class="modal-header bg-primary">
<h5 class="modal-title ml-2" id="exampleModalLabel">Detail Packet (<?=$profile_name?>)</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
  <fieldset class="px-3" disabled>
    <div class="form-group">
      <label for="disabledTextInput">Packet Name</label>
      <input type="text" id="disabledTextInput" class="form-control" value="<?=$profile_name?>">
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Expired</label>
      <input type="text" id="disabledTextInput" class="form-control" value="<?=$validity?>">
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Price</label>
      <input type="text" id="disabledTextInput" class="form-control" value="<?=substr($price,0,1) == '0' ? 'VIP' : 'Rp. '.$price ?>">
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Quota</label>
      <input type="text" id="disabledTextInput" class="form-control" value="<?=($quota != 0) ? convert_bytes($quota, 'G', 0).' GB' : 'Unlimited'?>">
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Rate Limit Upload/Download</label>
      <input type="text" id="disabledTextInput" class="form-control" value="<?=($rate_limit != '') ? $rate_limit.' Kbps' : 'Unlimited'?>">
    </div>
  </fieldset>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>