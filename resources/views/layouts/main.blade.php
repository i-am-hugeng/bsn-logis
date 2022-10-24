
<!DOCTYPE html>
<html lang="en">

<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie-edge">
  <meta http-equiv="cache-control" content="no-cache">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('adminlte/dist/img/favicon.ico') }}">

  <title>LOGIS{{ isset($title) ? ' | '.$title : '' }}</title>
  @include('layouts.inc.ext-css')
  @stack('css')
  <!-- Sweet Alert -->
  <script src="{{ asset('js/sweetalert2-10.5.0.all.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('css/sweetalert2-10.min.css') }}" id="theme-styles">

</head>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
    @include('layouts.inc.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    @include('layouts.inc.sidebar')
  <!-- /.Main Sidebar Container -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @yield('content-header')
    </section>

    <!-- Main content -->
    <section class="content">
        @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('layouts.inc.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@include('layouts.inc.ext-js')
@stack('js')
</body>
</html>
