<div class="col-md-3">
    <div class="order-book">
        <h2 class="heading">Order Book</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Price(BTC)</th>
                    <th>Amount(ETH)</th>
                    <th>Total(ETH)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="red-bg-80">
                    <td class="red">0.022572</td>
                    <td>1.253415</td>
                    <td>15.27648</td>
                </tr>
                <tr class="red-bg-60">
                    <td class="red">0.020371</td>
                    <td>1.205415</td>
                    <td>15.25648</td>
                </tr>
                <tr class="red-bg-40">
                    <td class="red">0.023572</td>
                    <td>1.645415</td>
                    <td>15.23648</td>
                </tr>
                <tr class="red-bg-20">
                    <td class="red">0.032378</td>
                    <td>1.206715</td>
                    <td>15.25348</td>
                </tr>
                <tr class="red-bg-10">
                    <td class="red">0.022573</td>
                    <td>1.262415</td>
                    <td>15.19648</td>
                </tr>
                <tr class="red-bg-8">
                    <td class="red">0.154377</td>
                    <td>1.225415</td>
                    <td>15.35648</td>
                </tr>
                <tr class="red-bg-5">
                    <td class="red">0.120373</td>
                    <td>1.285415</td>
                    <td>15.25648</td>
                </tr>
                <tr class="red-bg">
                    <td class="red">0.028576</td>
                    <td>1.291415</td>
                    <td>15.26448</td>
                </tr>
            </tbody>
            <tbody class="ob-heading">
                <tr>
                    <td>
                        <span>Last Price</span>
                        0.020367
                    </td>
                    <td>
                        <span>USD</span>
                        148.65
                    </td>
                    <td class="red">
                        <span>Change</span>
                        -0.51%
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr class="green-bg">
                    <td class="green">0.158373</td>
                    <td>1.209515</td>
                    <td>15.23248</td>
                </tr>
                <tr class="green-bg-5">
                    <td class="green">0.020851</td>
                    <td>1.206245</td>
                    <td>15.25458</td>
                </tr>
                <tr class="green-bg-8">
                    <td class="green">0.025375</td>
                    <td>1.205715</td>
                    <td>15.65648</td>
                </tr>
                <tr class="green-bg-10">
                    <td class="green">0.020252</td>
                    <td>1.205495</td>
                    <td>15.24548</td>
                </tr>
                <tr class="green-bg-20">
                    <td class="green">0.020373</td>
                    <td>1.205415</td>
                    <td>15.25648</td>
                </tr>
                <tr class="green-bg-40">
                    <td class="green">0.020156</td>
                    <td>1.207515</td>
                    <td>15.28948</td>
                </tr>
                <tr class="green-bg-60">
                    <td class="green">0.540375</td>
                    <td>1.205915</td>
                    <td>15.25748</td>
                </tr>
                <tr class="green-bg-80">
                    <td class="green">0.020372</td>
                    <td>1.205415</td>
                    <td>15.25648</td>
                </tr>
            </tbody>
        </table>
    </div>
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
</div>