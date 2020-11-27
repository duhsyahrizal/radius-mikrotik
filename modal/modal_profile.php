<?php
include('../conf/conf.php');
include_once('../lib/format-bytes.php');
require_once('../lib/routeros_api.class.php');
$API = new RouterosAPI();
$API->debug = false;

$pass = decrypt($pass);
$num = 0;
if(!$API->connect($host, $user, $pass)){
    echo "Mikrotik Could Not Connect.";
} else{
  $m_id = $_GET['id'];
  $profile = $API->comm("/tool/user-manager/profile/print", array(
    "?.id" => $m_id
  ));
  foreach($profile as $row){
    $profile_name = $row['name'];
    $validity = ($row['validity']=='4w2d')?'30 days':'Unlimited';
    $price = number_format($row['price'], 2, ",", ".");
    $limitation = $API->comm("/tool/user-manager/profile/limitation/print", array(
      ".proplist" => ".id,transfer-limit,rate-limit-rx",
      "?name" => $profile_name
    ));
    $rate_limit = isset($limitation[0]['rate-limit-rx'])?$limitation[0]['rate-limit-rx']:0;
    $rate_limit = convert_bytes_without_comm($rate_limit, 'K');
    $quota = isset($limitation[0]['transfer-limit'])?$limitation[0]['transfer-limit']:0;
  }
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