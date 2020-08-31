<div class="col-md-12">
    <div class="market-order active-order-list">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#open-orders" role="tab" aria-selected="true">Sell
                    Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#stop-orders" role="tab" aria-selected="false">Buy
                    Orders</a>
            </li>
            @auth
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#order-history" role="tab" aria-selected="false">My
                    Order</a>
            </li>
            @endauth
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="open-orders" role="tabpanel">
                <ul class="d-flex justify-content-between market-order-item">
                    <li>Time</li>
                    <li>All pairs</li>
                    <li>All Types</li>
                    <li>Buy/Sell</li>
                    <li>Price</li>
                    <li>Amount</li>
                    <li>Executed</li>
                    <li>Unexecuted</li>
                </ul>
                <span class="no-data">
                    <i class="icon ion-md-document"></i>
                    No data
                </span>
            </div>
            <div class="tab-pane fade" id="stop-orders" role="tabpanel">
                <ul class="d-flex justify-content-between market-order-item">
                    <li>Time</li>
                    <li>All pairs</li>
                    <li>All Types</li>
                    <li>Buy/Sell</li>
                    <li>Price</li>
                    <li>Amount</li>
                    <li>Executed</li>
                    <li>Unexecuted</li>
                </ul>
                <span class="no-data">
                    <i class="icon ion-md-document"></i>
                    No data
                </span>
            </div>
            <div class="tab-pane fade" id="order-history" role="tabpanel">
                <table id="my_open_order_table" class="table table-hover table-responsive small exchange-table"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('TYPE') }}</th>
                            <th>{{ __('PRICE') }}</th>
                            <th>{{ __('AMOUNT') }}</th>
                            <th class="hide_in_mobile_small">{{ __('TOTAL') }}</th>
                            <th class="hide_in_mobile">{{ __('DATE') }}</th>
                            <th class="hide_in_mobile">{{ __('STOP') }}</th>
                            <th>{{ __('ACTION') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>