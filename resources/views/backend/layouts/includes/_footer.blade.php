{{-- <footer class="main-footer">
  Copyright &copy; {{ date("Y",strtotime("-1 year")).'-'.date('Y') }} <a
  href="{{ url('/') }}">{{ env('APP_NAME','Cryptomania') }}</a>. All rights reserved.
</footer> --}}

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
<script type="application/javascript">
  var btn_toggler = window.matchMedia("(max-width: 700px)")
  myFunction(btn_toggler) // Call listener function at run time
  btn_toggler.addListener(myFunction) // Attach listener function on state changes
  function myFunction(btn_toggler) {
      if (btn_toggler.matches) { // If media query matches
          $('.dot-sidebar').css({display: "block"});
          $('.sidebar-menu').css('display', 'none');
          $('.dot-sidebar').click(function(){
          // $('.sidebar-menu').toggle('slow', 'swing');
          $('.sidebar-menu').css({position: "absolute", background: "#ffffff"}).animate({width: 'toggle'}, 'slow', function(){
              $(this).css({zIndex: "1"}).siblings().css({zIndex: "0"});
          });
  });
      } 
      else {
          $('.dot-sidebar').css('display', 'none');
          $('.sidebar-menu').css('display', 'block');
      }
  }
</script>
{{-- new twmplate --}}
<script src="{{asset('newAssets/js/popper.min.js')}}"></script>
<script src="{{asset('newAssets/js/amcharts-core.min.js')}}"></script>
<script src="{{asset('newAssets/js/amcharts.min.js')}}"></script>
<script src="{{asset('newAssets/js/custom.js')}}"></script>
<script src="{{asset('newAssets/js/jquery.mCustomScrollbar.js')}}"></script>
@yield('script')
</body>

</html>