@extends('backend.layouts.top_navigation_layout')
@section('title', $title)
@section('after-style')
<!-- {{-- <link rel="stylesheet" href="{{ asset('common/vendors/mCustomScrollbar/jquery.mCustomScrollbar.min.css') }}"> --}} -->
<style>
    .container-market {
        padding: 5px 0;
    }

    .dataTables_filter {
        margin: 0 20%;

    }

    .border-btn {
        box-sizing: border-box;
        min-width: 0px;
        height: 40px;
        margin: 120px 0 -100px 0;
        border-width: 1px;
        border-style: solid;
        border-image: initial;
        border-radius: 3px;
        border-color: rgb(71, 77, 87);
        padding-top: 10px;
    }

    .border-btn-sell {
        box-sizing: border-box;
        min-width: 0px;
        height: 40px;
        margin: 119px 0 -100px 0;
        border-width: 1px;
        border-style: solid;
        border-image: initial;
        border-radius: 3px;
        border-color: rgb(71, 77, 87);
        padding-top: 10px;
    }

    .border-btn-sl {
        box-sizing: border-box;
        min-width: 0px;
        height: 40px;
        margin: 100px 0 -100px 0;
        border-width: 1px;
        border-style: solid;
        border-image: initial;
        border-radius: 3px;
        border-color: rgb(71, 77, 87);
        padding-top: 10px;
    }

    @media (max-width: 768px) {
        .container-market {
            padding: 5px 0;
        }

        .dataTables_filter {
            margin: 0 30%;
        }
    }

    #stock_market_table tbody tr:hover,
    #buy_order_table tbody tr:hover,
    #sell_order_table tbody tr:hover {
        cursor: pointer;
    }

    .no-clicke-header {
        pointer-events: none;
    }

    .filter {
        display: inline-block;
    }

    .exchange-table {
        font-size: 12px;
    }

    table.exchange-table {
        width: 100% !important;
    }

    table.exchange-table tr th,
    table.exchange-table tr td {
        /*text-align: right !important;*/
        padding-left: 5px;
        padding-right: 5px;
    }

    table.exchange-table tr th::after {
        font-size: 10px;
        right: 5px !important;
        bottom: 10px !important;
    }

    table.exchange-table tbody tr td {
        padding: 3px 5px;
    }

    table.exchange-table tbody tr.selected td {
        background: #cfffcf;
    }

    table.exchange-table tbody tr:first-child td {
        border-top: none !important;
    }

    table.exchange-table tr th {
        /*text-align: center !important;*/
        padding-right: 18px !important;
    }

    .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
        border: none;
        overflow: hidden !important;
    }

    .dataTables_scrollHeadInner {
        width: 100% !important;
    }

    .mCSB_scrollTools {
        right: -5px;
    }

    .mCS-dark-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {
        background: #b7deed;
        background: -moz-linear-gradient(left, #b7deed 0%, #71ceef 50%, #21b4e2 51%, #b7deed 100%);
        background: -webkit-linear-gradient(left, #b7deed 0%, #71ceef 50%, #21b4e2 51%, #b7deed 100%);
        background: linear-gradient(to right, #b7deed 0%, #71ceef 50%, #21b4e2 51%, #b7deed 100%);
    }

    .mCS-dark-thick.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar {
        background: #b7deed;
        background: -moz-linear-gradient(left, #b7deed 0%, #71ceef 50%, #21b4e2 51%, #b7deed 100%);
        background: -webkit-linear-gradient(left, #b7deed 0%, #71ceef 50%, #21b4e2 51%, #b7deed 100%);
        background: linear-gradient(to right, #b7deed 0%, #71ceef 50%, #21b4e2 51%, #b7deed 100%);
    }

    .mCS-dark-thick.mCSB_scrollTools .mCSB_draggerRail {
        background-color: #efefef;
    }

    .mCS-dark-thick.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar,
    .mCS-dark-thin.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar {
        background: #b7deed;
        background: -moz-linear-gradient(left, #b7deed 0%, #71ceef 50%, #21b4e2 51%, #b7deed 100%);
        background: -webkit-linear-gradient(left, #b7deed 0%, #71ceef 50%, #21b4e2 51%, #b7deed 100%);
        background: linear-gradient(to right, #b7deed 0%, #71ceef 50%, #21b4e2 51%, #b7deed 100%);
    }

    .mCSB_inside>.mCSB_container {
        margin-right: 10px;
    }

    .filter {
        width: 310px;
        position: relative;
    }

    .filter::after {
        content: '\f103';
        width: 25px;
        height: 100%;
        position: absolute;
        top: 0;
        right: 0;
        font-family: "FontAwesome";
        text-align: center;
        padding-top: 7px;
        color: #999;
    }

    #datatable-filter:focus {
        border: 1px solid #d2d6de;
        outline: none !important;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        height: 34px;
    }

    #datatable-filter {
        -moz-appearance: none;
        -webkit-appearance: none;
        /* padding-right: 20px; */
        position: relative;
        z-index: 99999999;
        background: none;
        color: black;
        /* color: rgba(0, 0, 0, 0);
        text-shadow: 0 0 0 #999;*/
    }

    #datatable-filter::-ms-expand {
        display: none;
    }

    @media all and (max-width: 420px) {
        .hide_in_mobile_small {
            display: none !important;
        }
    }

    @media all and (max-width: 512px) {
        .hide_in_mobile {
            display: none !important;
        }

        table.exchange-table tr td {
            font-size: 10px;
            padding: 3px;
        }

        .full-in-small {
            width: auto;
            margin-right: -15px;
            margin-left: -15px;
        }

        .full-in-small>div {
            padding-left: 8px !important;
            padding-right: 10px !important;
        }

        table.exchange-table.dataTable>tbody>tr.child>td {
            padding: 3px !important;
        }
    }

    @keyframes fadeGreen {
        from {
            background: rgba(0, 210, 0, 1);
        }

        to {
            background: rgba(0, 210, 0, 0);
        }
    }

    @keyframes fadeRed {
        from {
            background: rgba(210, 0, 0, 1);
        }

        to {
            background: rgba(210, 0, 0, 0);
        }
    }

    @keyframes fadeYellow {
        from {
            background: rgba(210, 210, 0, 1);
        }

        to {
            background: rgba(210, 210, 0, 0);
        }
    }

    .deleted {
        animation-name: fadeRed;
        animation-duration: 1s;
        animation-fill-mode: both;
    }

    .updated {
        animation-name: fadeYellow;
        animation-duration: 1s;
        animation-fill-mode: both;
    }

    .inserted {
        animation-name: fadeGreen;
        animation-duration: 1s;
        animation-fill-mode: both;
    }

    #candlestick_zoom li.disabled a,
    #candlestick li.disabled a {
        background: #fdb;
    }

    /* *ukuran desktop */
    @media (min-width: 992px) {
        #fixed-stock-market-toggler {
            display: none;
        }

        /* *MyCss */
        .nav-all {
            display: flex;
        }

        .nav-chart {
            order: 1;
        }

        .nav-market {
            order: 0;
        }
    }

    /* *ukuran mobile */
    @media (max-width: 992px) {
        #fixed-stock-market {
            transition: all 0.3s linear;
        }

        #fixed-stock-market i {
            display: none;
        }

        #fixed-stock-market.opened i {
            display: inline-block;
        }

        #fixed-stock-market.opened span {
            display: none;
        }

        #fixed-stock-market.opened {
            left: 0;
        }

        #fixed-stock-market-toggler.opened {
            left: 293px;
            transform: translateX(-100%);
        }

        #fixed-stock-market>div {
            background: #fff;
            height: 100%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        #fixed-stock-market-toggler:hover {
            background: #f3b60e !important;
        }

        #fixed-stock-market-toggler {
            background: #f39c12 !important;
            border-color: #f39c12 !important;
            position: absolute;
            top: 10px;
            left: 300px;
            transform: translateX(0);
            transition: all 0.3s linear;
            z-index: 3;
        }

        #fixed-stock-market .box-body {
            padding-left: 7px;
            padding-right: 7px;
        }

        #fixed-stock-market {
            position: absolute;
            top: 0;
            left: 0;
            left: -300px;
            width: 300px;
            height: 100%;
            margin: 0;
            z-index: 3;
            padding-top: 50px;
        }
    }

    .main-header {
        z-index: 4;
    }

    /*@media all and (max-width: 767px) {
            #fixed-stock-market {
                padding-top: 100px;
            }
        }*/
    @media all and (max-width: 640px) {

        #fixed-stock-market .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            float: right;
        }
    }

    @media all and (min-width: 1200px) {
        .summary-padding-fixer {
            padding-left: 50px;
        }
    }
</style>

@endsection
@section('content')
@include('frontend.exchange.stock_pair_summary')
<div class="container-fluid p-0">
    <div class="row no-gutters">
        @include('frontend.exchange.stock_market')
        <div class="col-md-6">
            <div class="main-chart">
                <!-- TradingView Widget BEGIN -->
<!--                 {{-- <div class="tradingview-widget-container">
                    <div id="tradingview_e8053"></div>
                    <script src="https://s3.tradingview.com/tv.js"></script>
                    <script>
                        new TradingView.widget(
                    {
                      "width": "100%",
                      "height": 550,
                      "symbol": "BITSTAMP:BTCUSD",
                      "interval": "D",
                      "timezone": "Etc/UTC",
                      "theme": "Light",
                      "style": "1",
                      "locale": "en",
                      "toolbar_bg": "#f1f3f6",
                      "enable_publishing": false,
                      "withdateranges": true,
                      "hide_side_toolbar": false,
                      "allow_symbol_change": true,
                      "show_popup_button": true,
                      "popup_width": "1000",
                      "popup_height": "650",
                      "container_id": "tradingview_e8053"
                    }
                  );
                    </script>
                </div> --}} -->
                <!-- TradingView Widget END -->
                @include('frontend.exchange.chart')
            </div>
            <div class="market-trade">
                <ul class="nav nav-pills" role="tablist">
               <!--      {{-- <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#pills-trade-limit" role="tab"
                            aria-selected="true">Limit</a>
                    </li> --}} -->
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#pills-market" role="tab"
                            aria-selected="false">Market</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#pills-stop-limit" role="tab"
                            aria-selected="false">Stop
                            Limit</a>
                    </li>
            <!--         {{-- <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#pills-stop-market" role="tab"
                            aria-selected="false">Stop
                            Market</a>
                    </li> --}} -->
                </ul>
                <div class="tab-content">
               <!--      {{-- <div class="tab-pane fade show active" id="pills-trade-limit" role="tabpanel">
                        <div class="d-flex justify-content-between">
                            @include('frontend.exchange.trading.buy_trade_limit_form')
                            @include('frontend.exchange.trading.sell_trade_limit_form')
                        </div>
                    </div> --}} -->
                    <div class="tab-pane fade show active" id="pills-market" role="tabpanel">
                        <div class="d-flex justify-content-between">
                            @include('frontend.exchange.trading.buy_trade_market_form')
                            @include('frontend.exchange.trading.sell_trade_market_form')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-stop-limit" role="tabpanel">
                        <div class="d-flex justify-content-between">
                            @include('frontend.exchange.trading.buy_stop_limit_form')
                        </div>
                    </div>
  <!--                   {{-- <div class="tab-pane fade" id="pills-stop-market" role="tabpanel">
                        <div class="d-flex justify-content-between">
                            @include('frontend.exchange.trading.buy_stop_market_form')
                            @include('frontend.exchange.trading.sell_stop_market_form')
                        </div>
                    </div> --}} -->
                </div>
            </div>
        </div>
        @include('frontend.exchange.order_book')
        @include('frontend.exchange.my_order')

    </div>
</div>
@endsection

@section('script')
<script src="{{asset('newAssets/js/bootstrap.min.js')}}"></script>

<script src="{{asset('common/vendors/bcmath/libbcmath-min.js')}}"></script>
<script src="{{asset('common/vendors/bcmath/bcmath.js')}}"></script>
<script src="{{asset('common/vendors/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('common/vendors/datatable_responsive/datatables/datatables.min.js')}}"></script>
<script src="{{asset('common/vendors/datatable_responsive/datatables/plugins/bootstrap/datatables.bootstrap.js')}}">
</script>
<script src="{{asset('common/vendors/echart/echarts.min.js')}}"></script>
<script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
<script src="{{asset('js/chart.js')}}"></script>
<script src="{{asset('common/vendors/cvalidator/cvalidator.js')}}"></script>

@include('frontend.exchange.initial_js')

@include('frontend.exchange.broadcast_js')

@include('frontend.exchange.custom_function_js')

@endsection