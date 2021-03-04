<?php
  $sessi_user = $_SESSION['user'];
  $sqlSessi = "SELECT role FROM bayhost_users WHERE username = '".$sessi_user."'";
  $resSessi = $conn->query($sqlSessi);
  $responseSessi = $resSessi->fetch_assoc();
  $role = $responseSessi['role'];
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="dist/img/bayhost2.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="ml-1 brand-text">Bayhost Radius</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-2 pb-2 mb-2 d-flex">
          <div class="info px-3">
            <a href="#" class="d-block">Hai <?= ucfirst($_SESSION['user']) ?></a>
          </div>
        </div>
      <!-- Sidebar Menu -->
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header pt-3 pb-1">MENU</li>
          <li class="nav-item">
            <a href="admin.php?token=<?=$_SESSION['token']?>&task=dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="admin.php?token=<?=$_SESSION['token']?>&task=router-client" class="nav-link">
              <i class="nav-icon fas fa-radiation-alt"></i>
              <p>
                Router Client
              </p>
            </a>
          </li>
          
          <li class="nav-header pt-3 pb-1">RADIUS</li>
          <li class="nav-item">
            <a href="admin.php?token=<?=$_SESSION['token']?>&task=user-list" class="nav-link <?= ($_GET['task'] == 'add-user' || $_GET['task'] == 'edit-user') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Radius Users
              </p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="admin.php?token=<?=$_SESSION['token']?>&task=voucher" class="nav-link">
              <i class="nav-icon fas fa-receipt"></i>
              <p>
                Voucher
              </p>
            </a>
          </li> -->
          <li class="nav-item">
            <a href="admin.php?token=<?=$_SESSION['token']?>&task=profile-list" class="nav-link  <?= ($_GET['task'] == 'add-profile' || $_GET['task'] == 'edit-profile') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>
                Package List
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="admin.php?token=<?=$_SESSION['token']?>&task=user-active" class="nav-link">
              <i class="nav-icon fas fa-desktop"></i>
              <p>
                Monitor Online
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="admin.php?token=<?=$_SESSION['token']?>&task=migration-package" class="nav-link">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>
                Migration Package
              </p>
            </a>
          </li>
          <li class="nav-header pt-3 pb-1">MISC</li>
          <li class="nav-item">
            <a href="admin.php?token=<?=$_SESSION['token']?>&task=report" class="nav-link <?= ($_GET['task'] == 'report-data') ? 'active' : '' ?>">
              <i class="nav-icon far fa-file-alt"></i>
              <p>
                Reports
              </p>
            </a>
          </li>
          <li class="nav-item <?= ($_SESSION['user'] != 'admin') ? 'd-none' : '' ?>">
            <a href="admin.php?token=<?=$_SESSION['token']?>&task=preference" class="nav-link">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                Preferences
              </p>
            </a>
          </li>
          <li class="nav-header pt-3 pb-1">SETTINGS</li>
          <li class="nav-item has-treeview">
            <a href="admin.php?token=<?=$_SESSION['token']?>&task=system" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                System
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>