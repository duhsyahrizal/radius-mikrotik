<?php
  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date'];

?>
<div class="container-fluid">
  <div class="row px-2">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <h1 class="m-0 text-dark">All Reports</h1>
    </div>
  </div>
</div>
<!-- Main content -->
<section class="content px-2">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
      <div class="card card-primary card-outline">
        <div class="card-header bg-white">
            <h3 class="card-title"><i class="far fa-file-alt mr-1"></i> Radius Reports <strong><?= $start_date ?></strong> to <strong><?= $end_date ?></strong></h3>
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
            <table class="table table-bordered" id="report-table">
                <thead>
                  <tr>
                  <th scope="col">No</th>
                  <th scope="col">Radius Username</th>
                  <th scope="col">Payment</th>
                  <th scope="col">Description</th>
                  <th scope="col">Package</th>
                  <th scope="col">Price</th>
                  <th scope="col">Created By</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  include_once('./sql/connection.php');

                  $conn = new mysqli($servername, $userdb, $passworddb, $database);
                  $sql = "SELECT 
                  radius_report.radius_report_id,
                  radius_report.radius_user_name,
                  radius_report.payment,
                  radius_report.package,
                  radius_report.price,
                  radius_report.created_by,
                  radius_payment.payment_name,
                  radius_payment.description
                  FROM radius_report
                  INNER JOIN radius_payment ON radius_report.radius_report_id = radius_payment.radius_payment_id
                  WHERE created_at BETWEEN '".$start_date."' AND '".$end_date."'";
                  $resultReport = $conn->query($sql); 
                  $num = 0;
                  while($row=$resultReport->fetch_assoc()){
                    $num=$num+1;
                    if($row['payment'] == 1){
                      $payment = "Cash";
                    }
                    else if($row['payment'] == 2){
                      $payment = "Transfer";
                    }
                    else {
                      $payment = "Hutang";
                    }
                  ?>
                  <tr>
                  <td><?= $num ?></td>
                  <td><?= $row['radius_user_name'] ?></td>
                  <td><?= $payment ?></td>
                  <td><?= $row['description'] ?></td>
                  <td><?= $row['package'] ?></td>
                  <td><?= $row['price'] ?></td>
                  <td><?= ucfirst($row['created_by']) ?></td>
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

<script>

</script>
    