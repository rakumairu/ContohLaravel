<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>IKI Portal</title>

  <!-- Font Awesome Icons -->
  <!--   <link rel="stylesheet" href="vendor/admin_lte/plugins/fa-new/css/font-awesome.min.css"> -->
  {{-- <link rel="stylesheet" href="{{ asset('/css/fontawesome.min.css') }}"> --}}
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <link rel="icon" href="{{ asset('/img/i-logo.png') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/css/adminlte.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('/css/dataTables.bootstrap4.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/datepicker.min.css') }}">



  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('/css/toastr.min.css') }}">

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="{{ asset('/js/jquery.min.js') }}"></script>
  <!-- Bootstrap -->
  <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('/js/jquery.overlayScrollbars.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('/js/datepicker.min.js') }}"></script>

  <!-- PAGE SCRIPTS, NOTE: hanya untuk dashboard2-->
  <!-- <script src="vendor/admin_lte/dist/js/pages/dashboard2.js"></script> -->

  <!-- DataTables -->
  <script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('/js/dataTables.bootstrap4.min.js') }}"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="{{ asset('/js/demo.js') }}"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  {{-- <script src="{{ asset('/vendor/admin_lte/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
  <script src="{{ asset('/vendor/admin_lte/plugins/raphael/raphael.min.js') }}"></script>
  <script src="{{ asset('/vendor/admin_lte/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
  <script src="{{ asset('/vendor/admin_lte/plugins/jquery-mapael/maps/world_countries.min.js') }}"></script> --}}
  <!-- ChartJS -->
  <script src="{{ asset('/js/Chart.min.js') }}"></script>

  <!-- Toastr -->
  <script src="{{ asset('/js/toastr.min.js') }}"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-red navbar-dark border-bottom">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav">
          <a style="cursor: pointer;" class="nav-link" onclick="confirm_logout()">
            <i class="fa fa-power-off"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <div class="modal fade" id="confirm_logout">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #DC3545;">
            <h4 class="modal-title" style="color: white;">Confirm Logout</h4>
          </div>
          <div class="modal-body">
            Do you want to logout?
          </div>
          <!-- /.modal-content -->
          <div class="modal-footer ">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button class="btn btn-danger" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">Continue Logout</button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </div>
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <style>
      
      th { font-size: 14px; word-break: normal !important; }
      td { font-size: 12px; }
      td .btn{ font-size: 12px; }
      .consol{
        border: 1px solid red;
      }
      tbody td{
        padding: 7px!important;
      }
      .scrolledTable{ overflow-y: auto; clear:both; overflow-x: auto;}
      .small-button{
        height: 20px;
        padding-top: 0px;
      }
      .form-group label{
        text-align: right;
      }
      .break-word {
        word-break: break-all;
      }
      .btn-danger {
        word-break: normal !important;
      }
      
    </style>