<div class="container-fluid">
  <div class="row px-2">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <h1 class="m-0 text-dark">Dashboard</h1>
    </div>
  </div>
</div>
<!-- Main content -->
<section class="content px-2">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $total_router ?></h3>

                <p>Radius Router</p>
              </div>
              <div class="icon">
                <i class="ion ion-nuclear"></i>
              </div>
              <a href="admin.php?token=<?=$_SESSION['token']?>&task=router-client" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $cpu ?><sup style="font-size: 20px">%</sup></h3>

                <p>CPU Load</p>
              </div>
              <div class="icon">
                <i class="ion ion-speedometer"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner text-white">
                <h3><?= $active_users ?></h3>

                <p>Active Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="admin.php?token=<?=$_SESSION['token']?>&task=user-active" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $all_user ?></h3>

                <p>All Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-people"></i>
              </div>
              <a href="admin.php?token=<?=$_SESSION['token']?>&task=user-list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">List All Radius Client</h3>
            <div class="card-tools">
            <!-- Buttons, labels, and many other things can be placed here! -->
            </div>
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
    