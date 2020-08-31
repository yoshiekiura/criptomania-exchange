<div class="col-md-3">
    <div class="market-history" style="overflow:auto">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#market_trade" role="tab"
                    aria-selected="true">{{ __('MARKET TRADES') }}</a>
            </li>
            @auth
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#my_trade" role="tab"
                    aria-selected="false">{{ __('MY TRADES') }}</a>
            </li>
            @endauth
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="market_trade" role="tabpanel">
                <table id="trade_history_table" class="table table-hover table-responsive small exchange-table"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">{{ __('PRICE') }}</th>
                            <th class="text-center">{{ __('AMOUNT') }}</th>
                            <th class="hide_in_mobile">{{ __('DATE') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
            @auth
            <div class="tab-pane fade show" id="my_trade" role="tabpanel">
                <table id="my_trade_table" class="table table-hover table-responsive small exchange-table"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">{{ __('PRICE') }}</th>
                            <th class="text-center">{{ __('AMOUNT') }}</th>
                            <th class="hide_in_mobile">{{ __('DATE') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
            @endauth
        </div>
    </div>
    <div class="active-order">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#buy_orders" role="tab"
                    aria-selected="true">{{ __('BUY ORDERS') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#sell_orders" role="tab"
                    aria-selected="false">{{ __('SELL ORDERS') }}</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="buy_orders" role="tabpanel">
                <table id="buy_order_table" class="table table-hover table-responsive small exchange-table"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('PRICE') }}</th>
                            <th><span class="stock_item"></span></th>
                            <th><span class="base_item"></span></th>
                            <th class="hide_in_mobile_small">{{ __('SUM') }}(<span class="base_item"></span>)</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="tab-pane fade show" id="sell_orders" role="tabpanel">
                <table id="sell_order_table" class="table table-hover table-responsive small exchange-table"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('PRICE') }}</th>
                            <th><span class="stock_item"></span></th>
                            <th><span class="base_item"></span></th>
                            <th class="hide_in_mobile_small">{{ __('SUM') }}(<span class="base_item"></span>)</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>