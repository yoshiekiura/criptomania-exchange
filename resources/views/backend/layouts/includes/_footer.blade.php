<footer class="main-footer">
    Copyright &copy; {{ date("Y",strtotime("-1 year")).'-'.date('Y') }} <a href="{{ url('/') }}">{{ env('APP_NAME','Cryptomania') }}</a>. All rights reserved.
</footer>

<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@include('errors.flash_message')
<!-- jQuery 3 -->
<script src="{{ asset('js/app.js') }}?t={{ random_string() }}"></script>
<script src="{{ asset('common/vendors/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('common/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('common/vendors/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/adminlte.min.js') }}"></script>
@yield('extraScript')
<script src="{{ asset('backend/assets/js/custom.js') }}"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
@yield('script')
</body>
</html>