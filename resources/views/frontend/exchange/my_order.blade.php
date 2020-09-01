<div class="col-md-12">
    <div class="market-order active-order-list">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#order-history" role="tab" aria-selected="false">My
                    Order</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="order-history" role="tabpanel">
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