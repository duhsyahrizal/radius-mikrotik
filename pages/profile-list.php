<?php
include('./sql/connection.php');
$API = new RouterosAPI();
$API->debug = false;
    
$num = 0;
if(!$API->connect($host, $user, $pass)){
          echo "Mikrotik Could Not Connect.";
} else{
  $truncate = "TRUNCATE TABLE radius_package";
  $conn->query($truncate);
  $truncateMikrotik = "TRUNCATE TABLE mikrotik_package";
  $conn->query($truncateMikrotik);
  $package = $API->comm("/tool/user-manager/profile/print");
  foreach($package as $data){
    $limitation = $API->comm("/tool/user-manager/profile/limitation/print", array(
      "?name" => $data['name'],
      ".proplist" => ".id,uptime-limit,transfer-limit,rate-limit-rx"
    ));
    $profLimit = $API->comm("/tool/user-manager/profile/profile-limitation/print", array(
      "?profile" => $data['name'],
      ".proplist" => ".id"
    ));
    $rate_limit = isset($limitation[0]['rate-limit-rx']) ? $limitation[0]['rate-limit-rx'] : 0;
    $sqlInsertId = "INSERT INTO mikrotik_package (`profile_id`, `limitation_id`, `profile_limitation_id`) VALUES ('".$data['.id']."', '".$limitation[0]['.id']."', '".$profLimit[0]['.id']."')";
    $sqlSync = "INSERT INTO radius_package (`mikrotik_id`, `package_name`, `active_period`, `time_limit`, `quota_limit`, `rate_limit`, `price`) VALUES ('".$data[".id"]."', '".$data["name"]."', '".$data["validity"]."', '".$limitation[0]["uptime-limit"]."', '".$limitation[0]["transfer-limit"]."', '".$rate_limit."', '".$data["price"]."')";
    $conn->query($sqlInsertId);
    $conn->query($sqlSync);
  }
}

?>
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
            <h3 class="card-title"><i class="fa fa-list mr-1"></i> <?= $title ?></h3>
            <div class="card-tools">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <a href="admin.php?token=<?=$_SESSION['token']?>&task=add-profile" class="btn btn-primary btn-sm"><i class="fa fa-plus mr-1"></i> Create New Package</a>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered dt-responsive nowrap text-sm" style="width:100%" id="profile-table">
              <thead>
                <tr class="bg-info">
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Expired</th>
                  <th scope="col">Price</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
            <tbody>
            <?php
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
                INNER JOIN mikrotik_package ON radius_package.radius_package_id = mikrotik_package.mikrotik_package_id";
                
                $result = $conn->query($sql);
                echo $conn->error;
                while($row = $result->fetch_assoc()){
                ?>
                <tr>
                  <td><?= $num=$num+1 ?></td>
                  <td id="package_name"><?= $row["package_name"] ?></td>
                  <td><?= ($row["active_period"] == "4w2d") ? "30 days" : $row["active_period"] ?></td>
                  <td>Rp. <?= number_format($row['price'], 2, ",", ".") ?></td>
                  <td class="py-2"><button type="button" class="btn btn-light btn-sm openModal" data-id="<?= $row['mikrotik_id']?>" data-toggle="modal" data-id data-target="#myModal"><i class="far fa-eye"> </i></button> <a class="btn btn-info btn-sm" href="./admin.php?task=edit-profile&id=<?= $row['mikrotik_id']?>"><i class="far fa-edit"></i></a> <button class="btn btn-danger btn-sm" onclick="deletePackage('<?= $row['profile_id'] ?>', '<?= $row['limitation_id'] ?>', '<?= $row['profile_limitation_id'] ?>', '<?= $row['package_name'] ?>')"><i class="px-1 far fa-trash-alt"></i></a></td>
                </tr>
                <?php 
                  }
                ?>
                </tbody>
            </table>
          </div>
        <!-- /.card-body -->
        <!-- <div class="card-footer">
            The footer of the card
        </div> -->
        <!-- /.card-footer -->
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

<script>
  $(document).ready( function () {
    $('#profile-table').DataTable({
      pageLength: 25,
    });
    $('.openModal').on('click', function(){
      var user_id = $(this).attr('data-id');
      console.log(user_id);
      $.ajax({url:"./modal/modal_profile.php?id="+user_id,cache:false,success:function(result){
          $(".modal-content").html(result);
      }});
    })
  });

  function deletePackage(id,id_2, id_3, profile){
    Swal.fire({
      title: 'Action Delete',
      text: "Are you sure to delete package ("+profile+") ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            method: "GET",
            url: "./userman/process.php?data=package&action=delete",
            data: {
              profile_id: id,
              limit_id: id_2,
              profile_limit_id: id_3
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
</script>