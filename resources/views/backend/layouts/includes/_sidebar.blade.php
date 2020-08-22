<div class="col-md-12 col-lg-3">
    <button class="navbar-toggler dot-sidebar" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <i class="icon ion-md-more"></i>
    </button>
    {!! get_nav('back-end') !!}
</div>

{{-- new template --}}
@section('extraScript')
<script type="application/javascript" src="{{asset('newAssets/js/jquery-3.4.1.min.js')}}"></script>
<script type="application/javascript" src="{{asset('newAssets/js/popper.min.js')}}"></script>
<script type="application/javascript" src="{{asset('newAssets/js/bootstrap.min.js')}}"></script>
<script type="application/javascript" src="{{asset('newAssets/js/amcharts-core.min.js')}}"></script>
<script type="application/javascript" src="{{asset('newAssets/js/amcharts.min.js')}}"></script>
<script type="application/javascript" src="{{asset('newAssets/js/custom.js')}}"></script>
@endsection