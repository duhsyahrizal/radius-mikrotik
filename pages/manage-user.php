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
                  <th scope="col">Group</th>
                  <th scope="col">Manage Package</th>
                  <th scope="col">Manage Radius User</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
                include_once('./sql/connection.php');
                
                $conn = new mysqli($servername, $userdb, $passworddb, $database);
                $sql = "SELECT 
                bayhost_users.bayhost_user_id,
                bayhost_users.username,
                bayhost_users.password,
                role_group.role_name,
                role_group.manage_user,
                role_group.manage_package
                FROM bayhost_users
                INNER JOIN role_group ON role_group.role_group_id = bayhost_users.role";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                  
               ?>
                <tr>
                  <td><?= $num=$num+1 ?></td>
                  <td><?= $row['username'] ?></td>
                  <td><?= $row['role_name'] ?></td>
                  <td><?= $row['manage_user'] ?></td>
                  <td><?= $row['manage_package'] ?></td>
                  <td class="py-2"><button type="button" class="btn btn-light btn-sm openModal" data-id="<?= $row['bayhost_user_id']?>" data-toggle="modal" data-id data-target="#myModal"><i class="far fa-eye"> </i></button> <button type="button" class="btn btn-info btn-sm" onclick="editUser(<?= $row['bayhost_user_id']?>)"><i class="far fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="deleteUser('<?=$row['bayhost_user_id']?>','<?=$row['username']?>')"><i class="px-1 far fa-trash-alt"></i></button></td>
               </tr>
              <?php 
                 }
              ?>
              </tbody>
            </table>
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

<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
    <div class="modal-header bg-primary">
      <h5 class="modal-title ml-2" id="exampleModalLabel">Edit User</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <div>
          <div class="form-group">
            <label for="user">Username</label>
            <input type="hidden" id="user_id">
            <input type="text" id="user" class="form-control">
          </div>
          <div class="form-group">
            <label for="pass">Password</label>
            <input type="password" id="password" class="form-control">
          </div>
          <div class="form-group">
            <label for="group">Group</label>
            <select class="custom-select" id="group">
            <?php
            $sqlRole = "SELECT * FROM role_group";
            $resultRole = $conn->query($sqlRole);
            while($row = $resultRole->fetch_assoc()){ ?>
              <option value="<?=$row['role_group_id']?>"><?=$row['role_name']?></option>
            <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
      <button type="submit" onclick="updateUser()" class="btn btn-primary">Update</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>

  function getStatus(id){
    console.log(id);
  }

  $(document).ready( function () {
    $('#user-table').DataTable({
      pageLength: 10
    });
  });
  function editUser(id){
    $.ajax({
      method: "GET",
      url:"./userman/process.php?action=edit-user&data=user-bayhost",
      data: {
        user_id: id,
      },
      success:function(res){
        // console.log(res);
        var obj = JSON.parse(res);
        $('#user_id').val(obj.bayhost_user_id);
        $('#user').val(obj.username);
        $('#password').val(obj.password);
        $('#manage_user').val(obj.manage_user);
        $('#manage_package').val(obj.manage_package);
        $('#modal-edit').modal();
    }});
  }

  function updateUser() {
    Swal.fire({
      title: 'Update User?',
      text: "Apakah Anda yakin ingin merubah data user ini?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, do it!'
    }).then((result) => {
      if (result.isConfirmed) {
        
        $.ajax({
          method: "POST",
          url: "process.php?action=update-user&data=user-bayhost",
          data: {
            user_id: $("#user_id").val(),
            username: $("#user").val(),
            password: $("#password").val(),
            group: $("#group").val(),
          },
          success: function(res) {
            console.log(res)
            // if (res == "success") {
            //   Swal.fire({
            //     position: 'center',
            //     icon: 'success',
            //     title: 'Berhasil merubah data lisensi.',
            //     showConfirmButton: false,
            //     timer: 1500
            //   }).then((result) => {
            //     if (result.dismiss === Swal.DismissReason.timer) {
            //      location.reload();
            //     }
            //   })
            // }else{
            //   Swal.fire(
            //     'Error!',
            //     'Gagal merubah data lisensi.',
            //     'error'
            //   )
            // }
          }
        })
        
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
            method: "POST",
            url: "./userman/process.php?data=user-bayhost&action=delete-user",
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

    
</script>