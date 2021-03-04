<!-- Main content -->
<section class="content pt-3 pb-1 px-2">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header bg-white">
            <h3 class="card-title">Edit User</h3>
            <div class="card-tools">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <button onclick="goBack()" class="btn btn-light btn-sm"><i class="fa fa-times px-1"></i></button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form class="text-sm" action="./userman/process.php?data=user&action=edit" method="post">
          <input type="hidden" name="id" value="<?=$mikrotik_id?>">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" value="<?=$username?>" id="username" name="username" placeholder="Change your username" required="true" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <div class="input-group mb-3">
                <input type="password" class="form-control" value="<?=$password?>" id="password" name="password" placeholder="Please change your old password" aria-label="Recipient's username" aria-describedby="button-addon2" required>
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
                <option <?= ($row==$shared_users) ? 'selected' : '' ?>><?=$row?></option> 
              <?php endforeach ?>
              </select>
            </div>
            <h6 class="mt-4 mb-2 text-secondary">Additional Information (Optional)</h6>
            <div class="form-group">
              <label for="fullname">Full Name</label>
              <input type="text" class="form-control" name="fullname" placeholder="Please type your full name">
            </div>
            <div class="form-group">
              <label for="birthplace">Place of Birth</label>
              <input type="text" class="form-control" name="birthplace" placeholder="Please type your full name">
            </div>
            <div class="form-group">
              <label>Date of Birth</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input placeholder="Please type for user's birthday" type="text" class="form-control datepicker" name="tgl_awal" aria-describedby="birthdayHelp" autocomplete="off">
              </div>
              <small id="birthdayHelp" class="form-text text-muted">Format Date : (<strong>dd-mm-yyyy</strong>). Example : 02-01-2000</small>
            </div>
            <label for="expired">Gender :</label>
            <div class="ml-2 mb-3 form-check form-check-inline">
              <input class="form-check-input" type="radio" id="inlineRadio1" name="expired" value="Male">
              <label class="form-check-label" for="inlineRadio1">Male</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="inlineRadio2" name="expired" value="Female">
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
            <button type="submit" class="btn btn-primary">Update</button>
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
      autoclose: true,
      todayHighlight: true,
  });
 });
</script>