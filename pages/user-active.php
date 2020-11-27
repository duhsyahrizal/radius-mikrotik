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
            <h3 class="card-title">User Active</h3>
            <div class="card-tools">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <span class="badge badge-primary">Label</span>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered dt-responsive nowrap text-sm" style="width:100%" id="user-table">
                <thead>
                    <tr class="bg-info">
                    <th scope="col">No</th>
                    <th scope="col">User</th>
                    <th scope="col">IP Address</th>
                    <th scope="col">Uptime</th>
                    <th scope="col">Download</th>
                    <th scope="col">Upload</th>
                    <th scope="col">Status</th>
                    <!-- <th scope="col">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                <?php
                    include('./conf/conf.php');
                    include_once('./lib/format-bytes.php');
                    require_once('./lib/routeros_api.class.php');
                    $API = new RouterosAPI();
                    $API->debug = false;
                    $pass = decrypt($pass);
                    $num = 0;
                    if(!$API->connect($host, $user, $pass)){
                      echo "Mikrotik Could Not Connect.";
                    } else{
                      $active_users = $API->comm("/tool/user-manager/session/print", array(
                        "?active" => "true"
                      ));
                      foreach($active_users as $row){
                ?>
                    <tr>
                    <td><?= $num=$num+1 ?></td>
                    <td><?= $row['user'] ?></td>
                    <td><?= $row['user-ip'] ?></td>
                    <td><?= $row['uptime'] ?></td>
                    <td><?= convert_bytes($row['download'], 'M') ?> MB</td>
                    <td><?= convert_bytes($row['upload'], 'M') ?> MB</td>
                    <td><small><i class="fa fa-circle text-success"></i></small> <?= ($row['active'] == 'true') ? 'Online' : '' ?></td>
                    <!-- <td class="py-2"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="far fa-eye mr-1"> </i>Show</button></td> -->
                    </tr>
                    <?php 
                      }
                    }
                    ?>
                </tbody>
            </table>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                  
                </div>
              </div>
            </div>
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
<script>
  $(document).ready( function () {
    $('#user-table').DataTable({
      pageLength: 25,
    });
  });
</script>