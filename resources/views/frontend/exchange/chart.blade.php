<div class="row">
        <div class="col-md-12">
                <div class="exchange-loader" id="echart" style="width:100%; height: 550px;"></div>

        </div>
</div>

<div class="row">
    <div class="col-md-6 text-center">
<!--         {{-- <ul id="candlestick_zoom" class="pagination pagination-sm">
            <li class="active page-item"><span class="page-link">{{ __('Zoom') }}</span></li>
<li class="{{ $chartZoom == 360 ? 'disabled' : '' }} page-item"><a data-zoom="360" class="page-link"
                href="javascript:">{{ __('6h') }}</a></li>
<li class="{{ $chartZoom == 1440 ? 'disabled' : '' }} page-item"><a data-zoom="1440" class="page-link"
                href="javascript:">{{ __('1D') }}</a></li>
<li class="{{ $chartZoom == 2880 ? 'disabled' : '' }} page-item"><a data-zoom="2880" class="page-link"
                href="javascript:">{{ __('2D') }}</a></li>
<li class="{{ $chartZoom == 5760 ? 'disabled' : '' }} page-item"><a data-zoom="5760" class="page-link"
                href="javascript:">{{ __('4D') }}</a></li>
<li class="{{ $chartZoom == 10080 ? 'disabled' : '' }} page-item"><a data-zoom="10080" class="page-link"
                href="javascript:">{{ __('1W') }}</a></li>
<li class="{{ $chartZoom == 20160 ? 'disabled' : '' }} page-item"><a data-zoom="20160" class="page-link"
                href="javascript:">{{ __('2W') }}</a></li>
<li class="{{ $chartZoom == 43200 ? 'disabled' : '' }} page-item"><a data-zoom="43200" class="page-link"
                href="javascript:">{{ __('1M') }}</a></li>
<li class="{{ $chartZoom == 0 ? 'disabled' : '' }} page-item"><a data-zoom="0" class="page-link"
                href="javascript:">{{ __('All') }}</a></li>
</ul> --}} -->
</div>
<div class="col-md-6 text-center">
        <ul id="candlestick" class="pagination pagination-sm">
                <li class="active page-item"><span class="page-link">{{ __('Candlesticks') }}</span></li>
                <li class="{{ $chartInterval == 5 ? 'disabled' : '' }} page-item"><a data-interval="5" class="page-link"
                                href="javascript:">{{ __('5M') }}</a></li>
                <li class="{{ $chartInterval == 15 ? 'disabled' : '' }} page-item"><a data-interval="15"
                                class="page-link" href="javascript:">{{ __('15M') }}</a></li>
                <li class="{{ $chartInterval == 30 ? 'disabled' : '' }} page-item"><a data-interval="30"
                                class="page-link" href="javascript:">{{ __('30M') }}</a></li>
                <li class="{{ $chartInterval == 120 ? 'disabled' : '' }} page-item"><a data-interval="120"
                                class="page-link" href="javascript:">{{ __('2H') }}</a></li>
                <li class="{{ $chartInterval == 240 ? 'disabled' : '' }} page-item"><a data-interval="240"
                                class="page-link" href="javascript:">{{ __('4H') }}</a></li>
                <li class="{{ $chartInterval == 1440 ? 'disabled' : '' }} page-item"><a data-interval="1440"
                                class="page-link" href="javascript:">{{ __('1D') }}</a></li>
        </ul>
</div>
</div>