<!DOCTYPE html>
<html lang="en">
<head>
    @php

use App\Helpers\getApp;

    @endphp
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ getApp::getAppName() }} | Login</title>

  <!-- Favicon Icon -->
  <link rel="icon" type="image/png" href="{{ url('storage/media/'.getApp::favicon()) }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
</head>
<body class="hold-transition login-page">
    <div class="pageloader"></div>

    <div class="login-box">

        <div class="login-logo">
          <a href=""><b>{{ getApp::getAppName() }} </b></a>
        </div>

    @section('layout_two_section')

    @show
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- Toastr -->
   <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    @stack('layout_two_scripts')
    </body>
    </html>





