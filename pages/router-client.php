<div class="container-fluid">
  <div class="row px-2">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <h1 class="m-0 text-dark">Router Client</h1>
    </div>
  </div>
</div>
<!-- Main content -->
<section class="content px-2">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
      <div class="card card-primary card-outline">
        <div class="card-header bg-white">
            <h3 class="card-title"><i class="fas fa-radiation mr-1"></i> Router Client</h3>
            <div class="card-tools">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <!-- <a href="admin.php?token=<?=$_SESSION['token']?>&page=add-router" class="btn btn-primary btn-sm"><i class="fa fa-plus mr-1"></i> Add Router</a> -->
            </div>
            <!-- /.card-tools -->
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                  <tr>
                  <th scope="col">#</th>
                  <th scope="col">Type</th>
                  <th scope="col">Host Address</th>
                  <th scope="col">Location</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  include('./sql/connection.php');
                  $num = 0;
                  while($row=$res->fetch_assoc()){
                    $num=$num+1
                  ?>
                  <tr>
                  <td><?= $num ?></td>
                  <td><?= ucfirst($row['type']) ?></td>
                  <td><?= $row['host'] ?></td>
                  <td><?= ucwords($row['boarding_house_name']) ?></td>
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
</section>
<!-- /.Main content -->
    