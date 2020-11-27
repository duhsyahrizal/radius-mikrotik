<?php
if(isset($_GET['task'])){
    $task = $_GET['task'];
    switch($task){
      case 'dashboard':
        $title = ucfirst($task);
        break;
      case 'user-list':
        $title = 'User';
        break;
      case 'router-client':
        $title = 'Router Client';
        break;
      case 'add-user':
        $title = 'Form Create User';
        break;
      case 'edit-user':
        $title = 'Form Edit User';
        break;
      case 'profile-list':
        $title = 'Package';
        break;
      case 'add-profile':
        $title = 'Form Create Package';
        break;
      case 'edit-profile':
        $title = 'Form Edit Package';
        break;
      case 'user-active':
        $title = 'Monitor Online';
        break;
      case 'voucher':
        $title = ucfirst($task);
        break;
      case 'system':
        $title = ucfirst($task);
        break;
      case 'preference':
        $title = ucfirst($task);
        break;
      case 'report':
        $title = ucfirst($task);
        break;
      case 'report-data':
        $title = 'Report Data';
        break;
    }
}
?>