<?php
include('./sql/connection.php');
$API = new RouterosAPI();
$API->debug = false;
    
$num = 0;
if(!$API->connect($host, $user, $pass)){
          echo "Mikrotik Could Not Connect.";
} else{
  $truncate = "TRUNCATE TABLE radius_users";
  $conn->query($truncate);
  $allUsers = $API->comm("/tool/user-manager/user/print");
  foreach($allUsers as $data){
    $package_name = isset($data['actual-profile'])?$data['actual-profile']:'';
    $resp = $API->comm("/tool/user-manager/profile/print", array(
      "?name" => $package_name,
      ".proplist" => "price"
    ));
    $package_price = isset($resp["0"]["price"])?$resp["0"]["price"]:0;
    $user_id = $data['.id'];
    $status = ($data["disabled"] == 'false') ? 1 : 0;
    $download_used = isset($data["download-used"]) ? $data["download-used"] : 0;
    $upload_used = isset($data["upload-used"]) ? $data["upload-used"] : 0;
    $sqlSyncUser = "INSERT INTO `radius_users` (`mikrotik_id`, `username`, `password`, `shared_users`, `download_used`, `upload_used`, `status`) VALUES ('".$user_id."', '".$data["username"]."', '".$data["password"]."', '".$data["shared-users"]."', '".$download_used."', '".$upload_used."', '".$status."')";
    if($package_name == ''){
      $sqlSyncUpdate = "UPDATE `radius_account` SET radius_package_name = '".$package_name."', radius_package_price = $package_price, active_period = '', start_time = '', end_time = '' WHERE radius_user_id = '".$user_id."'";
    }else{
      $sqlSyncUpdate = "UPDATE `radius_account` SET radius_package_name = '".$package_name."', radius_package_price = $package_price WHERE radius_user_id = '".$user_id."'";
    }
    
    $conn->query($sqlSyncUser);
    $conn->query($sqlSyncUpdate);
    // var_dump(($package_id == '')?'true':'false');
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mikrotik Hotspot | Session Status</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>
<body onload="return refreshData()">
<div id="wrap">
    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><?php echo $identity; ?></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#login">Login</a></li>
                    <li class="active"><a href="<?=$linkstatus?>" id="alert">Status</a></li>
                    <li><a href="<?=$linklogout?>" id="alert">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div id="bottom-menu">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xs-10 textlogo text-center">
                    <h1>Bayhost Radius</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="col-md-6 col-sm-12">        
            <div class="row">
                <?php if($error) : ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
            </div>        
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <h3>Welcome, <?= $username ?></h3>
                            </tr>
                            <tr>
                                <td>IP address:</td>
                                <td><?php echo $ip; ?></td>
                            </tr>
                            <tr>
                                <td>bytes up/down</td>
                                <td><?php echo $bytesinnice; ?> / <?php echo $bytesoutnice; ?></td>
                            </tr>
                            <?php if($sessiontimeleft) : ?>
                            <tr>
                                <td>connected / left:</td>
                                <td><?php echo $uptime; ?> / <?php echo $sessiontimeleft; ?></td>
                            </tr>
                            <?php else: ?>
                            <tr>
                                <td>connected:</td>
                                <td><?php echo $uptime; ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if($refreshtimeout) : ?>
                            <tr>
                                <td>status refresh</td>
                                <td><?php echo $refreshtimeout; ?></td>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>    
        <div class="col-md-6 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="card hovercard">
                        <div class="cardheader">
                        </div>
                        <div class="avatar">
                        <img alt="" src="img/bayhost2.png">
                        </div>
                        <div class="info">
                        <div class="title">
                        Bayhost Radius | Hotspot
                        </div>
                        <div class="desc">Internet Speed Bayhost</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    function refreshData(){
        window.setInterval(function(){
            window.location = "<?php echo $linkstatus; ?>";
        }, 60000);
    }
</script>

</body>
</html>

<!-- Main content -->
<div class="container-fluid">
  <div class="row px-2">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <h1 class="m-0 text-dark"><?= $title ?></h1>
    </div>
  </div>
</div>
<section class="content pt-2 pb-1 px-2">
  <div class="container-fluid">
  <div class="card card-primary card-outline">
        <div class="card-header bg-white">
            <h3 class="card-title"><?= $title ?></h3>
            <div class="card-tools">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <a href="admin.php?token=<?=$_SESSION['token']?>&task=add-user" class="btn btn-primary btn-sm"><i class="fa fa-user-plus mr-1"></i> Create User</a>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="table-responsive-sm table-responsive-md">
            <table class="table table-bordered dt-responsive nowrap text-sm" style="width:100%" id="user-table">
              <thead>
                <tr class="bg-info">
                  <th scope="col">No</th>
                  <th scope="col">Username</th>
                  <th scope="col">Package</th>
                  <th scope="col">Shared User</th>
                  <th scope="col">Status User</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
                include_once('./sql/connection.php');
                
                $conn = new mysqli($servername, $userdb, $passworddb, $database);
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
                ORDER BY radius_users.username ASC";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                  
               ?>
                <tr>
                  <td><?= $num=$num+1 ?></td>
                  <td><?= $row['username'] ?></td>
                  <td><?= ($row['radius_package_name']!='')?$row['radius_package_name']:'Package Expired' ?></td>
                  <td><?= $row['shared_users'] ?></td>
                  <td><small><i class="fa fa-circle <?= (strtotime($row['end_time']) < time() || $row['radius_package_name']=='') ? 'text-danger' : 'text-success' ?>"></i></small> <?= (strtotime($row['end_time']) < time() || $row['radius_package_name']=='') ? 'Expired' : 'Active' ?></td>
                  <td class="py-2"><button type="button" class="btn btn-light btn-sm openModal" data-id="<?= $row['radius_user_id']?>" data-toggle="modal" data-id data-target="#myModal"><i class="far fa-eye"> </i></button> <?= ($row['radius_package_name']!='')?'<a class="btn btn-info btn-sm" href="./admin.php?token='.$_SESSION["token"].'&task=edit-user&id='.$row["radius_user_id"].'"><i class="far fa-edit"></i></a>':''?> <button class="btn btn-danger btn-sm" onclick="deleteUser('<?=$row['mikrotik_id']?>','<?=$row['username']?>')"><i class="px-1 far fa-trash-alt"></i></button></td>
               </tr>
              <?php 
                 }
              ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
  </div>
  <!-- /.container -->
</section>
<!-- /.Main content -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <!-- Modal is redirected to external file (modal_{name}.php) -->
    </div>
  </div>
</div>

<!-- <script>

  function getStatus(id){
    console.log(id);
  }

  $(document).ready( function () {
    $('#user-table').DataTable({
      pageLength: 25
    });
    $('.openModal').on('click', function(){
      var user_id = $(this).attr('data-id');
      console.log(user_id);
      $.ajax({
        method: "GET",
        url:"./modal/modal_user.php?id="+user_id,
        cache:false,
        success:function(result){
          $(".modal-content").html(result);
      }});
    });
  });

  function disableUser(id){
    var username = $(".username").val();
    $.ajax({
      method: "GET",
      url: "./userman/process.php?data=user&action=get_status_user",
      data: {
        user_id: id,
      },
      success: function(res) {
        if(res == 'disable'){
          Swal.fire({
            title: 'Action Enable',
            text: "Are you sure to Enable this user?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Enable it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                method: "GET",
                url: "./userman/process.php?data=user&action=disable_user",
                data: {
                  user_id: id,
                },
                success: function(res) {
                  if (res == "success") {
                    Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: 'Success.',
                      showConfirmButton: false,
                      timer: 1000
                    }).then((result) => {
                      if (result.dismiss === Swal.DismissReason.timer) {
                        //console.log('I was closed by the timer')
                        location.reload();
                      }
                    })
                  }else{
                    Swal.fire(
                      'Error!',
                      'Failed.',
                      'error'
                    )
                  }
                }
              })
            }
          })
        }
        else if(res == 'active'){
          Swal.fire({
            title: 'Action Disable',
            text: "Are you sure to Disable this user?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Disable it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                method: "GET",
                url: "./userman/process.php?data=user&action=disable_user",
                data: {
                  user_id: id,
                },
                success: function(res) {
                  if (res == "success") {
                    Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: 'Success.',
                      showConfirmButton: false,
                      timer: 1000
                    }).then((result) => {
                      if (result.dismiss === Swal.DismissReason.timer) {
                        //console.log('I was closed by the timer')
                        location.reload();
                      }
                    })
                  }else{
                    Swal.fire(
                      'Error!',
                      'Failed.',
                      'error'
                    )
                  }
                }
              })
            }
          })
        }
      }
    })
  }

  function deleteUser(id, username){
    Swal.fire({
      title: 'Action Delete',
      text: "Are you sure to Delete user ("+username+") ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            method: "GET",
            url: "./userman/process.php?data=user&action=delete",
            data: {
              user_id: id,
            },
            success: function(res) {
              if (res == "success") {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Success.',
                  showConfirmButton: false,
                  timer: 1000
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                      //console.log('I was closed by the timer')
                      location.reload();
                    }
                })
              }else{
                Swal.fire(
                  'Error!',
                  'Failed.',
                  'error'
                )
              }
            }
          })
        }
    })
  }

    
</script> -->