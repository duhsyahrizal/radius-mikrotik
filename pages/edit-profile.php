<!-- Main content -->
<section class="content pt-3 pb-1 px-2">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header bg-white">
            <h3 class="card-title">Edit Packet</h3>
            <div class="card-tools">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <button onclick="goBack()" class="btn btn-light btn-sm"><i class="fa fa-times px-1"></i></button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form class="text-sm" action="./userman/process.php?data=package&action=edit" method="post">
          <input type="hidden" name="id" value="<?=$mikrotik_id?>">
            <div class="form-group">
              <label for="name">Packet Name</label>
              <input type="text" class="form-control" value="<?=$name?>" id="name" name="name" placeholder="Type your packet name" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="uptime">Time Limit</label>
              <div class="input-group">
                <input type="text" class="form-control" value="<?=$uptime?>" id="uptime" name="uptime" autocomplete="off" placeholder="Please set time limit for your packet" aria-describedby="timeHelp">
                <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2">Hour</span>
                </div>
              </div>
              <small id="timeHelp" class="form-text text-muted">Don't change this if you do not want to set by <strong>Time based</strong>. Format Time: (<strong>/Hour</strong>)</small>
            </div>
            <div class="form-row mb-3">
              <div class="col-10">
              <label for="transfer_limit">Quota Limit</label>
              <input type="text" class="form-control" value="<?=$quota?>" id="transfer_limit" name="transfer_limit" autocomplete="off" placeholder="Please set quota limit if you want to set by volume based period for your packet" aria-describedby="volumeHelp">
              <small id="volumeHelp" class="form-text text-muted">Don't change this if you do not want to set by <strong>Volume based</strong>. Default Format Size (<strong>GB</strong>)</small>
              </div>
              <div class="col-2">
              <label for="format_size">Format Size</label>
              <select class="custom-select" id="format_size" name="format_size">
                <option>MB</option>
                <option selected>GB</option>
              </select>
              </div>
            </div>
            <label for="expired">Active Period :</label>
            <div class="ml-2 mb-3 form-check form-check-inline">
              <input class="form-check-input" type="radio" name="expired" id="inlineRadio1"  value="<?=($validity == "4w2d") ? "30d" : $validity ?>" checked>
              <label class="form-check-label" for="inlineRadio1">30 days</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="expired" id="inlineRadio2" value="60d">
              <label class="form-check-label" for="inlineRadio2">60 days</label>
            </div>
            <div class="form-group">
              <label for="rate_limit">Rate Download/Upload</label>
              <div class="input-group">
                <select class="custom-select" id="rate_limit" name="rate_limit" aria-describedby="rateHelp">
                <?php foreach($rate_limits as $row) : ?>
                  <option <?= ($row==$rate_limit)?'selected':'' ?>><?=$row?></option> 
                <?php endforeach ?>
                </select>
                <div class="input-group-append">
                  <span class="input-group-text">Kbps</span>
                </div>
              </div>
              <small id="rateHelp" class="form-text text-muted">Format Download/Upload: <strong>Kbps</strong></small>
            </div>
            <div class="form-group pb-2">
              <label for="price">Price</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">RP</span>
                </div>
                <input type="text" class="form-control" value="<?=$price?>" id="price" name="price" autocomplete="off" placeholder="Please set price for new packet" required>
              </div>
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