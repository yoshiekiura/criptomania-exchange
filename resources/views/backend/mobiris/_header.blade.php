<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ company_name() }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('common/images/favicon-32x32.png') }}">
    @yield('before-style')
    <link rel="stylesheet" href="{{ asset('common/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/admin_lte.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/template_color.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('common/vendors/iCheck/all.css') }}">

  <link rel="stylesheet" href="{{ asset('mobiris/web/assets/mobirise-icons-bold/mobirise-icons-bold.css') }}">
  <link rel="stylesheet" href="{{ asset('mobiris/web/assets/mobirise-icons/mobirise-icons-bold.css/mobirise-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('mobiris/tether/tether.min.css') }}">
  <link rel="stylesheet" href="{{ asset('mobiris/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('mobiris/bootstrap/css/bootstrap-grid.min.css') }}">
  <link rel="stylesheet" href="{{ asset('mobiris/bootstrap/css/bootstrap-reboot.min.css') }}">
  <link rel="stylesheet" href="{{ asset('mobiris/dropdown/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('mobiris/theme/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('mobiris/mobirise/css/mbr-additional.css') }}" type="text/css">

    <!-- for datatable and date picker -->
    <link rel="stylesheet" href="{{ asset('common/vendors/datepicker/datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('common/vendors/datatable_responsive/datatables/plugins/bootstrap/datatables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('common/vendors/datatable_responsive/datatables/datatables.min.css') }}">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>



    @yield('after-style')
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @if( env('APP_ENV') != 'local' && admin_settings('display_google_captcha') == ACTIVE_STATUS_ACTIVE )
        {!! NoCaptcha::renderJs() !!}
    @endif

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>