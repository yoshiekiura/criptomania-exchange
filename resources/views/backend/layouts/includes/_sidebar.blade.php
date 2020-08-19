<div class="col-md-12 col-lg-3">
    {{-- <a class="nav-link active" id="settings-profile-tab" data-toggle="pill" href="#settings-profile" role="tab"
            aria-controls="settings-profile" aria-selected="true"><i class="icon ion-md-person"></i> Profile</a>
        <a class="nav-link" id="settings-wallet-tab" data-toggle="pill" href="#settings-wallet" role="tab"
            aria-controls="settings-wallet" aria-selected="false"><i class="icon ion-md-wallet"></i> Wallet</a>
        <a class="nav-link" id="settings-tab" data-toggle="pill" href="#settings" role="tab" aria-controls="settings"
            aria-selected="false"><i class="icon ion-md-settings"></i> Settings</a> --}}
    {!! get_nav('back-end') !!}
</div>

{{-- new template --}}
<script type="application/javascript" src="{{asset('newAssets/js/jquery-3.4.1.min.js')}}"></script>
<script type="application/javascript" src="{{asset('newAssets/js/popper.min.js')}}"></script>
<script type="application/javascript" src="{{asset('newAssets/js/bootstrap.min.js')}}"></script>
<script type="application/javascript" src="{{asset('newAssets/js/amcharts-core.min.js')}}"></script>
<script type="application/javascript" src="{{asset('newAssets/js/amcharts.min.js')}}"></script>
<script type="application/javascript" src="{{asset('newAssets/js/custom.js')}}"></script>
<script type="application/javascript">
    //active button
    $('.active').find('a').addClass('active');
    
    // dropdown submenu
    // $("a[href$='javascript:;']").addClass('sub-menu');
    // $('.sub-menu').append('<i class="fa fa-caret-down" aria-hidden="true"></i>');
    // $('.fa-caret-down').addClass('drop-icon');
    // bug main content
    // var drop_show = $('.active').parents();
    // $(drop_show).toggleClass('show');
    
    var dropdown = $('.sub-menu');
    var i;
    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            // $(this).find('.drop-icon').toggleClass('rotate');
            var dropdownContent = this.nextElementSibling;
            $(dropdownContent).each(function(){
                if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
                } else {
                dropdownContent.style.display = "block";
                }
            })
        });
    }
    
    
    
</script>