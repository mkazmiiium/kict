<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{config('app.name')}}</title>
{{-- browser --}}
  @php
        $browser = request()->userAgent();
        if (!strstr($browser, 'Chrome')) {
            echo 'Please use Chrome Browser to Access the System';
            die();
        }
  @endphp

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Home</a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> --}}
    </ul>

    <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">2</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{asset('dist/img/user1-128x128.jpg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{asset('dist/img/user8-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            {{-- <div class="media">
              <img src="{{asset('dist/img/user3-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div> --}}
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      {{-- <img src="{{asset('dist/img/iir4-logo.png')}}" alt="AdminLTE Logo" class="brand-image img-square elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light">K I C T</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="/" class="d-block">User</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-header">BOOKING SYSTEM</li>
                <li class="nav-item" class="nav-link">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-user-md" aria-hidden="true"></i>
                        <p>
                          Undergraduate
                          <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/Decentralised-booking" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                    <p>
                                    Final Assessment
                                    </p>
                            </a>
                        </li>

                        <li class="nav-item" class="nav-link">
                            <a href="/Centralised-booking" class="nav-link">
                                <i class="nav-icon fas fa-pencil-alt"></i>
                                <p>
                                Centralised Examination
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item" class="nav-link">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-graduation-cap" aria-hidden="true"></i>
                        <p>
                          Postgraduate
                          <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/PGDecentralised-booking" class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>
                                    Final Assessment
                                </p>
                            </a>
                        </li>

                        <li class="nav-item" class="nav-link">
                            <a href="/PGCentralised-booking" class="nav-link">
                                <i class="nav-icon fas fa-pencil-alt"></i>
                                <p>
                                    Centralised Examination
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
            </li>

            {{-- <a href="#" class="nav-link">
              <i class="nav-icon fa fa-user-circle" aria-hidden="true"></i>
              <p>
                System Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/adduser" class="nav-link">
                    <i class="nav-icon fa fa-plus" aria-hidden="true"></i>
                    <p>New User</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-wrench" aria-hidden="true"></i>
                    <p>Update Users</p>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="pages/mailbox/compose.html" class="nav-link">
                      <i class="nav-icon fa fa-eye" aria-hidden="true"></i>
                      <p>View Users</p>
                    </a>
                </li>
            </ul>


          </li>
          <li class="nav-item" class="nav-link">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-users" aria-hidden="true"></i>
              <p>
                IIR4.0 Staffs
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/addstaff" class="nav-link">
                    <i class="nav-icon fa fa-plus" aria-hidden="true"></i>
                    <p>New Staff</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/vieweditstaffs" class="nav-link">
                    <i class="nav-icon fa fa-wrench" aria-hidden="true"></i>
                    <p>Update Staffs</p>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="/viewstaffs" class="nav-link">
                      <i class="nav-icon fa fa-eye" aria-hidden="true"></i>
                      <p>View Staffs</p>
                    </a>
                </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-user-md" aria-hidden="true"></i>
              <p>
                Supervisors
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/addinternalsv" class="nav-link">
                    <i class="nav-icon fa fa-plus" aria-hidden="true"></i>
                    <p>New Internal SV</p>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="/addsupervisor" class="nav-link">
                      <i class="nav-icon fa fa-plus" aria-hidden="true"></i>
                      <p>New External SV</p>
                    </a>
                  </li>
                <li class="nav-item">
                  <a href="/vieweditsv" class="nav-link">
                    <i class="nav-icon fa fa-wrench" aria-hidden="true"></i>
                    <p>Update SV</p>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="/viewsv" class="nav-link">
                      <i class="nav-icon fa fa-eye" aria-hidden="true"></i>
                      <p>View SV</p>
                    </a>
                </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-check-square" aria-hidden="true"></i>
              <p>
                Examiners
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/addinternalexaminer" class="nav-link">
                    <i class="nav-icon fa fa-plus" aria-hidden="true"></i>
                    <p>New Internal Examiner</p>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="/addexaminerext" class="nav-link">
                      <i class="nav-icon fa fa-plus" aria-hidden="true"></i>
                      <p>New External Examiner</p>
                    </a>
                  </li>
                <li class="nav-item">
                  <a href="/vieweditexaminer" class="nav-link">
                    <i class="nav-icon fa fa-wrench" aria-hidden="true"></i>
                    <p>Update Examiners</p>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="/viewexaminer" class="nav-link">
                      <i class="nav-icon fa fa-eye" aria-hidden="true"></i>
                      <p>View Examiners</p>
                    </a>
                </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-coffee" aria-hidden="true"></i>
              <p>
                Chairman
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/addchairman" class="nav-link">
                    <i class="nav-icon fa fa-plus" aria-hidden="true"></i>
                    <p>New Chairman</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/vieweditchairman" class="nav-link">
                    <i class="nav-icon fa fa-wrench" aria-hidden="true"></i>
                    <p>Update Chairman</p>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="/viewchairman" class="nav-link">
                      <i class="nav-icon fa fa-eye" aria-hidden="true"></i>
                      <p>View Chairman</p>
                    </a>
                </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-graduation-cap" aria-hidden="true"></i>
              <p>
                Students
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/addstudent" class="nav-link">
                    <i class="nav-icon fa fa-plus" aria-hidden="true"></i>
                    <p>New Student</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/vieweditstudent" class="nav-link">
                    <i class="nav-icon fa fa-wrench" aria-hidden="true"></i>
                    <p>Update Students</p>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="/viewstudents" class="nav-link">
                      <i class="nav-icon fa fa-eye" aria-hidden="true"></i>
                      <p>View Students</p>
                    </a>
                </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-desktop" aria-hidden="true"></i>
              <p>
                VIVA Event
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/addevent" class="nav-link">
                    <i class="nav-icon fa fa-plus" aria-hidden="true"></i>
                    <p>New VIVA</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/vieweditevents" class="nav-link">
                    <i class="nav-icon fa fa-wrench" aria-hidden="false"></i>
                    <p>Update VIVA</p>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="/viewevents" class="nav-link">
                      <i class="nav-icon fa fa-eye" aria-hidden="true"></i>
                      <p>View Events</p>
                    </a>
                </li>
            </ul>
          </li> --}}

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @include('inc.messages')
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021-2025 Academic Office </a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b><em>Project by CITINOV for KICT Academic Office</b> Beta Ver. </em>
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>

<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
</body>
</html>
