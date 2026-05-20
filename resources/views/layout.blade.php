<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
   <meta name="Author" content="Spruko Technologies Private Limited">
   <meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />
   <!-- Title -->
   <title> Nowa - Premium dashboard ui bootstrap rwd admin html5 template </title>
   <!-- Favicon -->
   <link rel="icon" href="{{asset('assets/img/brand/favicon.png')}}" type="image/x-icon" />
   <!-- Icons css -->
   <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
   <!--  bootstrap css-->
   <link id="style" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
   <!-- style css -->
   <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
   <link href="{{asset('assets/css/style-dark.css')}}" rel="stylesheet">
   <link href="{{asset('assets/css/style-transparent.css')}}" rel="stylesheet">
   <!---Skinmodes css-->
   <link href="{{asset('assets/css/skin-modes.css')}}" rel="stylesheet" />
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="ltr main-body app sidebar-mini">
   <!-- Loader -->
   <div id="global-loader">
      <img src="{{asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
   </div>
   <!-- /Loader -->
   <!-- Page -->
   <div class="page">
     <div id="app"></div>
      @vite(['resources/js/app.js'])
   </div>
   <!-- End Page -->

   <!-- Back-to-top -->
   <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>
   <!-- JQuery min js -->
   <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
   <!-- Bootstrap js -->
   <script src="{{asset('assets/plugins/bootstrap/js/popper.min.js')}}"></script>
   <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
   <!-- Internal Chart.Bundle js-->
   <script src="{{asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
   <!-- Moment js -->
   <script src="{{asset('assets/plugins/moment/moment.js')}}"></script>
   <!-- INTERNAL Apexchart js -->
   <script src="{{asset('assets/js/apexcharts.js')}}"></script>
   <!--Internal Sparkline js -->
   <script src="{{asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
   <!-- Moment js -->
   <script src="{{asset('assets/plugins/raphael/raphael.min.js')}}"></script>
   <!--Internal  Perfect-scrollbar js -->
   <script src="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
   <script src="{{asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>
   <!-- Eva-icons js -->
   <script src="{{asset('assets/js/eva-icons.min.js')}}"></script>
   <!-- right-sidebar js -->
   <script src="{{asset('assets/plugins/sidebar/sidebar.js')}}"></script>
   <script src="{{asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>
   <!-- Sidebar js -->
   <script src="{{asset('assets/plugins/side-menu/sidemenu.js')}}"></script>
   <!-- Sticky js -->
   <script src="{{asset('assets/js/sticky.js')}}"></script>
   <!--Internal  index js -->
   <script src="{{asset('assets/js/index.js')}}"></script>
   <!-- Chart-circle js -->
   <script src="{{asset('assets/js/circle-progress.min.js')}}"></script>
   <!-- Internal Data tables -->
   <script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
   <script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
   <script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
   <script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>
   <!-- INTERNAL Select2 js -->
   <script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
   <script src="{{asset('assets/js/select2.js')}}"></script>
   <!-- Theme Color js -->
   <script src="{{asset('assets/js/themecolor.js')}}"></script>
   <!-- custom js -->
   <script src="{{asset('assets/js/custom.js')}}"></script>
</body>

</html>