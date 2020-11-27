<!-- Main content -->
<section class="content pt-3 pb-1 px-2">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header bg-white">
            <h3 class="card-title"><i class="fas fa-user mr-1"></i> <?= $title ?></h3>
            <div class="card-tools">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <button onclick="goBack()" class="btn btn-light btn-sm"><i class="fa fa-times px-1"></i></button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form class="text-sm" action="./userman/process.php?data=user&action=save" method="post">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Please type username for new user" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <div class="input-group mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Please type your strong password" aria-label="Recipient's username" aria-describedby="button-addon2" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <input type="checkbox" name="check" id="check">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="shared_users">Select Shared Users</label>
              <select class="custom-select" id="shared_users" name="shared_users">
              <?php foreach($option_shared_user as $row) : ?>
                <option><?=$row?></option>
              <?php endforeach ?>
              </select>
            </div>
            <div class="form-row mb-3">
              <div class="col-6">
                <label>Start Date</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="text" class="form-control reservationtime" id="start_date" name="start_date" autocomplete="off" aria-describedby="expiredHelp">
                </div>
                <small id="expiredHelp" class="form-text text-muted">Format Date : (<strong>dd-mm-yyyy</strong>). Example : 02-01-2000</small>
              </div>
              <div class="col-6">
                <label>End Date</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="text" class="form-control reservationtime" id="end_date" name="end_date" autocomplete="off" aria-describedby="expiredHelp">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="profile">Choose Package</label>
              <select class="custom-select" id="profile" name="profile">
              <?php foreach($profiles as $row) : ?>
                <option value="<?=$row['.id']?>"><?=$row['name']?></option>
              <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <label for="payment">Payment Method</label>
              <select class="custom-select" id="payment" name="payment">
                <option value="1">Cash</option>
                <option value="2">Transfer</option>
                <option value="3">Hutang</option>
              </select>
            </div>
            <div id="group-description" class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <h6 class="mt-4 mb-2 text-secondary">Additional Information (Optional)</h6>
            <div class="form-group">
              <label for="fullname">Full Name</label>
              <input type="text" class="form-control" name="fullname" placeholder="Please type your full name">
            </div>
            <div class="form-group">
              <label for="place_of_birth">Place of Birth</label>
              <input type="text" class="form-control" name="place_of_birth" placeholder="Please type your full name">
            </div>
            <div class="form-group">
              <label>Date of Birth</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input placeholder="Please type for user's birthday" type="text" class="form-control datepicker" name="date_of_birth" autocomplete="off" aria-describedby="birthdayHelp">
              </div>
              <small id="birthdayHelp" class="form-text text-muted">Format Date : (<strong>dd-mm-yyyy</strong>). Example : 02-01-2000</small>
            </div>
            <label for="gender">Gender :</label>
            <div class="ml-2 mb-3 form-check form-check-inline">
              <input class="form-check-input" type="radio" id="inlineRadio1" name="gender" value="Male">
              <label class="form-check-label" for="inlineRadio1">Male</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="inlineRadio2" name="gender" value="Female">
              <label class="form-check-label" for="inlineRadio2">Female</label>
            </div>
            <div class="form-group">
              <label for="boarding_house_name">Boarding House Name</label>
              <input type="text" class="form-control" name="boarding_house_name" placeholder="Please type user's boarding house name">
            </div>
            <div class="form-group">
              <label for="telephone">Telp/Whatsapp</label>
              <input type="text" class="form-control" name="telephone" placeholder="Please type user's telp/whatsapp">
            </div>
            <button type="submit" class="btn btn-primary">Create User</button>
          </form>
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

<script type="text/javascript">
  $(function(){
  $(".datepicker").datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true
    });
  });
  $("#start_date").val("<?=$date?>");
  $("#end_date").val("<?=$endDate?>");
  
  $("#group-description").hide();
  $("#payment").on("change", function(){
    $(this).find("option:selected").each(function(){
      var payment = $(this).attr("value");
      // alert(payment);
      if(payment != '1'){
        $("#group-description").show();
      } else{
        $("#group-description").hide();
      }
    });
  });
</script>