<div id="fixed-stock-market">
    <div>
        <div class="box box-borderless">
            <button id="fixed-stock-market-toggler" class="btn btn-primary"><i class="fa fa-bars"></i> <span class="stock_item"></span><span>/</span><span class="base_item"></span></button>
            <div class="box-header">
                <h3 class="box-title text-uppercase">{{ __('Markets') }}</h3>
            </div>
            <div class="box-body" id="stock-market-section">
                <table id="stock_market_table" class="table table-hover table-responsive small exchange-table">
                    <thead>
                    <tr>
                        <th>{{ __('STOCK') }}</th>
                        <th>{{ __('PRICE') }}</th>
                        <th>{{ __('VOLUME') }}</th>
                        <th>{{ __('CHANGE') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>

        <div class="nav-tabs-custom full-in-small" style="cursor: move;">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li class="active">
                    <a href="#market_trade" data-toggle="tab" aria-expanded="false">{{ __('MARKET TRADES') }}</a>
                </li>
                @auth
                    <li class="">
                        <a href="#my_trade" data-toggle="tab" aria-expanded="true">{{ __('MY TRADES') }}</a>
                    </li>
                @endauth
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="market_trade">
                    <table id="trade_history_table" class="table table-hover table-responsive small exchange-table"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th class="hide_in_mobile">{{ __('DATE') }}</th>
                            <th class="text-center">{{ __('PRICE') }}</th>
                            <th class="text-center">{{ __('AMOUNT') }}</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
                @auth
                    <div class="tab-pane" id="my_trade">
                        <table id="my_trade_table" class="table table-hover table-responsive small exchange-table"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th class="hide_in_mobile">{{ __('DATE') }}</th>
                                <th>{{ __('TYPE') }}</th>
                                <th class="text-center">{{ __('PRICE') }}</th>
                                <th class="text-center">{{ __('AMOUNT') }}</th>
                                <th class="text-center hide_in_mobile_small">{{ __('TOTAL') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                @endauth
            </div>
        </div>
        </div>
    </div>
</div>