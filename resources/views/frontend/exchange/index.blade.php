@extends('backend.layouts.top_navigation_layout')
@section('title', $title)
@section('after-style')
{{-- <link rel="stylesheet" href="{{ asset('common/vendors/mCustomScrollbar/jquery.mCustomScrollbar.min.css') }}"> --}}
<style>
    .container-market {
        padding: 5px 0;
    }

    .dataTables_filter {
        margin: 0 20%;

    }

    @media (max-width: 768px) {
        .container-market {
            padding: 5px 0;
        }

        .dataTables_filter {
            margin: 0 30%;
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
                <div class="tradingview-widget-container">
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
                </div>
                <!-- TradingView Widget END -->
            </div>
            <div class="market-trade">
                <ul class="nav nav-pills" role="tablist">
                    {{-- <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#pills-trade-limit" role="tab"
                            aria-selected="true">Limit</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#pills-market" role="tab"
                            aria-selected="false">Market</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#pills-stop-limit" role="tab"
                            aria-selected="false">Stop
                            Limit</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#pills-stop-market" role="tab"
                            aria-selected="false">Stop
                            Market</a>
                    </li> --}}
                </ul>
                <div class="tab-content">
                    {{-- <div class="tab-pane fade show active" id="pills-trade-limit" role="tabpanel">
                        <div class="d-flex justify-content-between">
                            @include('frontend.exchange.trading.buy_trade_limit_form')
                            @include('frontend.exchange.trading.sell_trade_limit_form')
                        </div>
                    </div> --}}
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
                    {{-- <div class="tab-pane fade" id="pills-stop-market" role="tabpanel">
                        <div class="d-flex justify-content-between">
                            @include('frontend.exchange.trading.buy_stop_market_form')
                            @include('frontend.exchange.trading.sell_stop_market_form')
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        @include('frontend.exchange.order_book')
        @auth
        @include('frontend.exchange.my_order')
        @endauth

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
<script src="{{asset('js/chart.js')}}"></script>
<script src="{{asset('common/vendors/cvalidator/cvalidator.js')}}"></script>

@include('frontend.exchange.initial_js')

@include('frontend.exchange.broadcast_js')

@include('frontend.exchange.custom_function_js')

@endsection