<div class="market-trade-sell">
    <div class="box-body">
        <form method="post" action="{{ route('trader.orders.store') }}" id="sell_order_form"
            class="form-horizontal show-form-data" data-ajax-submission="y" data-reset-on-success="y">
            @csrf
            <input type="hidden" value="{{ base_key() }}" name="base_key">
            <input type="hidden" value="{{ EXCHANGE_SELL }}" name="{{ fake_field('exchange_type') }}">
            <input type="hidden" value="{{ CATEGORY_EXCHANGE }}" name="{{ fake_field('category') }}">
            <input type="hidden" value="{{ $stockPair->id }}" name="{{ fake_field('stock_pair_id') }}"
                class="stock-pair">
            <div class="input-group">
                <input type="text" class="form-control price" name="{{ fake_field('price') }}"
                    placeholder="{{ __('Price') }}">
                <div class="input-group-append text-uppercase">
                    <span class="base_item input-group-text"></span>
                </div>
            </div>

            <div class="input-group">
                <input type="text" class="form-control amount" name="{{ fake_field('amount') }}"
                    placeholder="{{ __('Amount') }}">
                <div class="input-group-append text-uppercase">
                    <span class="stock_item input-group-text"></span>
                </div>
            </div>

            <div class="input-group">
                <input type="text" class="form-control total" placeholder="{{ __('Total') }}">
                <span class="input-group-append text-uppercase">
                    <span class="base_item input-group-text"></span>
                </span>
            </div>

            @auth
            <div class="row">
                <div class="col-12 box-tools text-center" style="margin-top: -10px">
                    <a class="btn btn-box-tool" href="depositPageLink">{{ __('Deposit') }}
                        <span class="stock_item"></span>
                    </a>
                </div>
            </div>
            <div class="form-horizontal show-form-data">
                <div class="form-group margin-bottom-none">
                    <div class="row">
                        <label class="col-4 font-light margin-bottom-none">{{ __('You have') }}:</label>
                        <div class="col-8">
                            <div class="text-right">
                                <span class="clickable stock_item_balance"></span>
                                <span class="stock_item"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group margin-bottom-none">
                    <div class="row">
                        <label class="col-4 font-light margin-bottom-none">{{ __('Highest Bid') }}:</label>
                        <div class="col-8">
                            <div class=" text-right">
                                <span class="clickable highest_bid"></span>
                                <span class="base_item"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endauth

            <div style="margin-top: -10px">
                {{ __('Fee: :makerFee/:takerFee%',['makerFee' =>admin_settings('exchange_maker_fee'),'takerFee' => admin_settings('exchange_taker_fee')]) }}
            </div>

            @auth
            <button class="btn sell btn-sm btn-block form-submission-button" style="margin-top: -3px">{{ __('SELL') }}
                <span class="stock_item"></button>
            @endauth

            @guest
            <a href="{{ route('login') }}">{{__('Login')}}</a> {{ __('or') }} <a
                href="{{ route('register.index') }}">{{ __('Register') }}</a>{{ __(' to trade') }}
            @endguest
        </form>
    </div>
</div>