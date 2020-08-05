<!DOCTYPE html>
<html lang="en">
<head>
	<title>@yield('title') | {{ company_name() }}</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('common/images/favicon-32x32.png') }}">
	
    @yield('before-style')

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('logincss/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('logincss/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('logincss/vendor/animate/animate.css')}}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{asset('logincss/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('logincss/vendor/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('common/vendors/iCheck/flat/red.css') }}" />
	
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('logincss/css/util.css')}}">
	 <link rel="stylesheet" href="{{ asset('backend/assets/css/admin_lte.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/template_color.css') }}">
	 @if( env('APP_ENV') == 'production' && admin_settings('display_google_captcha') == ACTIVE_STATUS_ACTIVE )
        {!! NoCaptcha::renderJs() !!}
    @endif
	<link rel="stylesheet" type="text/css" href="{{asset('logincss/css/main.css')}}">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!--===============================================================================================-->
    @yield('after-style')

</head>

<body>
	<div class="limiter">
			 <div class="container-login100">

				@yield('login')
@include('errors.flash_message')


			</div>

	</div>


<!-- jQuery 3 -->

<!--===============================================================================================-->	
	<script src="{{asset('logincss/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('logincss/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('logincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('logincss/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('logincss/vendor/tilt/tilt.jquery.min.js')}}"></script>
<script src="{{ asset('common/vendors/iCheck/icheck.min.js') }}"></script>



<script src="{{ asset('backend/assets/js/custom.js') }}"></script>

	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="{{asset('logincss/js/main.js')}}"></script>
@yield('script-login')
</body>