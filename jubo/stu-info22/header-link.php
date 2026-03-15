<?php
require_once 'session.php';
require_once '../admin/includes/conn.php';
require_once '../admin/includes/dbconfig.php';

date_default_timezone_set("Asia/Dhaka");
?>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
<meta content="Themesbrand" name="author" />

<!-- App favicon -->
<link rel="shortcut icon" href="website/favicon.png">

<!-- DataTables -->
<link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- Plugin Css -->
<link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

<!-- Bootstrap Css -->
<link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="assets/css/style.css">

<?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>

<style>
  table thead tr>th {
    background: rgb(120, 120, 120, 0.8) !important;
    color: #fff !important;
  }
</style>